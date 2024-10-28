<?php

namespace App\Livewire;

use App\Models\Academic as ModelsAcademic;
use Livewire\Component;
use Livewire\WithPagination;


class Academic extends Component
{
    use WithPagination;
    public $isEdit = false;
    public $academic_id, $name;
    public $search = '';

    protected $rules = [
        'name' => 'required|string|unique:academics,name',
    ];
    public function render()
    {
        // $academics = ModelsAcademic::where('name', 'like', '%' . $this->search . '%')->paginate(10);
        $academics = ModelsAcademic::searchByName($this->search)->paginate(10);
        return view('livewire.academic', ['academics' => $academics]);
    }
    public function resetFields()
    {
        $this->name = '';
        $this->academic_id = null;
        $this->isEdit = false;
    }
    public function store()
    {
        $this->validate();
        ModelsAcademic::create([
            'name' => $this->name,
        ]);
        session()->flash('message', 'Academic Inserted successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $academic = ModelsAcademic::findOrFail($id);
        $this->name = $academic->name;
        $this->academic_id = $academic->id;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        $academic = ModelsAcademic::findOrFail($this->academic_id);
        $academic->update([
            'name' => $this->name,
        ]);
        session()->flash('message', 'Academic Updated successfully!');
        $this->resetFields();
    }
    public function cancelUpdate()
    {
        $this->resetFields(); // Resets all input fields
        $this->isEdit = false; // Exit update mode
    }
    public function delete($id)
    {
        ModelsAcademic::findOrFail($id)->delete();
        $this->resetFields();
    }
}
