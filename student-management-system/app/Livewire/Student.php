<?php

namespace App\Livewire;

use App\Models\Academic;
use App\Models\Student as ModelsStudent;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Student extends Component
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
    public $accepted_student_id;

    #[Validate('required')]
    public $spa_student_id;

    #[Validate('required')]
    public $name;

    // 'gender' => 'required|in:male,female,other',
    #[Validate('required|in:male,female,other')]
    public $gender;

    #[Validate('required')]
    public $student_nrc_no;

    #[Validate('nullable|date')]
    public $student_dob;

    #[Validate('nullable')]
    public $ethnic;

    #[Validate('nullable')]
    public $religion;

    #[Validate('required')]
    public $father_name;

    #[Validate('required')]
    public $father_nrc_no;

    #[Validate('required')]
    public $mother_name;

    #[Validate('nullable')]
    public $mother_nrc_no;

    #[Validate('nullable')]
    public $father_job;

    #[Validate('nullable')]
    public $mother_job;

    #[Validate('nullable')]
    public $wanted_class;

    #[Validate('required')]
    public $address;

    #[Validate('required')]
    public $contact_phone_no;

    #[Validate('nullable')]
    public $passed_grade_and_roll_no;

    #[Validate('nullable')]
    public $passed_school_name;

    #[Validate('nullable')]
    public $passed_year;

    #[Validate('required')]
    public $passed_town_name;

    #[Validate('nullable|date')]
    public $enter_date;

    #[Validate('nullable')]
    public $available_people;

    #[Validate('nullable|mimes:png,jpg,jpeg')]
    public $image;

    public function mount(Academic $academic)
    {
        $this->academic_id = $academic->id;
    }

    public function render()
    {
        $students = ModelsStudent::filterByAcademicAndName($this->academic_id, $this->search)->paginate(20);
        // dd($students);
        return view('livewire.student', ['students' => $students]);
    }

    public function resetFields()
    {

        $this->accepted_student_id = '';
        $this->spa_student_id = '';
        $this->name = '';
        $this->gender = '';
        $this->student_nrc_no = '';
        $this->student_dob = '';
        $this->ethnic = '';
        $this->religion = '';
        $this->father_name = '';
        $this->mother_name = '';
        $this->father_nrc_no = '';
        $this->mother_nrc_no = '';
        $this->father_job = '';
        $this->mother_job = '';
        $this->wanted_class = '';
        $this->address = '';
        $this->contact_phone_no = '';
        $this->passed_grade_and_roll_no = '';
        $this->passed_school_name = '';
        $this->passed_year = '';
        $this->passed_town_name = '';
        $this->enter_date = '';
        $this->available_people = '';
        $this->image = '';

        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate();
        $imagePath = $this->image ? $this->image->store('students', 'public') : null;
        ModelsStudent::create([
            'academic_id' => $this->academic_id,
            'accepted_student_id' => $this->accepted_student_id,
            'spa_student_id' => $this->spa_student_id,
            'name' => $this->name,
            'gender' => $this->gender,
            'student_nrc_no' => $this->student_nrc_no,
            'student_dob' => $this->student_dob,
            'ethnic' => $this->ethnic,
            'religion' => $this->religion,
            'father_name' => $this->father_name,
            'father_nrc_no' => $this->father_nrc_no,
            'mother_name' => $this->mother_name,
            'mother_nrc_no' => $this->mother_nrc_no,
            'father_job' => $this->father_job,
            'mother_job' => $this->mother_job,
            'wanted_class' => $this->wanted_class,
            'address' => $this->address,
            'contact_phone_no' => $this->contact_phone_no,
            'passed_grade_and_roll_no' => $this->passed_grade_and_roll_no,
            'passed_school_name' => $this->passed_school_name,
            'passed_year' => $this->passed_year,
            'passed_town_name' => $this->passed_town_name,
            'enter_date' => $this->enter_date,
            'available_people' => $this->available_people,
            'image' => $imagePath,
        ]);

        session()->flash('message', 'Student Inserted successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $student = ModelsStudent::findOrFail($id);
        $this->student_id = $student->id;

        $this->accepted_student_id = $student->accepted_student_id;
        $this->spa_student_id = $student->spa_student_id;
        $this->name = $student->name;
        $this->gender = $student->gender;
        $this->student_nrc_no = $student->student_nrc_no;
        $this->student_dob = $student->student_dob;
        $this->ethnic = $student->ethnic;
        $this->religion = $student->religion;
        $this->father_name = $student->father_name;
        $this->mother_name = $student->mother_name;
        $this->father_nrc_no = $student->father_nrc_no;
        $this->mother_nrc_no = $student->mother_nrc_no;
        $this->father_job = $student->father_job;
        $this->mother_job = $student->mother_job;
        $this->wanted_class = $student->wanted_class;
        $this->address = $student->address;
        $this->contact_phone_no = $student->contact_phone_no;
        $this->passed_grade_and_roll_no = $student->passed_grade_and_roll_no;
        $this->passed_school_name = $student->passed_school_name;
        $this->passed_year = $student->passed_year;
        $this->passed_town_name = $student->passed_town_name;
        $this->enter_date = $student->enter_date;
        $this->available_people = $student->available_people;
        // $this->image = $student->image;

        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        $student = ModelsStudent::findOrFail($this->student_id);
        $oldImagePath = $student->image;
        if ($this->image) {
            $newImagePath = $this->image->store('students', 'public');
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
            $this->image = $newImagePath;
        } else {
            $this->image = $oldImagePath;
        }
        $student->update([
            'accepted_student_id' => $this->accepted_student_id,
            'spa_student_id' => $this->spa_student_id,
            'name' => $this->name,
            'gender' => $this->gender,
            'student_nrc_no' => $this->student_nrc_no,
            'student_dob' => $this->student_dob,
            'ethnic' => $this->ethnic,
            'religion' => $this->religion,
            'father_name' => $this->father_name,
            'father_nrc_no' => $this->father_nrc_no,
            'mother_name' => $this->mother_name,
            'mother_nrc_no' => $this->mother_nrc_no,
            'father_job' => $this->father_job,
            'mother_job' => $this->mother_job,
            'wanted_class' => $this->wanted_class,
            'address' => $this->address,
            'contact_phone_no' => $this->contact_phone_no,
            'passed_grade_and_roll_no' => $this->passed_grade_and_roll_no,
            'passed_school_name' => $this->passed_school_name,
            'passed_year' => $this->passed_year,
            'passed_town_name' => $this->passed_town_name,
            'enter_date' => $this->enter_date,
            'available_people' => $this->available_people,
            'image' => $this->image,
        ]);
        session()->flash('message', 'Student Updated successfully!');
        $this->resetFields();
    }
    public function cancelUpdate()
    {
        $this->resetFields(); // Resets all input fields
        $this->isEdit = false; // Exit update mode
    }
    public function delete($id)
    {
        $student = ModelsStudent::findOrFail($id);
        if ($student->image && Storage::disk('public')->exists($student->image)) {
            Storage::disk('public')->delete($student->image);
        }
        $student->delete();
        $this->resetFields();
        session()->flash('message', 'Student deleted successfully!');
    }
}
