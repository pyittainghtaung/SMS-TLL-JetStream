<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Permission to Rols') }}
        </h2>
    </x-slot>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 border-2 border-green-500">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
            {{-- Custom Code Start Here --}}
            @if (session()->has('message'))
                <div class="bg-green-500 text-white">
                    {{ session('message') }}
                </div>
            @endif
            <h1 class="text-2xl font-semibold mb-4">Role: {{ $role->name }}</h1>
            {{-- {{ dd($rolePermissions) }} --}}
            <form wire:submit.prevent="submit">
                <div class="mb-4">
                    @error('permission')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                    <label for="permission" class="block text-gray-700 mb-4">Permissions</label>
                    <div class="grid grid-cols-4">
                        @foreach ($permissions as $permission)
                            <label>
                                <input type="checkbox" wire:model="allPermissions" value="{{ $permission->name }}" />
                                {{-- No Need to check with in_array() function --}}
                                {{-- Yes, that's exactly the issue! Livewire takes control over the state of the checkboxes
                                with its wire:model binding, so manual HTML attributes like checked using in_array() are
                                overridden by Livewire’s reactive data model. Once Livewire binds the value of a
                                checkbox through wire:model, it no longer considers the checked attribute that you
                                manually set via Blade.

                                This is why using in_array() directly in the HTML to mark checkboxes as checked doesn't
                                work when you are using Livewire. The Livewire framework expects the state of the
                                checkboxes to be fully controlled by its own data bindings, in this case, the wire:model
                                directive. --}}
                                {{ $permission->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <x-secondary-button wire:click="givePermissionToRole()" class="btn btn-primary">Update
                        Permission</x-secondary-button>
                </div>
            </form>
            {{-- Custom Code End Here --}}
        </div>
    </div>
</div>
