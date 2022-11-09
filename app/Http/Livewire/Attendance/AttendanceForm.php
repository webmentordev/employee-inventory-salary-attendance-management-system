<?php

namespace App\Http\Livewire\Attendance;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Attendance;
use App\Models\Breaks;
use Carbon\CarbonPeriod;

class AttendanceForm extends Component
{
    public $attendance, $total_hours = 0;
    public $hours, $totalMinutes  = 0;

    public $user_id;

    public $toDate, $fromDate, $breakMinutes;

    public function render()
    {
        return view('livewire.attendance.attendance-form');
    }

    public function mount($user_id){
        $dates = [];
        $sunday = 0;
        $breakMinutes = 0;

        $this->attendance = Attendance::with('user', 'salary')->where('user_id', $user_id)->get();
        $workDate = Attendance::where('user_id', $this->user_id)->get();
        $break = Breaks::where('user_id', $this->user_id)->get();
        
        $this->user_id = $user_id;
        $this->toDate = Carbon::now();
        $this->fromDate = Carbon::now();

        if($break->count()){
            for($b = 0; $b < count($break); $b++){
                $this->breakMinutes += $break[$b]->updated_at->diffInMinutes($break[$b]->created_at);
            }
        }

        if($this->attendance->count() && $workDate->count()){
            $period = CarbonPeriod::create($workDate[0]->created_at->format('Y-m-d'), Carbon::today());
            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }  
            
            for($d = 0; $d < count($dates); $d++){
                if(Carbon::createFromFormat('Y-m-d', $dates[$d])->format('D') == 'Sun'){
                    $sunday = $sunday + $this->attendance[0]->user->work_hours;
                }
            }

            for($k = 0; $k < count($this->attendance); $k++){
                $this->hours += $this->attendance[$k]->updated_at->diffInMinutes($this->attendance[$k]->created_at);
            }

            $hours = $this->hours + ($sunday * 60);
            $this->hours = $hours - $this->breakMinutes;
        }
    }
    
    public function updateFilter(){
        $attendances = Attendance::where('user_id', $this->user_id)->whereNotNull('user_id')->with('user')->get();
        $dates = [];
        $workDates = [];
        
        $break = null;
        $this->hours = null;
        $this->totalMinutes = null;
        $this->breakMinutes = null;

        if(count($attendances) >= 0){
            $firstDay = $attendances->first()->created_at;
            $period = CarbonPeriod::create($firstDay, Carbon::now());

            foreach($period as $date){
                $dates[] = $date->format('d/m/Y');
            }

            if(Carbon::createFromDate($this->fromDate)->addDay(1) >= (Carbon::createFromDate($firstDay))){
                if(!Carbon::createFromDate($this->toDate)->gt(Carbon::now())){
                    $array = Attendance::whereBetween('created_at', [$this->fromDate, Carbon::createFromDate($this->toDate)->addDays(1)])->where('user_id', $this->user_id)->get();
                    $break = Breaks::whereBetween('created_at', [$this->fromDate, Carbon::createFromDate($this->toDate)->addDays(1)])->where('user_id', $this->user_id)->get();
                    $this->attendance = $array;
                    $period = CarbonPeriod::create(Carbon::createFromDate($this->fromDate), Carbon::createFromDate($this->toDate));

                    if($break->count()){
                        for($b = 0; $b < count($break); $b++){
                            $this->breakMinutes += $break[$b]->updated_at->diffInMinutes($break[$b]->created_at);
                        }
                    }

                    foreach($period as $date){
                        $workDates[] = $date->format('d/m/Y');
                    }

                    if(count($array) > 0){
                        for($time = 0; $time < count($array); $time++){
                            $this->hours += $array[$time]->updated_at->diffInMinutes($array[$time]->created_at);
                        }
                        
                        for($h = 0; $h < count($workDates); $h++){
                            if(Carbon::createFromFormat('d/m/Y', $workDates[$h])->format('D') == 'Sun'){
                                $this->totalMinutes += ($array[0]->user->work_hours * 60);
                            }
                        }
                        // dd($this->totalMinutes );
                        $this->hours =  $this->hours + $this->totalMinutes ;
                        $this->hours = $this->hours - $this->breakMinutes;
                        
                        
                    }else{
                        for($h = 0; $h < count($workDates); $h++){
                            if(Carbon::createFromFormat('d/m/Y', $workDates[0])->format('D') == 'Sun'){
                                session()->flash('filterFailed', "User Only Salary for Sunday is available!");
                            }
                            break;
                        }
                    }
                }else{
                    session()->flash('filterFailed', "Date should not greater then Today.");
                }
            }else{
                session()->flash('filterFailed', "No Date Before the following! User started working from {$dates[0]}");
            }
        }else{
            session()->flash('filterFailed', "No User Data Found!");
        }
    }

    // public function updateFilter(){
    //     $workDate = Attendance::where('user_id', $this->user_id)->with('user')->get();
        

    //     if($workDate != null && $workDate->count()){
    //         if(Carbon::createFromDate($this->fromDate)->yesterday()->gt(Carbon::createFromDate($workDate[0]->created_at))){
    //             if(!Carbon::createFromDate($this->toDate)->gt(Carbon::now())){
    //                 $dates = [];
    //                 $array = Attendance::whereBetween('created_at', [$this->fromDate, Carbon::createFromDate($this->toDate)->addDays(1)])->where('user_id', $this->user_id)->get();

    //                 if(count($array) == 0 && count($array) == null){
    //                     session()->flash('filterFailed', "User Work between {$this->fromDate} & {$this->toDate} not found!");
    //                 }else{
                        
    //                     $this->hours =  null;

    //                     $period = CarbonPeriod::create(Carbon::createFromDate($array->first()->created_at), Carbon::createFromDate($array->last()->created_at));
    //                     foreach ($period as $date) {
    //                         if($date->format('d/m/Y') != Carbon::now()->tomorrow()->format('d/m/Y')){
    //                             $dates[] = $date->format('Y-m-d');
    //                         }else{
    //                             break;
    //                         }
    //                     }

    //                     for($k = 0; $k < count($array); $k++){
    //                         // dd($workDate[0]->user->work_hours);
    //                         // dd(Carbon::createFromDate($array[$k]->created_at)->format('D'));
    //                         if(Carbon::createFromDate($array[$k]->created_at)->format('D') == 'Sun'){
    //                             $this->hours += ($workDate[0]->user->work_hours * 60);
    //                         }else{
    //                             $this->hours += $array[$k]->updated_at->diffInMinutes($array[$k]->created_at);
    //                         }
    //                     }
    //                     $result = $this->hours;
    //                     $this->attendance = $array;
    //                 }
    //             }else{
    //                 session()->flash('filterFailed', "To-Date should not be in future! It should be less or Today.");
    //             }
    //         }
    //     }
    // }
}
// dd(Carbon::createFromDate($this->fromDate)->yesterday()->gt(Carbon::createFromDate($workDate[0]->created_at)));
//dd($workDate[0]->created_at->format('d/m/Y') == Carbon::createFromDate($this->fromDate)->format('d/m/Y'));
// dd(Carbon::createFromDate($array[$k]->created_at)->format('D'));
// dd(Carbon::createFromFormat('d/m/Y', $array[$k]));

// for($i=1; $i < $today->daysInMonth + 1; ++$i) {
//     $dates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d/m/Y');
// }
// if(!empty($this->attendance)){
//     for($l = 0; $l < count($this->attendance); $l++){
//         // $this->hours += $this->attendance[$l]->updated_at->diffInMinutes($this->attendance[$l]->created_at);
//         $this->attendance;
//         $this->updated();
//     }
// }else{
//     session()->flash('filterFailed', "User's Work between not found!");
// }

// $array = Attendance::whereBetween('created_at', [Carbon::createFromDate($this->fromDate)->subDays(1), Carbon::createFromDate($this->toDate)->addDays(1)])->where('user_id', $this->user_id)->get();
// // Get Last Month
// dd(Carbon::now()->subMonth()->format('m'));

// $this->total_hours = $hours / 60;

// $today = today()->addMonths(); 
// $dates = []; 

// for($i=1; $i < $today->daysInMonth + 1; ++$i) {
//     $dates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d/m/Y');
// }

// dd($dates);


// {{ floor($hours / 60) }}:{{ $hours - ((floor($hours / 60)) * 60) }}