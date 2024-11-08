<?php

namespace App\Livewire;

use App\Models\Academic;
use App\Models\Grade as ModelsGrade;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Grade extends Component
{
    use WithPagination;

    public Academic $academic;
    public $isEdit = false;
    public $grade_id, $name;
    public $academic_id, $academic_name;
    public $search = '';

    // public $academics; // To hold the list of academics
    // public $selectedAcademicId; // To hold the selected academic_id

    protected $rules = [
        'academic_id' => 'required|exists:academics,id',
        'name' => 'required|string|unique:grades,name',
    ];

    public function mount(Academic $academic)
    {
        $this->academic = $academic;
        $this->academic_id = $this->academic->id;
        $this->academic_name = $this->academic->name;
    }

    public function render()
    {
        $grades = ModelsGrade::filterByAcademicAndGrade($this->academic_id, $this->search)->paginate(10);
        return view('livewire.grade', ['grades' => $grades]);
    }

    public function resetFields()
    {
        $this->name = '';
        $this->grade_id = null;
        $this->isEdit = false;
    }


    public function store()
    {
        $this->validate([
            'academic_id' => 'required|exists:academics,id',
            'name' => [
                'required',
                'string',
                Rule::unique('grades')->where(function ($query) {
                    return $query->where('academic_id', $this->academic_id);
                }),
            ],
        ]);
        ModelsGrade::create([
            'academic_id' => $this->academic_id,
            'name' => $this->name,
        ]);
        // session()->flash('message', 'Grade Inserted successfully!');
        $this->js("alert('Grade was successfully saved!')");
        $this->resetFields();
    }

    public function edit($id)
    {
        $grade = ModelsGrade::findOrFail($id);
        $this->name = $grade->name;
        $this->grade_id = $grade->id;
        $this->academic_id = $grade->academic_id;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        $grade = ModelsGrade::findOrFail($this->grade_id);
        $grade->update([
            'name' => $this->name,
        ]);
        // session()->flash('message', 'Grade Updated successfully!');
        $this->js("alert('Grade was successfully Updated!')");
        $this->resetFields();
    }

    public function cancelUpdate()
    {
        $this->resetFields(); // Resets all input fields
        $this->isEdit = false; // Exit update mode
    }

    public function delete($id)
    {
        ModelsGrade::findOrFail($id)->delete();
        $this->resetFields();
        $this->js("alert('Grade was deleted!')");
    }
}
