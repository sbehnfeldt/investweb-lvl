<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Funds') }}</h2>
    </x-slot>

    <div class="buttons">
        <button class="primary" id="newResource">New</button>
        <button disabled id="viewResource">View</button>
        <button disabled id="editResource">Edit</button>
        <button disabled id="deleteResource">Delete</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <x-slot name="scripts">
        @vite('resources/js/funds.js')
    </x-slot>

</x-app-layout>
