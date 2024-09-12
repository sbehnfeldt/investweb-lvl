<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Import Transactions') }}</h2>
    </x-slot>

    <form method="POST" action="{{route('transactions.import')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-box">
            <label for="">Account</label>
            <select name="account_id" id="">
                <option value="">Select an Account</option>
                @foreach($accounts as $account)
                    <option value="{{$account->id}}">{{$account->description}}
                        ({{$account->company}} {{ $account->identifier }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-box">
            <label for="">Fund</label>
            <select name="fund_id" id="">
                <option value="">Select a Fund</option>
                @foreach($funds as $fund)
                    <option value="{{$fund->id}}">{{$fund->symbol}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-box">
            <label for="">File to Import:</label>
            <input type="file" name="transactions">
        </div>
        <button type="submit" name="submit">Import</button>
    </form>
</x-app-layout>
