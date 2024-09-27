<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends Component
{

    use WithPagination;
    public $isEdit = false;
    public $permission_id, $name;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|unique:permissions,name',
    ];

    public function render()
    {
        $permissions = ModelsPermission::where('name', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.permission', ['permissions' => $permissions]);
    }

    public function resetFields()
    {
        $this->name = '';
        $this->permission_id = null;
        $this->isEdit = false;
    }
    public function store()
    {
        $this->validate();
        ModelsPermission::create([
            'name' => $this->name,
        ]);
        session()->flash('message', 'Permission Inserted successfully!');
        $this->resetFields();
    }
    public function edit($id)
    {
        $permission = ModelsPermission::findOrFail($id);
        $this->name = $permission->name;
        $this->permission_id = $permission->id;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        $permission = ModelsPermission::findOrFail($this->permission_id);
        $permission->update([
            'name' => $this->name,
        ]);
        session()->flash('message', 'Permission Updated successfully!');
        $this->resetFields();
    }

    public function cancelUpdate()
    {
        $this->resetFields(); // Resets all input fields
        $this->isEdit = false; // Exit update mode
    }

    public function delete($id)
    {
        ModelsPermission::findOrFail($id)->delete();
        $this->resetFields();
    }
}
