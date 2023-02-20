@php
    $addresses = data_get($response,'data.addresses',[])
@endphp
@if($addresses)
    <div class="p-10 py-4 text-left">
        <p>@lang('Coinbase::labels.coinbase.payment-hint')</p>

        <ul class="list-unstyled">
            @foreach(data_get($response,'data.addresses',[])??[] as $key=>$address)
                <li class="p-b-10 pb-3">{{ ucfirst($key) }}:<br/> {!! generateCopyToClipBoard($key,$address) !!}</li>
            @endforeach
        </ul>
        @if($hostedUrl = data_get($response,'data.hosted_url'))
            <a href="{{ $hostedUrl }}" target="_blank" class="btn btn-primary">
                @lang('Coinbase::labels.coinbase.pay_here')
            </a>
        @endif
    </div>
@endif
