<?php

namespace App\Http\Livewire\Management;

use App\Models\Designation;
use Livewire\Component;

class DesignationUpdate extends Component
{
    public $designation, $name;

    public function render()
    {
        return view('livewire.management.designation-update');
    }

    public function mount($design_id){
        $this->designation = Designation::where('id', $design_id)->limit(1)->get();
        $this->name = $this->designation[0]->name;
    }

    public function updateData($id){
        
        $myid = Designation::findOrFail($id);
        $myid->name = $this->name;
        $myid->save();
        
        session()->flash('success', 'Designation successfully Updated!');
    }  
}
