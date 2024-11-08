<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product as ModelsProduct;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;


class Product extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $isEdit = false;
    public $product_id, $name, $description, $price, $category_id, $images = [];
    public $categories;

    public $search = '';

    protected $rules = [
        'name' => 'required|string',
        'description' => 'sometimes',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'images.*' => 'nullable|mimes:png,jpg,jpeg'
    ];

    public function render()
    {
        $this->categories = Category::all();
        $products = ModelsProduct::paginate(10);
        return view('livewire.product', ['products' => $products]);
    }

    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
        $this->price = null;
        $this->category_id = null;
        $this->images = null;
        $this->isEdit = false;
    }

    public function store()
    {
        // dd($this->validate());
        if ($this->images != null) {
            $product = ModelsProduct::create($this->validate());
            foreach ($this->images as $image) {
                $imagePath = $image->store('products', 'public');
                $product->images()->create(['path' => $imagePath]);
            }
        } else {
            $product = ModelsProduct::create($this->validate());
        }
        session()->flash('message', 'Product Inserted successfully!');
        $this->resetFields();
    }
    public function edit($id)
    {
        $product = ModelsProduct::findOrFail($id);
        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->category_id = $product->category_id;
        $this->isEdit = true;
        $this->images = $product->images;
    }

    public function cancelUpdate()
    {
        $this->resetFields(); // Resets all input fields
        $this->isEdit = false; // Exit update mode
    }

    public function deleteProductImage($id)
    {
        // dd($id);
        $productImage=ProductImage::findOrFail($id);
        if ($productImage->path && Storage::disk('public')->exists($productImage->path)) {
            Storage::disk('public')->delete($productImage->path);
        }
        $productImage->delete();
        // $this->resetFields();
        session()->flash('message-product-delete', 'Product Image deleted successfully!');
        // $this->emit('$refresh');

    }
}
