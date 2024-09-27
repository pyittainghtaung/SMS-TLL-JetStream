<?php
namespace App\Livewire;

use App\Models\Academic;
use App\Models\Grade;
use App\Models\Section as ModelsSection;
use Livewire\Component;
use Livewire\WithPagination;

class Section extends Component
{
    use WithPagination;
    public $isEdit = false;

    public $academic_id, $grade_id, $section_id, $name;
    public $search = '';
    public $academics, $grades;

    protected $rules = [
        'academic_id' => 'required|exists:academics,id',
        'grade_id' => 'required|exists:grades,id',
        'name' => 'required|string|unique:grades,name',
    ];
    public function render()
    {
        $this->academics = Academic::all();
        $this->academic_id = Academic::latest('id')->first()->id ?? null;

        $this->grades = Grade::whereIn('academic_id', $this->academics->pluck('id'))->get(); // Fetch grades related to those academics

        $sections = ModelsSection::where('name', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.section', ['sections' => $sections]);
    }
    public function resetFields()
    {
        $this->name = '';
        $this->section_id = null;
        $this->academic_id = null;
        $this->grade_id = null;
        $this->isEdit = false;
    }
    public function store()
    {
        $this->validate();
        ModelsSection::create([
            'name' => $this->name,
            'academic_id' => $this->academic_id,
            'grade_id' => $this->grade_id,
        ]);
        session()->flash('message', 'Section Inserted successfully!');
        $this->resetFields();
    }
    public function edit($id)
    {
        $section = ModelsSection::findOrFail($id);
        $this->name = $section->name;
        $this->section_id = $section->id;
        $this->grade_id = $section->grade_id;
        $this->academic_id = $section->academic_id;
        $this->isEdit = true;
    }
    public function update()
    {
        $this->validate();
        $section = ModelsSection::findOrFail($this->section_id);
        $section->update([
            'name' => $this->name,
            'academic_id' => $this->academic_id,
            'grade_id' => $this->grade_id,
        ]);
        session()->flash('message', 'Section Updated successfully!');
        $this->resetFields();
    }
    public function cancelUpdate()
    {
        $this->resetFields(); // Resets all input fields
        $this->isEdit = false; // Exit update mode
    }
    public function delete($id)
    {
        ModelsSection::findOrFail($id)->delete();
        $this->resetFields();
    }
}
