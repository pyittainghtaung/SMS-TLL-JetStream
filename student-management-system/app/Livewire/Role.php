<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends Component
{
    use WithPagination;

    public $viewType;
    public $isEdit = false;
    public $role_id, $name;
    public $search = '';

    public $role;
    public $rolePermissions = [];


    public $addPermission = false;
    public $allPermissions = [];

    protected $rules = [
        'name' => 'required|string|unique:roles,name',
    ];

    public function mount($viewType = 'role')
    {
        $this->viewType = $viewType;
    }

    public function render()
    {
        if ($this->viewType === 'role') {
            $roles = ModelsRole::where('name', 'like', '%' . $this->search . '%')->paginate(10);
            return view('livewire.role', ['roles' => $roles]);
        } elseif ($this->viewType === 'add-permission') {
            $allPermissionsData = Permission::all();
            //The selected permissions
            $this->allPermissions = $this->role->permissions->pluck('name')->all();
            return view('livewire.add-permission', ['role' => $this->role, 'permissions' => $allPermissionsData]);
        }
    }
    public function resetFields()
    {
        $this->name = '';
        $this->role_id = null;
        $this->isEdit = false;
    }
    public function store()
    {
        $this->validate();
        ModelsRole::create([
            'name' => $this->name,
        ]);
        session()->flash('message', 'Role Inserted successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $role = ModelsRole::findOrFail($id);
        $this->name = $role->name;
        $this->role_id = $role->id;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        $role = ModelsRole::findOrFail($this->role_id);
        $role->update([
            'name' => $this->name,
        ]);
        session()->flash('message', 'Role Updated successfully!');
        $this->resetFields();
    }
    public function cancelUpdate()
    {
        $this->resetFields(); // Resets all input fields
        $this->isEdit = false; // Exit update mode
    }

    public function delete($id)
    {
        ModelsRole::findOrFail($id)->delete();
        $this->resetFields();
    }

    public function addPermissionToRole($id)
    {
        $this->viewType = 'add-permission';
        $this->role = ModelsRole::findOrFail($id);
    }

    public function givePermissionToRole()
    {
        $this->role->syncPermissions($this->allPermissions);
        session()->flash('message', 'Checked Valued Updated successfully!');
    }
}
