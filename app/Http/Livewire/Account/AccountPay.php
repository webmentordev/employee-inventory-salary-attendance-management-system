<?php

namespace App\Http\Livewire\Account;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Breaks;
use Livewire\Component;
use App\Models\Accounts;
use Carbon\CarbonPeriod;
use App\Models\Attendance;

class AccountPay extends Component
{
    public $user, $date, $hours, $user_id;
    public $total_hours = 0, $attendance;
    public $month, $minutes = 0, $salary;
    public $payments;
    public $alertPop = false;
    public $breakMinutes = 0;

    public function render()
    {
        return view('livewire.account.account-pay');
    }

    public function mount($user_id){
        $this->user = User::where('id', $user_id)->get();
        $this->month = date('M, Y');
        $this->user_id = $user_id;

        $this->payments = Accounts::where('user_id', $user_id)->get();
        $this->status = Accounts::where('user_id', $user_id)->where('period', $this->month)->get();
        
        if(count($this->status) > 0){
            $this->status = 'Paid';
        }else{
            $this->status = 'Unpaid';
        }

        $this->attendance = Attendance::where('user_id', $user_id)->get();

        $today = today(); 
        $dates = []; 

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $dates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d-m-Y'); 
        }

        for($k = 0; $k < count($dates); $k++) {
            if(Carbon::createFromFormat('d-m-Y', $dates[$k])->format('D') == 'Sun'){
                $this->total_hours += $this->user[0]->work_hours;
            }
        }

        if($this->attendance != null && count($this->attendance) != 0){
            for($p = 0; $p < count($this->attendance); $p++){
                if($this->attendance[$p]->created_at->format('m/Y') == date('m/Y')){
                    $this->minutes += $this->attendance[$p]->updated_at->diffInMinutes($this->attendance[$p]->created_at);
                }
            }
        }

        $this->total_hours = $this->total_hours + round(($this->minutes / 60));

        if($this->user[0]->salary != null){
            $salaryPerDay =  round($this->user[0]->salary->salary / 30);
            $salaryPerHour =  round($salaryPerDay / $this->user[0]->work_hours);
            $this->salary = $this->total_hours * $salaryPerHour;
        }else{
            session()->flash('failedPay', 'Please Add Salary for user first!');
        }
    }

    public function updated(){
        $this->salary = null;
        $this->salary = null;
        $this->total_hours = null;
        $this->minutes = null;
        $salaryPerDay = null;
        $salaryPerHour = null;
        $dates = null;
        $this->attendance = null;
        $breaks = null;

        $selectedMonth = Carbon::createFromDate($this->date)->format('M, Y');
        $this->month = $selectedMonth;
        
        $firstDay = Carbon::createFromDate($this->month)->startOfMonth();
        $lastDay = Carbon::createFromDate($this->month)->endOfMonth();

        $this->attendance = Attendance::whereBetween('created_at', [$firstDay, $lastDay])->where('user_id', $this->user_id)->get();
        $breaks = Breaks::whereBetween('created_at', [$firstDay, $lastDay])->where('user_id', $this->user_id)->get();

        $this->status = Accounts::where('user_id', $this->user_id)->where('period', $this->month)->get();
        
        if(count($this->status) > 0){
            $this->status = 'Paid';
        }else{
            $this->status = 'Unpaid';
        }
        
        $today = Carbon::createFromDate($this->month); 
        $dates = [];

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $dates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d-m-Y'); 
        }

        if(count($this->attendance) != 0){
            if($this->attendance[0]->created_at->format('M, Y') == $this->month){
                for($k = 0; $k < count($dates); $k++) {
                    if(Carbon::createFromFormat('d-m-Y', $dates[$k])->format('D') == 'Sun'){
                        $this->total_hours += $this->user[0]->work_hours;
                    }
                }
    
                if($this->attendance != null && count($this->attendance) != 0){
                    for($p = 0; $p < count($this->attendance); $p++){
                        if($this->attendance[$p]->created_at->format('m/Y') == date('m/Y')){
                            $this->minutes += $this->attendance[$p]->updated_at->diffInMinutes($this->attendance[$p]->created_at);
                        }
                    }
                }
                if($breaks->count()){
                    for($b = 0; $b < count($breaks); $b++){
                        $this->breakMinutes += $breaks[$b]->updated_at->diffInMinutes($breaks[$b]->created_at);
                    }
                }
    
                $this->total_hours = $this->total_hours + round((($this->minutes - $this->breakMinutes) / 60));
    
                $salaryPerDay =  round($this->user[0]->salary->salary / 30);
                $salaryPerHour =  round($salaryPerDay / $this->user[0]->work_hours);
    
                $this->salary = $this->total_hours * $salaryPerHour;
            }else{
                if(count($dates) == 28){
                    $this->total_hours = $this->user[0]->work_hours * 30;
                    $this->salary = $this->user[0]->salary->salary;
                }else if(count($dates) == 31){
                    $this->total_hours = $this->user[0]->work_hours * 31;
                    $salaryPerDay =  round($this->user[0]->salary->salary / 30);
                    $this->salary = $this->user[0]->salary->salary + $salaryPerDay;
                }else{
                    $this->total_hours = $this->user[0]->work_hours * 30;
                    $this->salary = $this->user[0]->salary->salary;
                }
            }
        }else{
            if(count($dates) == 28){
                $this->total_hours = $this->user[0]->work_hours * 30;
                $this->salary = $this->user[0]->salary->salary;
            }else if(count($dates) == 31){
                $this->total_hours = $this->user[0]->work_hours * 31;
                $salaryPerDay =  round($this->user[0]->salary->salary / 30);
                $this->salary = $this->user[0]->salary->salary + $salaryPerDay;
            }else{
                $this->total_hours = $this->user[0]->work_hours * 30;
                $this->salary = $this->user[0]->salary->salary;
            }
        }
    }

    public function paynow($user_id){
        if($this->date != null){
            $selectedMonth = Carbon::createFromDate($this->date)->format('M, Y');
            $this->month = $selectedMonth;
        }else{
            $this->month = date('M, Y');
        }

        $account = Accounts::where('user_id', $user_id)->where('period', $this->month)->get();

        if(count($account) == 0){
            Accounts::create([
                'salary' => $this->salary,
                'period' => $this->month,
                'hours' => $this->total_hours,
                'user_id' => $user_id,
                'status' => 'Paid',
            ]);
            $this->alertPop = false;
            $this->payments = Accounts::where('user_id', $user_id)->get();
            $this->status = Accounts::where('user_id', $user_id)->where('period', $this->month)->get();
        
            if(count($this->status) > 0){
                $this->status = 'Paid';
            }else{
                $this->status = 'Unpaid';
            }
            session()->flash('successPay', "Salary for month {$this->month} has been paid!");
        }else{
            $this->alertPop = false;
            session()->flash('failedPay', "User is already paid for {$this->month}");
        }
    }

    public function openConfirm(){
        $this->alertPop = true;
    }

    public function closeConfirm(){
        $this->alertPop = false;
    }
}