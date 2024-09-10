<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Import Transactions') }}</h2>
    </x-slot>

    <form method="POST" action="{{route('transactions.import')}}">
        @csrf
        <div class="form-box">
            <label for="">File to Import:</label>
            <input type="file">
        </div>
        <button>Import</button>
    </form>
</x-app-layout>
