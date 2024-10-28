<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $academic_name }} > {{ $grade_name  }} > {{ __('Sections') }}
        </h2>
        <h3>
              <x-nav-link wire:navigate href="{{ route('grades',$academic_id) }}" :active="request()->routeIs('grades')">
                        {{ __('Grades') }}
                    </x-nav-link>
        </h3>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Default Setting Start Here --}}
                    <div class="flex justify-between">
                        <h1 class="text-2xl font-bold mb-4">All Sections</h1>
                        <div
                            class="flex items-center justify-between gap-2 mb-8 text-right rounded-lg border-solid border-2 border-yellow-500 p-2">
                            {{-- <x-link-button href="">Add New</x-link-button> --}}
                            {{-- HELLO --}}
                            <label for="search">Search</label>
                            {{-- 7. Use wire:model.lazy
                            If you want the search property to only update after the input loses focus, you can try
                            using wire:model.lazy: --}}
                            <input type="text" wire:model.lazy="search" class="border p-2 w-full">
                            {{-- @error('search')
                                <span class="text-red-500 block">{{ $message }}</span>
                            @enderror --}}
                            {{-- <x-primary-button type="submit">Search</x-primary-button> --}}
                        </div>
                    </div>
                    {{-- <div class="flex justify-between border-solid border-2 border-indigo-600 p-2"> --}}
                    <div class="flex justify-between flex-col sm:flex-row gap-2">
                        <div class="basis-1/3 rounded-lg border-solid border-2 border-green-500 p-2">
                            @if (session()->has('message'))
                                <div class="bg-green-500 text-white p-2">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <h1 class="text-center">{{ $isEdit ? 'Edit' : 'Create' }} Sections</h1>
                            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                                <div class="mb-4">
                                    <label for="academic_id" class="block">Academic</label>
                                    <input type="text" wire:model="academic_name" class="border p-2 w-full" disabled>
                                    @error('academic_name')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                    {{-- <select id="academic_id" wire:model="academic_id" class="border p-2 w-full"
                                        disabled>
                                        <option value="">-- Select Academic --</option>
                                        @foreach ($academics as $academic)
                                            <option value="{{ $academic->id }}">{{ $academic->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('academic_id')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror --}}
                                </div>
                                <div class="mb-4">
                                    <label for="grade" class="block">Grade</label>
                                    <input type="text" wire:model="grade_name" class="border p-2 w-full" disabled>
                                    @error('grade_name')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                    {{-- <select id="grade_id" wire:model="grade_id" class="border p-2 w-full">
                                        <option value="">-- Select Grade --</option>
                                        @foreach ($grades as $grade)
                                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('grade_id')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror --}}
                                </div>
                                <div class="mb-4">
                                    <label for="name" class="block">Name</label>
                                    <input type="text" wire:model="name" class="border p-2 w-full">
                                    @error('name')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <x-button type="submit">{{ $isEdit ? 'Update' : 'Save' }}
                                    Section</x-button>
                                @if ($isEdit)
                                    <x-secondary-button type="button" wire:click="cancelUpdate"
                                        class="btn btn-secondary">
                                        Cancel
                                    </x-secondary-button>
                                @endif
                            </form>
                        </div>
                        <div class="basis-2/3 overflow-x-auto rounded-lg border-solid border-2 border-red-500 p-2">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                    <tr class="w-full">
                                        <th class="px-6 py-3 rounded-s-lg">ID</th>
                                        <th class="px-6 py-3">Grade</th>
                                        <th class="px-6 py-3">Name</th>
                                        <th class="px-6 py-3 rounded-e-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sections as $section)
                                        <tr wire:key={{ $section->id }}>
                                            <td
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $section->id }}</td>
                                            <td class="px-6 py-4">{{ $section->grade->name }}</td>
                                            <td class="px-6 py-4">{{ $section->name }}</td>
                                            <td class="px-6 py-4">
                                                <div class="flex gap-2">
                                                    <x-secondary-button wire:click="edit({{ $section->id }})"
                                                        class="btn btn-primary">Edit</x-secondary-button>
                                                    <x-secondary-button wire:click="delete({{ $section->id }})"
                                                        class="btn btn-danger">Delete</x-secondary-button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $sections->links() }}
                        </div>
                    </div>
                    {{-- Default Setting End Here --}}
                </div>
            </div>
        </div>
    </div>
</div>
