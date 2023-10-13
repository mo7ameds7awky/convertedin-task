<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-12">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-scroll">
                                <table class="w-full text-left text-sm font-light table-auto mb-4">
                                    <thead class="border-b font-medium dark:border-neutral-500">
                                    <tr>
                                        <th scope="col" class="px-6 py-4">#</th>
                                        <th scope="col" class="px-6 py-4">Admin Name</th>
                                        <th scope="col" class="px-6 py-4">Tasks Count</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($stats) == 0)
                                        <tr>
                                            <td class="p-4 font-semibold align-middle text-center" colspan="3">No statistics Yet.</td>
                                        </tr>
                                    @else
                                        @foreach($stats as $idx => $stat)
                                            <tr class="border-b dark:border-neutral-500">
                                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{$idx+1}}</td>
                                                <td class="whitespace-nowrap px-6 py-4">{{$stat->user->name}}</td>
                                                <td class="whitespace-nowrap px-6 py-4">{{$stat->tasks_count}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
