<?php

namespace App\Http\Controllers;

use App\Direccion;
use App\Lineapedidos;
use App\Mail\EnviarFactura;
use App\Order;
use App\OrderItem;
use App\Pedido;
use App\Producto;
use App\Transportista;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class paypalController extends BaseController
{
    private $_api_context;

    public function __construct()
    {
        // setup PayPal api context
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function postPayment(Request $request)
    {
        //Mirar como incluir iva
        session_start();
        $_SESSION['direccion'] = $request->input('direccion');
        $_SESSION['transportista'] = explode(" - ", $request->input('transportista'))[0];
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $items = array();
        $subtotal = 0;
        $cart = $_SESSION['carrito'];
        $currency = 'EUR';

        foreach ($cart as $producto) {
            $item = new Item();
            $item->setName($producto[1]['nombre'])
                ->setCurrency($currency)
                ->setQuantity($producto[0])
                ->setPrice($producto[1]['precio_venta'] * 1.21);
            $subtotal += $producto[0] * ($producto[1]['precio_venta'] * 1.21);
            array_push($items, $item);
        }
        $item_list = new ItemList();
        $item_list->setItems($items);
        $amount = new Amount();
        $total = 0;
        if ($subtotal < 40) {
            $shipping = DB::table('transportistas')->where('razon_social', '=', $request->input('transportista'))->get()[0]->precio;//cambiar por la consulta del transportista que seleccione el user
            $total = $shipping + $subtotal;
            $details = new Details();
            $details->setSubtotal($subtotal)
                ->setShipping($shipping);
            $amount->setCurrency($currency)
                ->setTotal($total)->setDetails($details);
        } else {
            $total = $subtotal;
            $amount->setCurrency($currency)
                ->setTotal($total);
        }
        $_SESSION['precio'] = $total;
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Pedido de prueba en mi Laravel App Store');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(\URL::route('payment.status'))
            ->setCancelUrl(\URL::route('payment.status'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                exit;
            } else {
                die('Ups! Algo salió mal');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        // add payment ID to session
        $_SESSION['paypal_payment_id'] = $payment->getId();

        if (isset($redirect_url)) {
            // redirect to paypal
            return \Redirect::away($redirect_url);
        }

        return \Redirect::route('comprar');

    }

    public function getPaymentStatus()
    {
        session_start();
        // Get the payment ID before session clear
        $payment_id = $_SESSION['paypal_payment_id'];
        // clear the session payment ID
        $_SESSION['paypal_payment_id'] = null;

        $payerId = $_GET['PayerID'];
        $token = $_GET['token'];

        if (empty($payerId) || empty($token)) {
            return \Redirect::route('home')->with('message', 'Hubo un problema al intentar pagar con Paypal');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            $this->saveOrder();
            $this->sendFactura();
            return Redirect::route('home')->with('message', 'Compra realizada de forma correcta, se ha enviado un correo con la factura,además puede consultarse desde mi perfil,gracias por confiar en nosotros');
        }
        return Redirect::route('home')->with('message', 'La compra fue cancelada');
    }

    protected function saveOrder()
    {
        $t = DB::table("transportistas")->where('razon_social', '=', $_SESSION['transportista'])->get()[0];
        $transportista = Transportista::find($t->id);
        $d = DB::table("direcciones")->where('domicilio', '=', $_SESSION['direccion'])->where('id_usuario', '=', Auth::id())->get()[0];
        $direccion = Direccion::find($d->id);
        $pedido = new Pedido();
        $pedido->fecha_pedido = date("Y-m-d");
        $pedido->id_direccion = $direccion->id;
        $pedido->id_transportista = $transportista->id;
        $pedido->metodo_pago = "paypal";
        $pedido->id_usuario = Auth::id();
        $pedido->fecha_entrega = date("Y-m-d", strtotime($pedido->fecha_pedido . '+' . $transportista->duracion . 'days'));
        $pedido->total = $_SESSION['precio'];
        $pedido->save();
        $cart = $_SESSION['carrito'];
        foreach ($cart as $producto) {
            $factura = new Lineapedidos();
            $factura->id_pedido = $pedido->id;
            $factura->id_producto = $producto[1]['id'];
            $factura->precio = $producto[1]['precio_venta'];
            $factura->cantidad = $producto[0];
            $factura->save();
            $productoC = Producto::find($producto[1]['id']);
            $productoC->stock_actual = $productoC->stock_actual - $producto[0];
            $productoC->save();
        }
        session_destroy();
    }

    private function sendFactura()
    {
        Mail::to(Auth::user())->send(new EnviarFactura(Pedido::all()->last()));
    }
}
