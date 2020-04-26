<ul>
    @foreach($payments->payments as $payment)
        <li>
            @include('modules.plugins.payment::paypal.detail', compact('payment'))
        </li>
    @endforeach
</ul>
