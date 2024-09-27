<?php

namespace App\Livewire;

use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;


class User extends Component
{
    use WithPagination;
    public $isEdit = false;

    public $search = '';
    public $user_id;
    public $name, $email, $password;

    public $roles = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|max:20',
        'roles' => 'required',
    ];
    public function render()
    {
        $this->roles = Role::pluck('name', 'name')->all();
        $users = ModelsUser::where('name', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.user', ['users' => $users]);
    }
    public function resetFields()
    {
        $this->name = '';
        $this->user_id = null;
        $this->email = '';
        $this->password = '';
        $this->roles = [];
        $this->isEdit = false;
    }
    public function store()
    {
        $this->validate();
        $user = ModelsUser::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        $user->assignRole($this->roles);
        session()->flash('message', 'User Inserted successfully!');
        $this->resetFields();
    }
    public function edit($id)
    {
        $user = ModelsUser::findOrFail($id);
        // $this->roles = $user->roles;
        $this->name = $user->name;
        $this->user_id = $user->id;
        $this->email = $user->email;
        $this->isEdit = true;
    }
    public function update()
    {
        $user = ModelsUser::findOrFail($this->user_id);
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];
        if (!empty($this->password)) {
            $data += [
                'password' => Hash::make($this->password),
            ];
        }
        $user->update($data);
        $user->syncRoles($this->roles);
        session()->flash('message', 'User Updated successfully!');
        $this->resetFields();
    }
    public function cancelUpdate()
    {
        $this->resetFields(); // Resets all input fields
        $this->isEdit = false; // Exit update mode
    }
    public function delete($id)
    {
        ModelsUser::findOrFail($id)->delete();
        $this->resetFields();
    }
}
