<x-app-layout>
    <x-slot name="header">
        <h2>
            @isset($transaction)
                {{ __('Edit Transaction') }}
            @else
                {{ __('New Transaction') }}
            @endif
        </h2>

    </x-slot>

    <form method="POST"
          @isset($transaction)action={{route('transactions.update', $transaction->id)}}
            @else action="{{route('transactions.store')}}"
            @endif
    >
        @csrf

        @isset($transaction)
            @method('PUT')
        @endif

        <div class="form-box">
            <label for="">Account</label>
            <select name="account_id">
                <option value="">Select</option>
            </select>
        </div>

        <div class="form-box">
            <label for="">Fund: </label>
            <select name="fund_id" id="">
                <option>Select</option>
            </select>
            @error( 'name' )
            <div class="alert alert-danger">{{ $message  }}</div>
            @enderror
        </div>

        <div class="form-box">
            <label for="">Acquired</label>
            <input type="date" name="acquired">
        </div>
        <div class="form-box">
            <label for="">Quantity</label>
            <input type="number" step="any" name="quantity">
        </div>
        <div class="form-box">
            <label for="">Average Cost Basis</label>
            $<input type="number" step="any" name="avg_cost_basis">
        </div>

        <button id="submitFormButton" class="primary">Submit</button>
        <button id="cancelFormButton">Cancel</button>
    </form>

    <x-slot name="scripts">
        @vite('resources/js/transaction-form.js')
    </x-slot>
</x-app-layout>
