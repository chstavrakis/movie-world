<x-app-layout>
    <div class="mt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(count($movies) > 0)
                <h1 class="mb-4">Found {{ count($movies) . ' '. (count($movies) > 1 ? __('movies') : __('movie'))}}</h1>
            @endif
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color: #6b72801f">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between">
                        <!-- Movies Section -->
                        <div class="w-3/4">
                            @if (count($movies) > 0)
                                <div class="grid grid-cols-1 gap-6">
                                    @foreach($movies as $movie)
                                        <div class="bg-white p-6 rounded-lg shadow-md">
                                            <div class="flex justify-between">
                                                <h1 class="flex items text-xl font-semibold">{{ $movie->title }}</h1>
                                                <small class="flex justify-end">{{ __('Posted') .' '. $movie->created_at->format('d/m/Y')  }}</small>
                                            </div>
                                            <p class="mt-2">{{ $movie->description }}</p>
                                            <div class="mt-4 flex items-end">
                                                <p class="text-sm text-gray-600">{{ $movie->likes_count }} likes | </p>
                                                <p class="ml-1 text-sm text-gray-600">{{ $movie->hates_count }} hates</p>
                                                <p class="mx-auto text-sm text-gray-600">
                                                    Posted by: <a href="{{ route('movies.list') }}?author={{$movie->user->id}}" class="lightblue">{{ $movie->user->name }}</a>
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <h1>{{ __('No movies found') }}.</h1>
                            @endif
                        </div>
                        <!-- Filters Section -->
                        <div class="pl-4">
                            @auth
                                <div class="mb-4 p-1">
                                    <a href="{{ route('movies.create') }}"
                                       style="background-color: #a1cf52"
                                       class="inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md shadow-sm bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        {{ __('New Movie') }}
                                    </a>
                                </div>
                            @endauth
                            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                                <form method="GET" action="{{ route('movies.list') }}">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Sort by:</label>
                                        <div class="mt-1">
                                            <label class="inline-flex items-center">
                                                <input
                                                    type="radio"
                                                    name="sort"
                                                    value="likes"
                                                    class="form-radio lightblue"
                                                    @if($sort === 'likes') checked @endif
                                                >
                                                <span class="ml-2">Likes</span>
                                            </label>
                                        </div>
                                        <div class="mt-1">
                                            <label class="inline-flex items-center">
                                                <input
                                                    type="radio"
                                                    name="sort"
                                                    value="hates"
                                                    class="form-radio lightblue"
                                                    @if($sort === 'hates') checked @endif
                                                >
                                                <span class="ml-2">Hates</span>
                                            </label>
                                        </div>
                                        <div class="mt-1">
                                            <label class="inline-flex items-center">
                                                <input
                                                    type="radio"
                                                    name="sort"
                                                    value="dates"
                                                    class="form-radio lightblue"
                                                    @if($sort === 'dates') checked @endif
                                                >
                                                <span class="ml-2">Dates</span>
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md shadow-sm bg-lightblue-600 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Apply') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
