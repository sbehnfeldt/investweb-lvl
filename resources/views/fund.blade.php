<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Fund') }}</h2>

        <a class="button" href="{{route('funds.index')}}">&larr;{{ __('Back') }}</a>
    </x-slot>

    <h3><strong>{{ $fund->name . '(' . $fund->symbol . ')' }}</strong></h3>

    <p>{{$fund->description}}</p>

</x-app-layout>
