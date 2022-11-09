<?php

namespace App\Http\Livewire\Customers;

use Livewire\Component;
use App\Models\Business;
use App\Models\Customers;

class CustomerList extends Component
{
    public $customers, $businesses;

    public $first_name, $last_name, $mobile_number, $email, $city, $country, $address, $business, $c_address;
    public $togglePop = false, $updateCustomer_id = 0, $businessHistoryID;

    public function render()
    {
        return view('livewire.customers.customer-list');
    }

    public function mount(){
        $this->customers = Customers::all();
        $this->businesses = Business::where('customer_id', null)->get();
    }

    public function updated($field){
        $this->validateOnly($field, [
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

    public function toggleUpdate($customer_id){
        $this->togglePop = true;
        $this->updateCustomer_id = $customer_id;
        $customer = Customers::find($customer_id);
        $this->first_name = $customer->first_name;
        $this->last_name = $customer->last_name;
        $this->mobile_number = $customer->mobile_number; 
        $this->email = $customer->email; 
        $this->city = $customer->city;
        $this->country = $customer->country;
        $this->business = $customer->business_id;
        $this->c_address = $customer->address;
        $this->businessHistoryID = $customer->business_id;
 
    }

    public function updateCustomer($customer_id){
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


        if($this->updateCustomer_id == $customer_id){
            $customer = Customers::find($customer_id);
            $customer->first_name = $this->first_name;
            $customer->last_name = $this->last_name;
            $customer->email = $this->email;
            $customer->city = $this->city;
            $customer->country = $this->country;
            $customer->address = $this->c_address;
            $customer->mobile_number = $this->mobile_number;
            $customer->business_id = $this->business;
            
            if($this->businessHistoryID != $this->business){
                $business = Business::find($this->businessHistoryID);
                $business->customer_id = null;
                $business->save();

                $businessNew = Business::find($this->business);
                $businessNew->customer_id = $customer_id;
                $businessNew->save();
            }

            $customer->save();

            session()->flash('success', 'Customer Data Successfully Updated!');
            $this->togglePop = false;
            $this->mount();

        }else{
            $this->togglePop = false;
            session()->flash('failed', 'Something went wrong with update!');
        }
    }

    public function togglePopClose(){
        $this->togglePop = false;
    }
}
