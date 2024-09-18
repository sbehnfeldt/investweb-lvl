<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Transaction Import Results') }}</h2>
    </x-slot>

    <ul>
        @foreach($results as $i => $r)
            <li>{{ $i + 1 }}. {{ $r }}</li>
        @endforeach
    </ul>
</x-app-layout>
