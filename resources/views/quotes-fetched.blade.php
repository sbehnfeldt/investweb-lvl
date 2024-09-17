<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quotes Fetched') }}</h2>


        <a class="button" href="{{route('quotes.index')}}">&larr; {{ __('Back') }}</a>
    </x-slot>

    <section>
        <h3>Unquoted</h3>
        <ul>
            @foreach($unquoted as $symbol => $quote)
                @isset($quote->price)
                    <li>{{$symbol}}: {{$quote->price}} ({{$quote->latest_trading_day}})</li>
                @else
                    <li>{{$symbol}}: {{$quote}}</li>
                @endisset
            @endforeach
        </ul>
    </section>

    @foreach(collect($quotes)->keys()->sort() as $date )
        <section>
            <h3>{{$date}}</h3>
            <ul>
                @foreach ($quotes[$date] as $symbol => $quote)
                    @isset($quote->price)
                        <li>{{$symbol}}: {{$quote->price}} ({{$quote->latest_trading_day}})</li>
                    @else
                        <li>{{$symbol}}: {{$quote}}</li>
                    @endisset
                @endforeach
            </ul>
        </section>
    @endforeach

    <x-slot name="scripts">
        {{--    @vite('resources/js/quotes.js')--}}
    </x-slot>

</x-app-layout>
