<?php

namespace App\Http\Livewire\Orders;

use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Stocks;
use Livewire\Component;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrdersList extends Component
{
    public $orders, $products;
    public $status, $resEmail;
    public $togglePop = false, $updateStatus;
    public $updateOrder_id, $customer_type, $product, $customer_name, $total_price, $product_name, $lastQuantity;

    public function render()
    {
        return view('livewire.orders.orders-list');
    }

    public function mount(){
        $this->orders = Orders::with('business')->orderBy('id', 'desc')->get();
        $this->products = Products::all();
    }

    public function updated(){
        if($this->status != ""){
            $this->orders = Orders::with('business')->orderBy('id', 'desc')->where('status', $this->status)->get();
        }else{
            $this->orders = Orders::with('business')->orderBy('id', 'desc')->get();
        }

        if($this->product != ''){
            if($this->lastProduct == $this->product){
                if($this->quantity >= 1){
                    $order_new = Orders::where('id', $this->updateOrder_id)->get();
                    $total_price = $order_new[0]->total_price / $this->lastQuantity;
                    $this->total_price = $total_price * $this->quantity;
                }
            }else{
                $product = Products::where('id', $this->product)->get();
                $this->total_price = $product[0]->price * $this->quantity;
            }
        }else{
            $this->quantity = 0;
            $this->total_price = 0;
        }
    }

    public function toggleUpdate($order_id){
        $this->togglePop = true;
        $order = Orders::where('id', $order_id)->get();
        $this->customer_name = $order[0]->customer_name;
        $this->product = $order[0]->product_id;
        $this->quantity = $order[0]->quantity;
        $this->updateOrder_id = $order_id;
        $this->lastQuantity = $order[0]->quantity;
        $this->lastProduct = $order[0]->product_id;
        $this->total_price = $order[0]->total_price;
        $this->customer_type = $order[0]->customer_type;
        $this->updateStatus = $order[0]->status;
    }

    public function updateOrder($order_id){
        $this->validate([
            'customer_name' => 'required|string',
            'customer_type' => 'required|string',
            'product' => 'required|numeric',
            'updateStatus' => 'required|string',
        ]);

        if($this->updateOrder_id == $order_id){  
            if($this->quantity != 0 && $this->total_price != 0){
                $stock = Stocks::where('products_id', $this->product)->sum('stock_size');
                if($stock >= $this->quantity){
                    $order = Orders::find($order_id);
                    $order->customer_name = $this->customer_name;
                    $order->product_id = $this->product;
                    $order->total_price = $this->total_price;
                    $order->quantity = $this->quantity;
                    $order->customer_type = $this->customer_type;
                    if($this->updateStatus == 'Completed'){
                        $stock = Stocks::where('products_id', $this->product)->where('stock_size', '!=', 0)->get();
                        if($stock->count() > 0){
                            DB::table('orders_completed')->insert([
                                'quantity' => $this->quantity,
                                'products_id' => $this->product,
                                'total_price' => $this->total_price,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                            for($g = 0; $g < count($stock); $g++){
                                if($stock[$g]->stock_size >= $this->quantity){
                                    $stock[$g]->stock_size = $stock[$g]->stock_size - $this->quantity;
                                    $stock[$g]->save();
                                    break;
                                }else{
                                    $this->quantity = $this->quantity - $stock[$g]->stock_size;
                                    if($this->quantity >= 0){
                                        $stock[$g]->stock_size = 0;
                                        $stock[$g]->save();
                                    }else{
                                        $stock[$g]->stock_size = $stock[$g]->stock_size - $this->quantity;
                                        $stock[$g]->save();
                                    }
                                }
                            }
                            $order->status = $this->updateStatus;
                        }else{
                            session()->flash("failed-order", "Product has no stock left!");
                        }
                    }else{
                        $order->status = $this->updateStatus;
                    }
                    $order->save();
                    $this->togglePop = false;
                    session()->flash("success", 'Order has been successfully Updated!');
                    $this->mount();
                }else{
                    session()->flash("failed-order", "Product has <strong>{$stock}</strong> Stock left. But you are Placing Order for <strong>{$this->quantity}</strong>!");
                }
            }else{
                session()->flash("failed-order", "Product and Quantity Must Not Be Empty or Zero (0)!");
            }
        }else{
            session()->flash("failed-order", "Something went wrong with the system!");
        }
    }

    public function togglePopClose(){
        $this->togglePop = false;
    }
}