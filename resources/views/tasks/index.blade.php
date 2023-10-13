<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
        <div class="flex justify-end">
            <a href="{{route('tasks.create')}}" class="hover:bg-green-700 font-semibold text-md text-gray-800 py-2 px-4 rounded">Create Task</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-12">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-scroll">
                                <table class="w-full text-left text-sm font-light table-auto">
                                    <thead class="border-b font-medium dark:border-neutral-500">
                                    <tr>
                                        <th scope="col" class="px-6 py-4">#</th>
                                        <th scope="col" class="px-6 py-4">Title</th>
                                        <th scope="col" class="px-6 py-4">Description</th>
                                        <th scope="col" class="px-6 py-4">Assignee Name</th>
                                        <th scope="col" class="px-6 py-4">Assigner Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($tasks) == 0)
                                        <tr>
                                            <td class="p-4 font-semibold align-middle text-center" colspan="5">No Tasks Yet.</td>
                                        </tr>
                                    @else
                                        @foreach($tasks as $idx => $task)
                                            <tr class="border-b dark:border-neutral-500">
                                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{$idx+1}}</td>
                                                <td class="whitespace-nowrap px-6 py-4">{{$task->title}}</td>
                                                <td class="whitespace-nowrap px-6 py-4">{{$task->description}}</td>
                                                <td class="whitespace-nowrap px-6 py-4">{{$task->assignedTo->name}}</td>
                                                <td class="whitespace-nowrap px-6 py-4">{{$task->assignedBy->name}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>

                                <div class="mt-4 mb-4">
                                    {{ $tasks->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
