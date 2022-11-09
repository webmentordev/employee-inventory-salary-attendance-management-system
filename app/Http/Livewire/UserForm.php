<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\User;
use App\Models\Designation;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserForm extends Component
{
    use WithFileUploads;

    public $roles, $designations;
    public $name, $password, $role_id, $email, $image, $address, 
    $designation_id, $work_hours, $phone_number;

    public function mount(){
        $this->roles = Role::all();
        $this->designations = Designation::all();
    }

    public function render()
    {
        return view('livewire.users.user-form');
    }

    public function updated($field){
        $this->validateOnly($field, [
            'name' => 'required',
            'role_id' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'address' => 'required',
            'designation_id' => 'required|numeric',
            'work_hours' => 'required',
            'phone_number' => 'required|numeric|min:11',
        ]);
    }


    public function saveData(){
        $this->validate([
            'name' => 'required',
            'role_id' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'address' => 'required',
            'designation_id' => 'required|numeric',
            'work_hours' => 'required',
            'phone_number' => 'required|numeric|min:11',
        ]);

        if($this->image != null){
            User::create([
                'name' => $this->name,
                'role_id' => $this->role_id,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'image' => $this->image->store('images'),
                'address' => $this->address,
                'designation_id' => $this->designation_id,
                'work_hours' => $this->work_hours,
                'phone_number' => $this->phone_number,
            ]);
        }else{
            User::create([
                'name' => $this->name,
                'role_id' => $this->role_id,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'address' => $this->address,
                'designation_id' => $this->designation_id,
                'work_hours' => $this->work_hours,
                'phone_number' => $this->phone_number,
            ]);
        }
        

        $this->name = "";
        $this->role_id = "";
        $this->email = "";
        $this->password = "";
        $this->image = null;
        $this->address = "";
        $this->designation_id = "";
        $this->work_hours = "";
        $this->phone_number = "";

        session()->flash('success', 'Employee Added Successfully!');
    }
}
