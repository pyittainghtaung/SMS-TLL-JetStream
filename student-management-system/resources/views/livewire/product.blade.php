<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Default Setting Start Here --}}
                    <div class="flex justify-between">
                        <h1 class="text-2xl font-bold mb-4">All Products</h1>
                        <div
                            class="flex items-center justify-between gap-2 mb-8 text-right rounded-lg border-solid border-2 border-yellow-500 p-2">
                            <label for="search">Search</label>
                            {{-- 7. Use wire:model.lazy
                            If you want the search property to only update after the input loses focus, you can try
                            using wire:model.lazy: --}}
                            <input type="text" wire:model.lazy="search" class="border p-2 w-full">
                            @error('search')
                                <span class="text-red-500 block">{{ $message }}</span>
                            @enderror
                            {{-- <x-primary-button type="submit">Search</x-primary-button> --}}
                        </div>
                    </div>
                    {{-- < class="flex justify-between border-solid border-2 border-indigo-600 p-2"> --}}
                    <div class="flex justify-between flex-col sm:flex-row gap-2">
                        <div class="basis-1/3 rounded-lg border-solid border-2 border-green-500 p-2">
                            @if (session()->has('message'))
                                <div class="bg-green-500 text-white p-2">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <h1 class="text-center">{{ $isEdit ? 'Edit' : 'Create' }} Product</h1>
                            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}"
                                enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label for="name" class="block">Name</label>
                                    <input type="text" wire:model="name" class="border p-2 w-full">
                                    @error('name')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="description" class="block">Description</label>
                                    <input type="text" wire:model="description" class="border p-2 w-full">
                                    @error('description')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="name" class="block">Price</label>
                                    <input type="text" wire:model="price" class="border p-2 w-full">
                                    @error('price')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="category_id" class="block">Category</label>
                                    <select id="category_id" wire:model="category_id" class="border p-2 w-full">
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="images" class="block">Images</label>
                                    <input type="file" id="images" wire:model="images" class="border p-2 w-full"
                                        multiple>
                                    @error('images')
                                        <span class="text-red-500 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <x-button type="submit">{{ $isEdit ? 'Update' : 'Save' }}
                                    Category</x-button>
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
                                        <th class="px-6 py-3">Description</th>
                                        <th class="px-6 py-3">Price</th>
                                        <th class="px-6 py-3">Total Images</th>
                                        <th class="px-6 py-3 rounded-e-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr wire:key="{{ $product->id }}">
                                            <td
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $product->id }}</td>
                                            <td class="px-6 py-4">{{ $product->name }}</td>
                                            <td class="px-6 py-4">{{ $product->description }}</td>
                                            <td class="px-6 py-4">{{ $product->price }}</td>
                                            <td class="px-6 py-4">Total Images</td>
                                            {{-- <td>
                                                @if ($category->image)
                                                    <img src="{{ asset('storage/' . $category->image) }}"
                                                        class="h-24 w-24 border-gray-500 border-2 p-2 m-3 rounded">
                                                @else
                                                    No Image
                                                @endif
                                            </td> --}}
                                            <td class="px-6 py-4">
                                                <div class="flex gap-2">
                                                    {{-- <x-secondary-button wire:click="edit({{ $product->id }})"
                                                        class="btn btn-primary">Images</x-secondary-button> --}}
                                                    <x-secondary-button wire:click="edit({{ $product->id }})"
                                                        class="btn btn-primary">Edit</x-secondary-button>
                                                    <x-secondary-button wire:click="delete({{ $product->id }})"
                                                        class="btn btn-danger">Delete</x-secondary-button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $products->links() }}
                        </div>
                    </div>
                    @if ($isEdit == true)
                        <h1 class="text-2xl font-bold mt-4">Images Sections Here</h1>
                        @if (session()->has('message-product-delete'))
                            <div class="bg-green-500 text-white p-2">
                                {{ session('message-product-delete') }}
                            </div>
                        @endif
                        <div class="flex flex-wrap gap-4 mt-3 p-3">
                            @foreach ($images as $productImage)
                                <div class="flex-none rounded-lg border-solid border-2 border-blue-500 text-center p-2">
                                    <img src="{{ asset('storage/' . $productImage->path) }}"
                                        class="h-24 w-24 border-gray-500 border-2 p-2 m-3">
                                    <x-secondary-button wire:click="deleteProductImage({{ $productImage->id }})"
                                        class="btn btn-danger">Delete</x-secondary-button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    {{-- Default Setting End Here --}}
                </div>
            </div>
        </div>
    </div>
</div>
