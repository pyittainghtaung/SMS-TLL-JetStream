<?php

namespace App\Livewire;

use App\Models\Category as ModelsCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Category extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $isEdit = false;
    public $category_id, $name, $description, $image, $is_active = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|unique:academics,name',
        'description' => 'required|max:255|string',
        'image' => 'nullable|mimes:png,jpg,jpeg',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $categories = ModelsCategory::where('name', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.category', ['categories' => $categories]);
    }

    public function resetFields()
    {
        $this->name = '';
        $this->category_id = null;
        $this->description = '';
        $this->image = '';
        $this->is_active = false;
        $this->isEdit = false;
    }

    public function store()
    {
        // dd($this->validate());
        $this->validate();
        $imagePath = $this->image ? $this->image->store('categories', 'public') : null;

        ModelsCategory::create([
            'name' => $this->name,
            'description' => $this->name,
            'image' => $imagePath,
            'is_active' => $this->is_active,
        ]);
        session()->flash('message', 'Image Inserted successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $category = ModelsCategory::findOrFail($id);
        $this->name = $category->name;
        $this->category_id = $category->id;
        $this->description = $category->description;
        // This part is important when use checkbox in your code
        $this->is_active = $category->is_active == 1 ? true : false;
        // $this->image = $category->image;
        $this->isEdit = true;
    }

    public function update()
    {
        // dd($this->all());
        $this->validate();
        $category = ModelsCategory::findOrFail($this->category_id);
        $oldImagePath = $category->image;
        // If a new image is uploaded, update it
        if ($this->image) {
            $newImagePath = $this->image->store('categories', 'public');
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
            $this->image = $newImagePath;
        } else {
            $this->image = $oldImagePath;
        }
        $category->update([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'is_active' => $this->is_active,
        ]);
        session()->flash('message', 'Image Updated successfully!');
        $this->resetFields();
    }

    public function cancelUpdate()
    {
        $this->resetFields(); // Resets all input fields
        $this->isEdit = false; // Exit update mode
    }

    public function delete($id)
    {
        $category = ModelsCategory::findOrFail($id);
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();
        $this->resetFields();
        session()->flash('message', 'Category deleted successfully!');
    }
}
