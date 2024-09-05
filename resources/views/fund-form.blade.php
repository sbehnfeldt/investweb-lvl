<x-app-layout>
    <x-slot name="header">
        <h2>
            @isset($fund)
                {{ __('Edit Fund') }}
            @else
                {{ __('Create Fund') }}
            @endif
        </h2>
    </x-slot>

    <form method="POST"
          @isset($fund)action="{{route('funds.update', $fund->id)}}"
          @else action="{{ route('funds.store') }}"
            @endif
    >
        @csrf

        @isset($fund)
            @method('PUT')
        @endif

        <div class="form-box">
            <label for="">Name: </label>
            <input type="text" class="@error('name') invalid @enderror" name="name"
                   @isset($old[ 'name' ])value="{{$old[ 'name' ]}}@endisset">
            @error( 'name' )
            <div class="alert alert-danger">{{ $message  }}</div>
            @enderror
        </div>

        <div class="form-box">
            <label for="">Symbol: </label>
            <input type="text" class="@error('symbol') invalid @enderror" name="symbol"
                   @isset($old[ 'symbol'])value="{{$old[ 'symbol']}}"@endisset >
            @error('symbol')
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
        @vite('resources/js/fund-form.js')
    </x-slot>


</x-app-layout>
