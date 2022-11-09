<?php

namespace App\Http\Livewire\Attendance;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Breaks;
use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class UserAttendance extends Component
{
    public $users;

    public function render()
    {
        return view('livewire.attendance.user-attendance');
    }

    public function mount()
    {
        $this->user = User::with('attendance', 'break')->where('status', 'active')->where('id', auth()->user()->id)->get();    
        $this->attendance = Attendance::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->get();
        $this->breaks = Breaks::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->get();
    }

    public function updateStatus(){
        $present = Attendance::where('user_id', auth()->user()->id)->latest()->limit(1)->get();
        
        if($present->count()){ 
            if($present[0]->created_at->format('d/m/Y') == date('d/m/Y')){
                session()->flash('failed', 'User is already present!');
            }else{
                Attendance::create([
                    'user_id' => auth()->user()->id,
                    'status' => 'present'
                ]);
                $this->mount();
    
                session()->flash('success', 'User is now Present!');
            }
        }else{
            Attendance::create([
                'user_id' => auth()->user()->id,
                'status' => 'present'
            ]);
            $this->mount();

            session()->flash('success', 'User is now Present!');
        }
    }

    public function updateOut(){
        $present = Attendance::where('user_id', auth()->user()->id)->latest()->limit(1)->get();
        $break = Breaks::where('user_id', auth()->user()->id)->latest()->limit(1)->get();

        if($present->count()){
            if($present[0]->created_at->format('d/m/Y') == date('d/m/Y')){
                $user = Attendance::where('user_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->get();
                $user[0]->status = 'Completed';
                $user[0]->save();
                if($break->count() &&  $break != null){
                    if($break[0]->created_at->format('d/m/Y') == date('d/m/Y') && $break[0]->status == 'break'){
                        $breaks = Breaks::find($break[0]->id);
                        $breaks->status = 'BreakEnd';
                        $breaks->save();
                    }
                }
                $this->mount();
                session()->flash('success', 'User has compeleted work!');
            }
        }
    }

    public function updateLeave(){
        $user = Attendance::create([
            'user_id' => auth()->user()->id,
            'status' => 'Leave',
        ]);

        $user->updated_at = Carbon::now()->addHour($user->user->work_hours);
        $user->save();

        $this->mount();

        session()->flash('success', 'You are On Leave Now!');
        
    }
    
    public function startBreak(){
        Breaks::create([
            'user_id' => auth()->user()->id,
        ]);

        $this->mount();

        session()->flash('success', 'User is on Break!');
        
    }

    public function endBreak(){
        $present = Breaks::find(auth()->user()->id);
        $present->status = 'BreakEnd';
        $present->save();
        $this->mount();
        session()->flash('success', "User's Break has ended!");
    }
}
