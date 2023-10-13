<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
        <div class="flex justify-end">
            <a href="{{route('tasks.index')}}"
               class="hover:bg-green-700 font-semibold text-md text-gray-800 py-2 px-4 rounded">Tasks List</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('tasks.store')}}" method="post">
                        @csrf
                        <div class="mb-6">
                            <label for="title"
                                   class="block mb-2 text-sm font-medium text-red-700">Title</label>
                            <input type="text" id="title"
                                   class="block p-2 w-full text-md text-black bg-gray-50 rounded-md border focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Task Title" name="title" value="{{old('title')}}">
                            @error('title')
                            <p class="mt-2 text-sm text-red-600"><span
                                    class="font-medium">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="assignee" class="block mb-2 text-sm font-medium text-red-700">Select The Assignee</label>
                            <select id="assignee" name="assignee"
                                    class="block p-2 w-full text-md text-black bg-gray-50 rounded-md border focus:ring-blue-500 focus:border-blue-500">
                            </select>
                            @error('assignee')
                            <p class="mt-2 text-sm text-red-600"><span
                                    class="font-medium">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="description"
                                   class="block mb-2 text-sm font-medium text-red-700">Description</label>
                            <textarea id="description" rows="4"
                                      class="block p-2 w-full text-md text-black bg-gray-50 rounded-md border focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Task Description"
                                      name="description">{{old('description')}}</textarea>
                            @error('description')
                            <p class="mt-2 text-sm text-red-600"><span
                                    class="font-medium">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="text-black font-medium rounded-lg text-md sm:w-auto p-2 bg-blue-700">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            console.log('ready')
            $('#assignee').select2({
                ajax: {
                    url: '{{route('selectors.users', ['type' => 2])}}',
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data.data
                        };
                    }
                }
            });
        });
    </script>
</x-app-layout>
