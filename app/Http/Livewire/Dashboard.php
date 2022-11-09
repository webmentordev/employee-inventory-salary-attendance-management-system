<?php


namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Orders;
use App\Models\Stocks;
use Livewire\Component;
use App\Models\Business;
use App\Models\Catagory;
use App\Models\Products;
use App\Models\Attendance;
use App\Models\Designation;
use App\Models\StockHistory;
use Illuminate\Support\Facades\DB;
use App\Models\Suppliers;

class Dashboard extends Component
{
    public $wHours, $users, $managers, $designations, $active, $roles;
    public $inactive, $dates = [], $result, $products;
    public $stock;
    public function render()
    {
        return view('livewire.dashboard');
    }

    public function mount(){
        $this->users = count(User::all());
        $this->designations = count(Designation::all());
        $this->roles = count(Role::all());
        $this->active = count(User::where('status', 'active')->get());
        $this->inactive = count(User::where('status', 'inactive')->get());
        $this->users = count(User::all());
        $this->business = count(Business::all());
        $this->supplier = count(Suppliers::all());
        $this->products = count(Products::all());
        $this->catagories = count(Catagory::all());
        $this->orders = count(Orders::all());
        $this->orders_pending = count(Orders::where('status', 'Pending')->get());
        $this->stock = Stocks::sum('stock_size');
        $this->stock_sold = DB::table('orders_completed')->sum('quantity');
        $this->soldPrice = DB::table('orders_completed')->sum('total_price');
        $this->workHours = User::sum('work_hours');
        $this->stock_worth = Stocks::sum('stock_price');

        $this->stockHistory = StockHistory::sum('stock_size');

        $this->wHours = DB::table('users')->sum('work_hours');

        $today = today(); 
        $myDates = [];

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $myDates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d/m/Y');
        }

        // dd(Carbon::createFromDate($myDates[0])->format('D'));

        for($k = 0; $k < count($myDates); $k++){
            if(Carbon::createFromFormat('d/m/Y', $myDates[$k], 'Asia/Karachi')->format('D') == 'Sun'){
                continue;
            }else{
                $this->dates[] = Carbon::createFromFormat('d/m/Y', $myDates[$k], 'Asia/Karachi')->format('D, d/m/Y');
            }
        }

        $working = [];
        $myHours = 0;

        for($m = 0; $m < count($this->dates); $m++){
            $working[] = DB::table('attendances')->whereDate('created_at', '=', Carbon::createFromFormat('D, d/m/Y', $this->dates[$m])->format('Y-m-d'))->get();
        }

        for($n = 0; $n < count($working); $n++){
            if($working[$n]->count() == 0){
                $this->result[] = 0;
            }else{
                for($z = 0; $z < count($working[$n]); $z++){
                    $myHours = $myHours + (Carbon::createFromDate($working[$n][$z]->updated_at)->diffInMinutes(Carbon::createFromDate($working[$n][$z]->created_at)));
                }
                $this->result[] = $myHours / 60;
                $myHours = null;
            }
        }
    }
}