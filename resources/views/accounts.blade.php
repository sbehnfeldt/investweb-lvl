<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Accounts') }}
        </h2>
    </x-slot>

    <div class="buttons">
        <button class="primary" id="newAccount">New</button>
        <button disabled id="viewAccount">View</button>
        <button disabled id="editAccount">Edit</button>
        <button disabled id="deleteAccount">Delete</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Company</th>
                <th>Identifier</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <x-slot name="scripts">
        @vite('resources/js/accounts.js')
    </x-slot>

</x-app-layout>
