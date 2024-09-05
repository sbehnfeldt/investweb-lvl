<x-app-layout>
    <x-slot name="header">
        <h2>
            @isset($account)
                {{ __( 'Edit Account') }}
            @else
                {{ __('Create Account') }}
            @endif
        </h2>
    </x-slot>

    <form method="POST"
          @isset($account) action="{{route('accounts.update', $account->id)}}"
          @else action="{{ route('accounts.store') }}"
            @endif
    >
        @csrf
        @isset($account)
            @method('PUT')
        @endif

        <div class="form-box">
            <label for="">Company: </label>
            <input type="text" class="@error('name') invalid @enderror" name="company"
                   @isset($old[ 'company' ])value="{{$old[ 'company' ]}}@endisset">
            @error( 'company' )
            <div class="alert alert-danger">{{ $message  }}</div>
            @enderror
        </div>

        <div class="form-box">
            <label for="">Identifier: </label>
            <input type="text" class="@error('symbol') invalid @enderror" name="identifier"
                   @isset($old[ 'identifier'])value="{{$old[ 'identifier']}}"@endisset >
            @error('identifier')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
        </div>

        <div class="form-box">
            <label for="">Description: </label>
            <textarea class="@error('description') invalid @enderror" name="description">@isset($old[ 'description'])
                    {{$old[ 'description']}}
                @endisset</textarea>
            @error('description')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
        </div>

        <button id="submitFormButton" class="primary">Submit</button>
        <button id="cancelFormButton">Cancel</button>
    </form>

    <x-slot name="scripts">
        @vite('resources/js/account-form.js')
    </x-slot>

</x-app-layout>
