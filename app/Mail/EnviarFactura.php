<?php

namespace App\Mail;

use App\Direccion;
use App\Lineapedidos;
use App\Pedido;
use App\Transportista;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarFactura extends Mailable
{
    use Queueable, SerializesModels;
    public $pedido;

    /**
     * Create a new message instance.
     *
     * @param Pedido $pedido
     */
    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pedido = $this->pedido;
        $pedido = Pedido::find($pedido->id);
        $facturas = Lineapedidos::all()->where('id_pedido', '=', $pedido->id);
        $pdf = \PDF::loadView('pdf', ['cod_factura' => '000' . $pedido->id, 'direccion' => Direccion::find($pedido->id_direccion), 'transportista' => Transportista::find($pedido->id_transportista), 'factura' => $facturas])->output();
        return $this->view('Mail.Facturas')->attachData($pdf, "factura.pdf");
    }
}
