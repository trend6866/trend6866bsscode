@php
$store = $place_order_data["store"];
@endphp

    <script src="{{ asset('public/js/jquery-3.6.0.min.js') }}"></script>

        <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
        <script src="{{ asset('public/js/jquery.form.js') }}"></script>
        <script>
            $( document ).ready(function () {
                var coupon_id = '';
                var API_publicKey = 'FLWPUBK_TEST-05113ace39b840b31bcd365f532858ca-X';
                var nowTim = "{{ date('d-m-Y-h-i-a') }}";
                var order_id = '{{$order_id = time()}}';
                var slug = '{{$store}}';
                var flutter_callback = "{{ url('store-payment-flutterwave') }}";
                var currency = '{{$place_order_data['currency']}}'
                var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: '{{$place_order_data['email']}}',
                amount: '{{$place_order_data['total_price']}}',
                currency: currency,

                txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) +
                    'fluttpay_online-' +
                    {{ date('Y-m-d') }},
                meta: [{
                    metaname: "payment_id",
                    metavalue: "id"
                }],
                onclose: function() {},
                callback: function(response) {
                    var txref = response.tx.txRef;
                    if (
                    response.tx.chargeResponseCode == "00" ||
                    response.tx.chargeResponseCode == "0"
                    ) {
                        window.location.href =  "{{ url('/') }}"+'/'+slug + '/store-payment-flutterwave/'  + txref + '/' + order_id;

                    } else {
                    // redirect to a failure page.
                    }
                    x
                    .close(); // use this to close the modal immediately after payment.
                }
                });
            // } else if (res.flag == 2) {

            // } else {
            //     show_toastr('Error', data.message, 'msg');
            // }

});
 </script>
