<?php

namespace App\Livewire;

use App\Models\Academic;
use App\Models\Hostel as ModelsHostel;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Hostel extends Component
{
    use WithPagination;

    public $isEdit = false;

    public  $hostel_id, $name, $address, $phone_no;
    public $academic_id, $academic_name;
    public $search = '';

    // public $academics; // To hold the list of academics
    // public $selectedAcademicId; // To hold the selected academic_id

    protected $rules = [
        'academic_id' => 'required|exists:academics,id',
        'name' => 'required|string',
        'address' => 'required|string',
        'phone_no' => 'required|string',
    ];

    public function mount(Academic $academic)
    {
        $this->academic_id = $academic->id;
        $this->academic_name = $academic->name;
    }
    public function render()
    {
        // $this->academics = Academic::all();
        // Set the last academic_id as the selected value
        // $this->selectedAcademicId = Academic::latest('id')->first()->id ?? null;
        $hostels = ModelsHostel::filterByAcademicAndHostel($this->academic_id, $this->search)->paginate(10);
        return view('livewire.hostel', ['hostels' => $hostels]);
    }
    public function resetFields()
    {
        $this->name = '';
        // $this->academic_id = null;
        $this->hostel_id = null;
        $this->address = '';
        $this->phone_no = '';
        $this->isEdit = false;
    }
    public function store()
    {
        // $this->academic_id = $this->selectedAcademicId;
        $this->validate([
            'academic_id' => 'required|exists:academics,id',
            'name' => [
                'required',
                'string',
                Rule::unique('hostels')->where(function ($query) {
                    return $query->where('academic_id', $this->academic_id);
                }),
            ],
        ]);
        ModelsHostel::create([
            'academic_id' => $this->academic_id,
            'name' => $this->name,
            'address' => $this->address,
            'phone_no' => $this->phone_no,
        ]);
        session()->flash('message', 'Hostel Inserted successfully!');
        $this->resetFields();
    }
    public function edit($id)
    {
        $hostel = ModelsHostel::findOrFail($id);
        $this->name = $hostel->name;
        $this->hostel_id = $hostel->id;
        // $this->academic_id = $hostel->academic_id;
        $this->address = $hostel->address;
        $this->phone_no = $hostel->phone_no;
        $this->isEdit = true;
    }
    public function update()
    {
        $this->validate();
        $hostel = ModelsHostel::findOrFail($this->hostel_id);
        $hostel->update([
            'name' => $this->name,
            'address' => $this->address,
            'phone_no' => $this->phone_no,
        ]);
        session()->flash('message', 'Hostel Updated successfully!');
        $this->resetFields();
    }
    public function cancelUpdate()
    {
        $this->resetFields(); // Resets all input fields
        $this->isEdit = false; // Exit update mode
    }
    public function delete($id)
    {
        ModelsHostel::findOrFail($id)->delete();
        $this->resetFields();
    }
}
