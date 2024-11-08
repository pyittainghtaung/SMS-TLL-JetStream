<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    {{-- This is teacher Page. {{ $academic_id }} --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Default Setting Start Here --}}
                    <div class="flex justify-between">
                        <h1 class="text-2xl font-bold mb-4">All Teachers</h1>
                        <div
                            class="flex items-center justify-between gap-2 mb-8 text-right rounded-lg border-solid border-2 border-yellow-500 p-2">
                            <label for="search">Search</label>
                            <input type="text" wire:model.lazy="search" class="border p-2 w-full">
                            @error('search')
                                <span class="text-red-500 block">{{ $message }}</span>
                            @enderror
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
                            <h1 class="font-semibold text-xl text-center mb-3">{{ $isEdit ? 'Edit' : 'Create' }}
                                Teachers</h1>
                            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}"
                                enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label for="name" class="block">Teacher Name</label>
                                    <input type="text" wire:model="name" class="border p-2 w-full">
                                    @error('name')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="gender" class="block">Gender</label>
                                    {{-- <input type="text" wire:model="gender" class="border p-2 w-full"> --}}
                                    <select wire:model="gender" id="gender" class="border p-2 w-full">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    @error('gender')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="student_nrc_no" class="block">Teacher NRC No</label>
                                    <input type="text" wire:model="teacher_nrc_no" class="border p-2 w-full">
                                    @error('teacher_nrc_no')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="name" class="block">Teacher Education</label>
                                    <input type="text" wire:model="education" class="border p-2 w-full">
                                    @error('education')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="address" class="block">Address</label>
                                    {{-- <input type="text" wire:model="address" class="border p-2 w-full"> --}}
                                    <textarea wire:model="address" id="address" class="border p-2 w-full" rows="5"></textarea>
                                    @error('address')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="contact_phone_no" class="block">Contact Phone Number</label>
                                    <input type="text" wire:model="contact_phone_no" class="border p-2 w-full">
                                    @error('contact_phone_no')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="image" class="block">Upload Image</label>
                                    <input type="file" id="image" wire:model="image" class="border p-2 w-full">
                                    {{-- <input type="text" wire:model="available_people" class="border p-2 w-full"> --}}
                                    @error('available_people')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <x-button type="submit">{{ $isEdit ? 'Update' : 'Save' }}
                                    Teacher</x-button>
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
                                        <th class="px-6 py-3">Name</th>
                                        <th class="px-6 py-3 rounded-e-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teachers as $teacher)
                                        <tr wire:key="{{ $teacher->id }}">
                                            <td
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $teacher->id }}</td>
                                            <td class="px-6 py-4">{{ $teacher->name }}</td>
                                            <td class="px-6 py-4">
                                                <div class="flex gap-2">
                                                    {{-- <a wire:navigate href="{{ route('students', ['academic' => $academic->id]) }}">Students</a>
                                                    <a wire:navigate href="{{ route('hostels', ['academic' => $academic->id]) }}">Hostels</a>
                                                    <a wire:navigate href="{{ route('grades', ['academic' => $academic->id]) }}">Grades</a> --}}
                                                    <x-secondary-button wire:click="edit({{ $teacher->id }})"
                                                        class="btn btn-primary">Edit</x-secondary-button>
                                                    <x-secondary-button wire:click="delete({{ $teacher->id }})"
                                                        class="btn btn-danger">Delete</x-secondary-button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $teachers->links() }}
                        </div>
                    </div>
                    {{-- Default Setting End Here --}}
                </div>
            </div>
        </div>
    </div>
</div>
