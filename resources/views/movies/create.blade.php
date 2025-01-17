<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add a movie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form action="{{ route('movies.store') }}" method="POST">
                        @csrf
                        <div>
                            <x-label for="title" :value="__('Title')" />
                            <x-input class="block mt-1 w-full" type="text" id="title" name="title" max="255" :value="old('title')" required/>
                        </div>
                        <div class="mt-4">
                            <x-label for="description" :value="__('Description')" />
                            <x-textarea class="block mt-1 w-full" type="text" id="description" name="description" :value="old('description')" required/>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">{{ __('Add Movie') }}</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
