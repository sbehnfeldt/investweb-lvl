<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Account') }}</h2>

        <a class="button" href="{{route('accounts.index')}}">&larr;{{ __('Back') }}</a>
    </x-slot>

    <h3><strong>{{ $account->company . ' ' . $account->identifier  }}</strong></h3>

    <p>{{$account->description}}</p>

</x-app-layout>
