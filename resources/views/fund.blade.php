<x-app-layout>
    <x-slot name="header">
        <h2>
            Fund
        </h2>

        <a class="button" href="{{route('funds.index')}}">&larr;{{ __('Back') }}</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3><strong>{{ $fund->name . '(' . $fund->symbol . ')' }}</strong></h3>

                    <p>{{$fund->description}}</p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
