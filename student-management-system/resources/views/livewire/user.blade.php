<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Default Setting Start Here --}}
                    <div class="flex justify-between">
                        <h1 class="text-2xl font-bold mb-4">All Users</h1>
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
                            <h1 class="text-center">{{ $isEdit ? 'Edit' : 'Create' }} User</h1>
                            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                                <div class="mb-4">
                                    <label for="name" class="block">Name</label>
                                    <input type="text" wire:model="name" class="border p-2 w-full">
                                    @error('name')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="block">Email</label>
                                    <input type="email" wire:model="email" class="border p-2 w-full">
                                    @error('email')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="block">Password</label>
                                    <input type="password" wire:model="password" class="border p-2 w-full">
                                    @error('password')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="roles" class="block">Roles</label>
                                    <select wire:model="roles" multiple
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}">{{ $role }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <x-button type="submit">{{ $isEdit ? 'Update' : 'Save' }}
                                    User</x-button>
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
                                        <th class="px-6 py-3">Roles</th>
                                        <th class="px-6 py-3 rounded-e-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $user->id }}</td>
                                            <td class="px-6 py-4">{{ $user->name }}</td>
                                            <td class="px-6 py-4">
                                                @if (!empty($user->getRoleNames()))
                                                    @foreach ($user->getRoleNames() as $rolename)
                                                        <span
                                                            class="rounded-full bg-blue-500 text-white px-3 py-1">{{ $rolename }}</span>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <x-secondary-button wire:click="edit({{ $user->id }})"
                                                    class="btn btn-primary">Edit</x-secondary-button>
                                                <x-secondary-button wire:click="delete({{ $user->id }})"
                                                    class="btn btn-danger">Delete</x-secondary-button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                    {{-- Default Setting End Here --}}
                </div>
            </div>
        </div>
    </div>
</div>
