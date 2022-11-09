<?php

namespace App\Http\Livewire\Business;

use App\Models\Business;
use Livewire\Component;
use App\Models\BusinessTypes;

class BusinessList extends Component
{
    public $businessTypes, $type, $discount, $name;
    public $businesses, $updateBusiness_id = 0, $updateBusiness , $togglePop = false;
    public $updateName, $updateType, $updateDiscount;

    public function render()
    {
        return view('livewire.business.business-list');
    }

    public function mount()
    {
        $this->businessTypes = BusinessTypes::all();
        $this->businesses = Business::with(['registeredCustomer'])->get();
    }

    public function updated($field){
        $this->validateOnly($field, [
            'name'=>'required|unique:businesses',
            'type'=>'required|numeric',
            'discount'=>'nullable|numeric'
        ]);
    }

    public function saveData(){
        $this->validate([
            'name'=>'required|unique:businesses',
            'type'=>'required|numeric',
            'discount'=>'nullable|numeric'
        ]);

        Business::create([
            'name'=>$this->name,
            'business_type_id' => $this->type,
            'default_discount' => $this->discount,
        ]);

        session()->flash('success', 'Business Successfully Registered!');

        $this->name = "";
        $this->type = "";
        $this->discount = "";
        $this->mount();
    }

    public function toggleUpdate($business_id){
        $this->togglePop = true;
        $this->updateBusiness_id = $business_id;
        $business = Business::find($business_id);
        $this->updateName = $business->name;
        $this->updateType = $business->business_type_id;
        $this->updateDiscount = $business->default_discount;
    }

    public function togglePopClose(){
        $this->togglePop = false;
    }

    public function updateBusiness($business_id){
        $this->validate([
            'updateName'=>'required',
            'updateType'=>'required|numeric',
            'updateDiscount'=>'nullable|numeric'
        ]);

        $validate = Business::where('id', '!=', $business_id)->where('name', $this->updateName)->get();
        if($business_id == $this->updateBusiness_id){
            if($validate->count() == 0){
                $business = Business::find($business_id);
                $business->name = $this->updateName;
                $business->business_type_id = $this->updateType;
                if($this->updateDiscount != ""){
                    $business->default_discount = $this->updateDiscount;
                }else{
                    $business->default_discount = null;
                }
                $business->save();
            }else{
                session()->flash('failed', 'Business with same name already Exists');
            }
        }else{
            session()->flash('failed', 'Something Went Wrong with the system!');
        }
        
        session()->flash('success', 'Business succesfully Updated!');
        $this->mount();
        $this->togglePop = false;
    }
}