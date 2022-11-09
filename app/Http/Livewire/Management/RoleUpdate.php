<?php

namespace App\Http\Livewire\Management;

use App\Models\Role;
use Livewire\Component;

class RoleUpdate extends Component
{
    public $role, $name;

    public function render()
    {
        return view('livewire.management.role-update');
    }

    public function mount($update_id){
        $this->role = Role::where('id', $update_id)->limit(1)->get();
        $this->name = $this->role[0]->name;
    }

    public function updateData($id){
        
        $myid = Role::findOrFail($id);
        $myid->name = $this->name;
        $myid->save();
        
        session()->flash('success', 'Role successfully Updated!');
    }
}
