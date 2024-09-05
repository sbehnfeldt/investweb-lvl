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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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

                        <button id="submitFormButton">Submit</button>
                        <button id="cancelFormButton">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        @vite('resources/js/fund-form.js')
    </x-slot>


</x-app-layout>
