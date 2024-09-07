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
            @else action={{route('transactions.store')}}
            @endif
    >
        @csrf
        @isset($transaction)
            @method('PUT')
        @endif

        <div class="form-box">
            <label for="">Account</label>
            <select name="account">
                <option value="">Select</option>
            </select>
        </div>

        <div class="form-box">
            <label for="">Fund: </label>
            <select name="fund" id="">
                <option>Select</option>
                <option value="11">CFVLX</option>
                <option value="12">FBIOX</option>
            </select>
            @error( 'name' )
            <div class="alert alert-danger">{{ $message  }}</div>
            @enderror
        </div>

        <div class="form-box">
            <label for="">Acquired</label>
            <input type="date">
        </div>
        <div class="form-box">
            <label for="">Quantity</label>
            <input type="number">
        </div>
        <div class="form-box">
            <label for="">Average Cost Basis</label>
            $<input type="number" step="any">
        </div>
    </form>
</x-app-layout>
