<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Default Setting Start Here --}}
                    <div class="flex justify-between">
                        <h1 class="text-2xl font-bold mb-4">All Roles</h1>
                        <div
                            class="flex items-center justify-between gap-2 mb-8 text-right rounded-lg border-solid border-2 border-green-500 p-2">
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
                                <div class="bg-green-500 text-white p-2 rounded-lg">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <h1 class="text-center">{{ $isEdit ? 'Edit' : 'Create' }} Roles</h1>
                            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                                <div class="mb-4">
                                    <label for="name" class="block">Name</label>
                                    <input type="text" wire:model="name" class="border p-2 w-full">
                                    @error('name')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <x-button type="submit">{{ $isEdit ? 'Update' : 'Save' }}
                                    Role</x-button>
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
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $role->id }}</td>
                                            <td class="px-6 py-4">{{ $role->name }}</td>
                                            <td class="px-6 py-4">
                                                <div class="flex gap-2">
                                                    <x-secondary-button wire:click="addPermissionToRole({{ $role->id }})"
                                                        class="btn btn-primary">Add Permission To Role</x-secondary-button>
                                                    <x-secondary-button wire:click="edit({{ $role->id }})"
                                                        class="btn btn-primary">Edit</x-secondary-button>
                                                    <x-secondary-button wire:click="delete({{ $role->id }})"
                                                        class="btn btn-danger">Delete</x-secondary-button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $roles->links() }}
                        </div>
                    </div>
                    {{-- Default Setting End Here --}}
                </div>
            </div>
        </div>
    </div>
</div>
