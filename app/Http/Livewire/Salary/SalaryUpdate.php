<?php

namespace App\Http\Livewire\Salary;

use Livewire\Component;
use App\Models\UserSalary;


class SalaryUpdate extends Component
{

    public $mysalary, $salary, $salary_id;

    public function render()
    {
        return view('livewire.salary.salary-update');
    }


    public function mount($salary_id){
        $this->mysalary = UserSalary::findOrFail($salary_id);
        $this->salary_id = $salary_id;
    }

    public function updated($field){
        $this->validateOnly($field, [
            'salary'=>'required|numeric'
        ]);
    }

    public function updateData($id){

        $this->validate([
            'salary'=> 'required|numeric'
        ]);

        $salary = UserSalary::find($id);
        $salary->salary = $this->salary;
        $salary->save();

        session()->flash('success', 'Success Successfully Updated!');
    }
}
