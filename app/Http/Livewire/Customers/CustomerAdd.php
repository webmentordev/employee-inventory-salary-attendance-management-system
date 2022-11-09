<?php

namespace App\Http\Livewire\Customers;

use Livewire\Component;
use App\Models\Business;
use App\Models\Customers;

class CustomerAdd extends Component
{
    public $businesses;

    public $first_name, $last_name, $mobile_number, $email, $city, $country, $address, $business, $c_address;
    
    public function render()
    {
        return view('livewire.customers.customer-add');
    }

    public function mount(){
        $this->businesses = Business::where('customer_id', null)->get();
    }

    public function updated($field){
        $this->validateOnly($field,[
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'mobile_number'=>'required|numeric',
            'email'=>'required|email',
            'city'=>'required|string',
            'country'=>'required|string',
            'c_address'=>'required|string',
            'business'=>'required|numeric',
        ]);
    }

    public function saveData(){
        $this->validate([
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'mobile_number'=>'required|numeric',
            'email'=>'required|email',
            'city'=>'required|string',
            'country'=>'required|string',
            'c_address'=>'required|string',
            'business'=>'required|numeric',
        ]);

        $customer = Customers::create([
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'mobile_number'=>$this->mobile_number,
            'email'=>$this->email,
            'city'=>$this->city,
            'country'=>$this->country,
            'address'=>$this->c_address,
            'business_id'=>$this->business,
        ]);

        session()->flash('success', 'Customer Registered Successfully!');

        $business = Business::find($this->business);
        $business->customer_id = $customer->id;
        $business->save();

        $this->first_name="";
        $this->last_name="";
        $this->mobile_number="";
        $this->email="";
        $this->city="";
        $this->country="";
        $this->c_address="";
        $this->business="";
    }
}
