<div class="row">
    <div class="col-md-12">
        @php \Actions::do_action('pre_coinbase_checkout_form',$gateway) @endphp
        <form action="{{ url($action) }}" method="post" id="payment-form" class="ajax-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <div class="row">
                <div class="col-md-8">
                    <h3>{{ $gateway->getName() }}</h3>

                    <div class="panel panel-default">
                        <div class="panel-heading"><h4>@lang('Coinbase::labels.coinbase.payment_instructions')</h4>
                        </div>
                        <div class="panel-body p-10">
                            {!! $gateway->getPaymentInstructions() !!}
                        </div>
                    </div>

                    <input type='hidden' name='checkoutToken' value='Coinbase'/>
                    <input type='hidden' name='gateway' value='Coinbase'/>
                </div>
            </div>
        </form>
    </div>
</div>
