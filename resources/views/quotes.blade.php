<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quotes') }}</h2>
    </x-slot>

    <x-slot name="scripts">
        @vite('resources/js/quotes.js')
    </x-slot>

</x-app-layout>
