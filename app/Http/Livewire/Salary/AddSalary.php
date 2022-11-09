<?php

namespace App\Http\Livewire\Salary;

use App\Models\User;
use Livewire\Component;
use App\Models\UserSalary;

class AddSalary extends Component
{
    public $user_id, $user_name, $users, $salary;

    public function render()
    {
        return view('livewire.salary.add-salary');
    }

    public function mount(){
        $this->users = User::all();
    }

    public function updated($field){
        $this->validateOnly($field,[
            'user_name' => 'required',
            'salary'=>'required|numeric'
        ]);
    }

    public function saveData(){
        $this->validate([
            'user_name' => 'required',
            'salary'=>'required|numeric'
        ]);

        $user_id = User::where('name', $this->user_name)->limit(1)->get();

        if($user_id->count() == 0){
            session()->flash('failed', 'User Does not exist!');
        }else{
            $findUser = UserSalary::where('user_id', $user_id[0]->id)->limit(1)->get();
            if($findUser->count() == 0){
                UserSalary::create([
                    'user_id'=>$user_id[0]->id,
                    'salary'=>$this->salary
                ]);
                session()->flash('success', 'Salary Successfully Added!');
            }else{
                session()->flash('failed', 'Salary Already Exist!');
            }
        }
    }
}
