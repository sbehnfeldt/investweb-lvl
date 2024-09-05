<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Transactions') }}</h2>
    </x-slot>

    <div class="buttons">
        <button class="primary" id="newTransaction">New</button>
        <button disabled id="viewTransaction">View</button>
        <button disabled id="editTransaction">Edit</button>
        <button disabled id="deleteTransaction">Delete</button>
    </div>

    <div class="accounts">

    </div>

    {{--    <table>--}}
    {{--        <thead>--}}
    {{--            <tr>--}}
    {{--                <th>Acquired</th>--}}
    {{--                <th>Quantity</th>--}}
    {{--                <th>Current Value</th>--}}
    {{--            </tr>--}}
    {{--        </thead>--}}
    {{--        <tbody>--}}
    {{--        </tbody>--}}
    {{--    </table>--}}

    <x-slot name="scripts">
        @vite('resources/js/transactions.js')
    </x-slot>

</x-app-layout>
