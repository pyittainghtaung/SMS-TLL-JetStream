<?php

namespace App\Livewire;

use App\Models\Academic;
use App\Models\Teacher as ModelsTeacher;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;


class Teacher extends Component
{
    // Defaults properties for a livewire component
    use WithPagination;
    use WithFileUploads;

    public $isEdit = false;
    public $search = '';
    public $student_id;

    // Add Model's fillable properties and Validation rules
    #[Validate('required')]
    public $academic_id;

    #[Validate('required')]
    public $name;

    #[Validate('nullable')]
    public $teacher_nrc_no;

    // 'gender' => 'required|in:male,female,other',
    #[Validate('required|in:male,female,other')]
    public $gender;

    #[Validate('required')]
    public $education;

    #[Validate('required')]
    public $address;

    #[Validate('required')]
    public $contact_phone_no;

    #[Validate('nullable|mimes:png,jpg,jpeg')]
    public $image;

    public function mount(Academic $academic)
    {
        $this->academic_id = $academic->id;
    }

    public function render()
    {
        $teachers = ModelsTeacher::filterByAcademicAndName($this->academic_id, $this->search)->paginate(20);
        return view('livewire.teacher', ['teachers' => $teachers]);
    }

    public function resetFields()
    {
        $this->name = '';
        $this->gender = '';
        $this->address = '';
        $this->contact_phone_no = '';
        $this->image = '';
        $this->education = '';
        $this->teacher_nrc_no = '';

        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate();
        $imagePath = $this->image ? $this->image->store('students', 'public') : null;
        ModelsTeacher::create([
            'academic_id' => $this->academic_id,
            'name' => $this->name,
            'gender' => $this->gender,
            'teacher_nrc_no' => $this->teacher_nrc_no,
            'address' => $this->address,
            'contact_phone_no' => $this->contact_phone_no,
            'education'=>$this->education,
            'image' => $imagePath,
        ]);

        session()->flash('message', 'Teacher Inserted successfully!');
        $this->resetFields();
    }
}
