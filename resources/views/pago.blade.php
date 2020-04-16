@extends('layouts.app')

@section('content')
    <div class="col-sm-auto">
        <div class="row mx-1 justify-content-center">
            <div class="col-7">
                <div id="paypal-button-container"></div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        paypal.Buttons({
            createOrder: function () {
                {{--return fetch('{{ route('api.paypal.set-up-transaction') }}', {--}}
                {{--    method: 'post',--}}
                {{--    headers: {--}}
                {{--        'content-type': 'application/json'--}}
                {{--    }--}}
                {{--}).then(function(res) {--}}
                {{--    return res.json();--}}
                {{--}).then(function(data) {--}}
                {{--    return data.result.id;--}}
                {{--});--}}
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    {{--return fetch('{{ route('api.paypal.verify-transaction') }}', {--}}
                    {{--    method: 'post',--}}
                    {{--    headers: {--}}
                    {{--        'content-type': 'application/json'--}}
                    {{--    },--}}
                    {{--    body: JSON.stringify({--}}
                    {{--        orderID: data.orderID--}}
                    {{--    })--}}
                    {{--});--}}
                });
            }
        }).render('#paypal-button-container');</script>
@endsection
