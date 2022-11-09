<?php

namespace App\Http\Livewire\Attendance;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Breaks;
use Livewire\Component;
use App\Models\Attendance;
use Livewire\WithPagination;

class AttendanceShow extends Component
{
    use WithPagination;

    // public $show = true;
    // public $update = false;
    // public $create = true;

    public $users, $minutes = 0;

    public function render()
    {
        return view('livewire.attendance.attendance-show');
    }

    public function updated(){
        $this->users = User::with('attendance')->where('status', 'active')->get();
        
    }

    public function mount()
    {
        $this->users = User::with('attendance', 'break')->where('status', 'active')->get();
    }


    public function updateStatus($id){
        $present = Attendance::where('user_id', $id)->latest()->limit(1)->get();
        
        if($present->count()){
           $date='01/02/22'; 
            if($present[0]->created_at->format('d/m/Y') == $date){
                session()->flash('failed', 'User is already present!');
            }else{
                Attendance::create([
                    'user_id' => $id,
                    'status' => 'present'
                ]);
                $this->updated();
    
                session()->flash('success', 'User is now Present!');
            }
        }else{
            Attendance::create([
                'user_id' => $id,
                'status' => 'present'
            ]);
            $this->updated();

            session()->flash('success', 'User is now Present!');
        }
    }

    public function updateOut($id){
        $present = Attendance::where('user_id', $id)->latest()->limit(1)->get();
        $break = Breaks::where('user_id', $id)->latest()->limit(1)->get();

        if($present->count()){
            if($present[0]->created_at->format('d/m/Y') == date('d/m/Y')){
                $user = Attendance::where('user_id', $id)->whereDate('created_at', Carbon::today());
                $user->update([
                    'status' => 'Completed'
                ]);

                if($break->count() &&  $break != null){
                    if($break[0]->created_at->format('d/m/Y') == date('d/m/Y') && $break[0]->status == 'break'){
                        $breaks = Breaks::find($break[0]->id);
                        $breaks->update([
                            'status' => 'BreakEnd'
                        ]);
                    }
                }

                $this->updated();
                session()->flash('success', 'User has compeleted work!');
            }
        }
    }


    public function updateLeave($id){

        $user = Attendance::create([
            'user_id' => $id,
            'status' => 'Leave',
        ]);

        $user->updated_at = Carbon::now()->addHour($user->user->work_hours);
        $user->save();

        $this->updated();

        session()->flash('success', 'Leave has been successfully added for user!');
        
    }

    public function startBreak($id){
        Breaks::create([
            'user_id' => $id,
        ]);

        $this->updated();

        session()->flash('success', 'User is on Break!');
        
    }

    public function endBreak($id){
        $present = Breaks::find($id);
        $present->update([
            'status' => 'BreakEnd'
        ]);
        $this->updated();
        session()->flash('success', "User's Break has ended!");
    }

    // public function addUser(){
    //     $this->create = true;
    //     $this->show = false;
    //     $this->update = false;
    // }

    // public function showUsers(){
    //     $this->create = false;
    //     $this->show = true;
    //     $this->update = false;
    // }

    // public function updateUser(){
    //     $this->create = false;
    //     $this->show = false;
    //     $this->update = true;
    // }
}
