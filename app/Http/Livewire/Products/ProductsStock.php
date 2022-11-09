<?php

namespace App\Http\Livewire\Products;

use App\Models\StockHistory;
use App\Models\Units;
use App\Models\Stocks;
use App\Models\Suppliers;
use Livewire\Component;

class ProductsStock extends Component
{
    public $units, $stocks, $unit, $size, $stock_price, $suppliers, $supplier;
    public $togglePop = false, $updateSize, $updateStock_price;
    public $updateStock_id, $updatePrice, $updateUnit, $updateSupplier;


    public function render()
    {
        return view('livewire.products.products-stock');
    }

    public function mount(){
        $this->units = Units::all();
        $this->stocks = Stocks::with('stockOfProduct')->get();
        $this->suppliers = Suppliers::all();
    }

    public function updated($field){
        $this->validateOnly($field, [
            'unit'=>'required|numeric',
            'size'=>'required',
            'stock_price'=>'required|numeric',
            'supplier'=>'required|numeric',
            'updatePrice'=>'required|numeric',
            'updateSupplier'=>'required|numeric',
            'updateUnit'=>'required|numeric',
        ]);
    }

    public function saveData(){
        $this->validate([
            'unit' => 'required|numeric',
            'size'=>'required',
            'stock_price'=>'required|numeric',
            'supplier'=>'required|numeric',
        ]);

        Stocks::create([
            'stock_size' => $this->size,
            'units_id'=>$this->unit,
            'stock_price'=>$this->stock_price,
            'price_per_unit'=> $this->stock_price / $this->size,
            'supplier_id'=>$this->supplier,
        ]);

        session()->flash('success', 'Stock succesfully added!');
        $this->stocks = Stocks::with('stockOfProduct')->get();

        StockHistory::create([
            'stock_size' => $this->size,
            'units_id'=>$this->unit,
            'stock_price'=>$this->stock_price,
            'price_per_unit'=> $this->stock_price / $this->size,
            'supplier_id'=>$this->supplier,
        ]);
    }

    public function toggleUpdate($stock_id){
        $this->togglePop = true;
        $stock = Stocks::find($stock_id);
        $this->updatePrice = $stock->stock_price;
        $this->updateUnit = $stock->units_id;
        $this->updateSupplier = $stock->supplier_id;
        $this->updateStock_id = $stock_id;
    }

    public function updateStock($stock_id){
        $this->validate([
            'updatePrice'=>'required|numeric',
            'updateSupplier'=>'required|numeric',
            'updateUnit'=>'required|numeric',
        ]);

        if($this->updateStock_id == $stock_id){
            $stock = Stocks::find($stock_id);
            $stock->stock_price = $this->updatePrice;
            $stock->units_id = $this->updateUnit;
            $stock->supplier_id = $this->updateSupplier;
            $stock->price_per_unit = $this->updatePrice / $stock->stock_size;
            $stock->save();
            session()->flash('success', 'Stock Updated Succesfully!');
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