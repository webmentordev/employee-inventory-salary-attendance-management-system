<?php

namespace App\Http\Livewire\Orders;

use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Stocks;
use Livewire\Component;
use App\Models\Business;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class OrdersAdd extends Component
{
    public $business, $customer_id, $customer_name, $customer_type, $quantity = 1, $outOfStock = 0;
    public $businesses, $products;
    public $productCart = array(), $product, $total_price = 0;
    public $togglePop = false, $discount = 0;
    public function render()
    {
        return view('livewire.orders.orders-add');
    }

    public function mount(){
        $this->businesses = Business::all();
        $this->products = Products::all();
    } 

    public function updated($field){

        $this->validateOnly($field, [
            'customer_name' => 'required|string',
            'customer_type' => 'required|string',
            'business'=>'nullable|numeric',
            'quantity'=>'numeric',
            'discount'=>'required|numeric',
        ]);

        if($this->business != ""){
            $business = Business::with('registeredCustomer')->where('id', $this->business)->where('customer_id', '!=', null)->get();
            if($business != null && $business->count() == 1){
                $this->customer_name = $business[0]->registeredCustomer->first_name.' '.$business[0]->registeredCustomer->last_name;
                $this->customer_id = $business[0]->registeredCustomer->id;
                $this->discount = $business[0]->default_discount;
            }else{
                session()->flash('no_customer', 'Customer Name does not exist, Please register business on customer name.');
            }
        }

        if($this->customer_type == 'Walk_In_Customer'){
            $this->customer_id = null;
            $this->business = null;
        }

        if(count($this->productCart) == 0){
            $this->total_price = 0;
        }
    }

    public function addProduct(){
        $product = Products::with('stock')->where('id', $this->product)->get();
        $stock = Stocks::where('products_id', $this->product)->sum('stock_size');
        $stockPrice = Stocks::where('products_id', $this->product)->get();

        if($this->product != ""){
            if($this->quantity > 0){
                $discounted = ($product[0]->price * 100) / (100 + $this->discount);
                if($discounted < $stockPrice[0]->price_per_unit * $this->quantity){
                    $profitStatus = "Loss";
                }elseif($discounted > $stockPrice[0]->price_per_unit * $this->quantity){
                    $profitStatus = "Profit";
                }
                
                $array = array(
                    'id' => $product[0]->id,
                    "name" => $product[0]->name,
                    "quantity" => $this->quantity,
                    "price" => $discounted,
                    'stock_left' => $stock,
                    'discount' => $this->discount,
                    'profitStatus' => $profitStatus
                );
        
                array_push($this->productCart, $array);
          
                $array = array_values($this->productCart);
        
                if(count($this->productCart)){
                    $price = 0;
                    for($i = 0; $i < count($array); $i++){
                        $price += $array[$i]['price'] * $array[$i]['quantity'];
                    }
                    $this->total_price = $price;
                }
        
                $this->quantity = 1;
                $this->product = "";
            }else{
                session()->flash('failed', 'Quantity must be more then Zero (0)!');
            }
        }else{
            session()->flash('failed', 'Product must not be empty. Please select a product!');
        }
    }

    public function removeProduct($key){
        unset($this->productCart[$key]);
        $filteredArray = array_values($this->productCart);
        if(count($filteredArray)){
            $price = 0;
            for($i = 0; $i < count($filteredArray); $i++){
                $price += $filteredArray[$i]['price'] * $filteredArray[$i]['quantity'];
            }
            $this->total_price = $price;
        }else{
            $this->total_price = 0;
        }
        $this->mount();
    }

    public function resetCart(){
        unset($this->productCart);
        $this->productCart = array();
        $this->total_price = 0;
        $this->mount();
    }

    public function togglePopMessage(){
        if($this->togglePop == false){
            $this->togglePop = true;
        }else{
            $this->togglePop = false;
        }
    }

    public function saveData(){
        $this->validate([
            'customer_name' => 'required|string',
            'customer_type' => 'required|string',
            'business'=>'nullable|string',
        ]);

        $presentStock = 0;
        for($k = 0; $k < count($this->productCart); $k++){
            if($this->productCart[$k]['quantity'] > $this->productCart[$k]['stock_left']){
                $presentStock++;
            }
        }
        
        if($presentStock == 0){
            if(count($this->productCart) > 0){
                for($i = 0; $i < count($this->productCart); $i++){
                    Orders::create([
                        'customer_name' => $this->customer_name,
                        'customer_type' => $this->customer_type,
                        'business_id' => $this->business,
                        'customer_id' => $this->customer_id,
                        'quantity' => $this->productCart[$i]['quantity'],
                        'product_id' => $this->productCart[$i]['id'],
                        'total_price' => $this->productCart[$i]['quantity'] * $this->productCart[$i]['price'],
                        'discount' => $this->productCart[$i]['discount'],
                    ]);
                }
                session()->flash('success', 'Order Successfully Placed! But Orders are pending so complete them!');
                $this->togglePop = false;
                $this->resetCart();
                $this->mount();
            }else{
                $this->togglePop = false;
                session()->flash('failed', 'Cart is empty. Please Add Product!');
            }
        }else{
            $this->togglePop = false;
            session()->flash('failed', 'Product(s) are Totally Out Of Stock. Please add their stock first then try!');
        }
    }
}