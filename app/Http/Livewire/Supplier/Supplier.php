<?php

namespace App\Http\Livewire\Supplier;

use Livewire\Component;
use App\Models\Suppliers;

class Supplier extends Component
{
    public $suppliers;
    public $name, $mobile_number, $c_address, $email;
    public $togglePop = false;
    public $updateSupplier_id, $updateName, $updateEmail, $updateAddress, $updateMobile;

    public function render()
    {
        return view('livewire.supplier.supplier');
    }

    public function mount(){
        $this->suppliers = Suppliers::get();
    }

    public function updated($field){
        $this->validateOnly($field, [
            'name'=>'required|string',
            'mobile_number'=>'required|numeric',
            'c_address'=>'required|string',
            'email'=>'required|email',
        ]);
    }

    public function saveData(){
        $this->validate([
            'name'=>'required|string|unique:suppliers',
            'mobile_number'=>'required|numeric|unique:suppliers',
            'c_address'=>'required|string',
            'email'=>'required|email',
        ]);

        Suppliers::create([
            'name'=>$this->name,
            'mobile_number'=>$this->mobile_number,
            'address'=>$this->c_address,
            'email'=>$this->email,
        ]);

        $this->name = "";
        $this->mobile_number = "";
        $this->c_address = "";
        $this->email = "";

        session()->flash('success', 'Supplier Successfully Added!');
        $this->mount();
    }


    public function toggleUpdate($supplier_id){
        $this->togglePop = true;
        $this->updateSupplier_id = $supplier_id;
        $supplier = Suppliers::find($supplier_id);
        $this->updateName =  $supplier->name;
        $this->updateAddress =  $supplier->address;
        $this->updateMobile =  $supplier->mobile_number;
        $this->updateEmail =  $supplier->email;
    }

    public function updateSupplier($supplier_id){

        $this->validate([
            'updateName'=>'required|string',
            'updateMobile'=>'required|numeric',
            'updateAddress'=>'required|string',
            'updateEmail'=>'required|email',
        ]);

        if($this->updateSupplier_id == $supplier_id){
            $supplier = Suppliers::find($supplier_id);
            $supplier->name = $this->updateName;
            $supplier->email = $this->updateEmail;
            $supplier->address = $this->updateAddress;
            $supplier->mobile_number = $this->updateMobile;
            $supplier->save();
            session()->flash('success', 'Supplier Data Successfully Updated!');
            $this->togglePop = false;
            $this->mount();
            
        }else{
            $this->togglePop = false;
            session()->flash('failed', 'Something Went wrong with the system!');
        }
    }

    public function togglePopClose(){
        $this->togglePop = false;
        $this->updateName =  "";
        $this->updateAddress =  "";
        $this->updateMobile =  "";
        $this->updateEmail =  "";
    }
}
