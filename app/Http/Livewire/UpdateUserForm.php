<?php

namespace App\Http\Livewire;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use App\Models\Designation;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class UpdateUserForm extends Component
{
    use WithFileUploads;
    public $user, $roles, $designations, $myvalue, $status;
    public $name, $password, $role_id, $email, $image, $address, 
    $designation_id, $work_hours, $phone_number, $userid;

    public function render()
    {
        return view('livewire.users.update-user-form');
    }

    public function updated($field){
        $this->validateOnly($field, [
            'name' => 'required',
            'role_id' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'required',
            'designation_id' => 'required|numeric',
            'work_hours' => 'required',
            'phone_number' => 'required|numeric|min:11',
        ]);
    }

    public function mount($user_id){
        $this->roles = Role::all();
        $this->user = User::where('id', $user_id)->limit(1)->get();
        $this->designations = Designation::all();

        $this->name = $this->user[0]->name;
        $this->designation_id = $this->user[0]->designation_id;
        $this->role_id = $this->user[0]->role_id;
        $this->email = $this->user[0]->email;
        $this->address = $this->user[0]->address;
        $this->phone_number = $this->user[0]->phone_number;
        $this->work_hours = $this->user[0]->work_hours;
        $this->status = $this->user[0]->status;
    }
 

    public function updateData($id){
        $myUser = User::findOrFail($id);
        
        if($this->image != null){
            $myUser->name = $this->name;
            $myUser->designation_id = $this->designation_id;
            $myUser->role_id = $this->role_id;
            $myUser->email = $this->email;
            $myUser->address = $this->address;
            $myUser->phone_number = $this->phone_number;
            $myUser->work_hours = $this->work_hours;
            $myUser->status = $this->status;
            $myUser->image = $this->image->store('images');
            $myUser->save();
            $this->image = null;
        }elseif($this->image == null && !empty($this->password)){
            $myUser->name = $this->name;
            $myUser->designation_id = $this->designation_id;
            $myUser->role_id = $this->role_id;
            $myUser->email = $this->email;
            $myUser->address = $this->address;
            $myUser->phone_number = $this->phone_number;
            $myUser->work_hours = $this->work_hours;
            $myUser->status = $this->status;
            $myUser->password = Hash::make($this->password);
            $myUser->save();
            
        }elseif($this->image != null && !empty($this->password)){
            $myUser->name = $this->name;
            $myUser->designation_id = $this->designation_id;
            $myUser->role_id = $this->role_id;
            $myUser->email = $this->email;
            $myUser->address = $this->address;
            $myUser->phone_number = $this->phone_number;
            $myUser->work_hours = $this->work_hours;
            $myUser->password = Hash::make($this->password);
            $myUser->status = $this->status;
            $myUser->image = $this->image->store('images');
            $myUser->save();
            $this->image = null;
            
        }elseif($this->image == null &&  empty($this->password)){
            $myUser->name = $this->name;
            $myUser->designation_id = $this->designation_id;
            $myUser->role_id = $this->role_id;
            $myUser->email = $this->email;
            $myUser->address = $this->address;
            $myUser->phone_number = $this->phone_number;
            $myUser->work_hours = $this->work_hours;
            $myUser->status = $this->status;
            $myUser->save();
        }

        session()->flash('success', 'User successfully Updated!');
    }   
}
