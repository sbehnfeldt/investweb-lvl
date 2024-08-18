<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
                    <form
                            @isset($fund)action="/funds/{{$fund.id}}" method="put"
                            @else action="{{ route('funds.store') }}" method="post"
                            @endif
                    >
                        @csrf

                        <div class="form-box">
                            <label for="">Name: </label>
                            <input type="text" name="name">
                        </div>

                        <div class="form-box">
                            <label for="">Symbol: </label>
                            <input type="text" name="symbol">
                        </div>

                        <div class="form-box">
                            <label for="">Description: </label>
                            <textarea name="description"></textarea>
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
