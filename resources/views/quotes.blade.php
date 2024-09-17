<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Quotes') }}</h2>
    </x-slot>

    <div class="buttons">
        <button id="fetchQuotes">Fetch</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>Fund</th>
                <th>Trade Date</th>
                <th>Price</th>
            </tr>
        </thead>

        <tbody/>
    </table>

    <x-slot name="scripts">
        @vite('resources/js/quotes.js')
    </x-slot>

</x-app-layout>
