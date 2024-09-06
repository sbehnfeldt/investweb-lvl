<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Positions') }}</h2>
    </x-slot>

    <div class="accounts">

    </div>

    <x-slot name="scripts">
        @vite('resources/js/positions.js')
    </x-slot>

</x-app-layout>
