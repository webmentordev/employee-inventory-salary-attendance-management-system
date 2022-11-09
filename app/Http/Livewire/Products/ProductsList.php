<?php

namespace App\Http\Livewire\Products;

use App\Models\Brands;
use App\Models\Stocks;
use Livewire\Component;
use App\Models\Catagory;
use App\Models\Products;
use App\Models\Subunits;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ProductsList extends Component
{
    use WithFileUploads;
    use WithPagination;
    
    public $products, $search;
    public $updateProduct_id = 0, $togglePop = false;
    public $name, $price, $product, $stocks_id, $stock, $brands, $brand_id; 
    public $catagory_id, $catagories, $units_id, $image, $units;
    public $toggleBarcode = false, $barCode = 0, $proName; 

    public function mount(){
        $this->products = Products::with(['stock', 'catagory', 'unit', 'brand'])->get();
        $this->catagories = Catagory::all();
        $this->units = Subunits::all();
        $this->stocks = Stocks::with('main_unit')->where('products_id', null)->get();
        $this->brands = Brands::all();
    }

    public function render()
    {
        return view('livewire.products.products-list');
    }


    public function updated(){
        $this->products = Products::with(['stock', 'catagory', 'unit', 'brand'])->where('name', 'like', '%'.$this->search.'%')->get();
    }


    public function toggleUpdate($brand_id){
        $this->togglePop = true;
        $this->updateProduct_id = $brand_id;
        $product = Products::find($brand_id);
        $this->name = $product->name;
        $this->stocks_id = $product->stocks_id;
        $this->catagory_id = $product->catagory_id;
        $this->units_id = $product->units_id;
        $this->price = $product->price;
        $this->brand_id = $product->brand_id;
    }

    public function togglePopClose(){
        $this->togglePop = false;
    }

    public function updateProduct($product_id){
        $this->validate([
            'name'=>'required',
            'stocks_id'=>'required|numeric',
            'catagory_id'=>'required',
            'units_id'=>'required|numeric',
            'price'=>'required|numeric',
            'brand_id'=>'nullable|numeric',
            'image'=>'nullable|image|mimes:png,jpg'
        ]);

        $validate = Products::where('id', '!=', $product_id)->where('name', $this->name)->get();

        if($product_id == $this->updateProduct_id){
            if($validate->count() == 0){
                $product = Products::find($product_id);
                $product->name = $this->name;
                $product->catagory_id= $this->catagory_id;
                $product->units_id = $this->units_id;
                $product->price= $this->price;
                $product->brand_id= $this->brand_id;
                if($this->stocks_id != null){
                    $product->stocks_id= $this->stocks_id;
                    $stock = Stocks::find($this->stocks_id);
                    $stock->products_id = $product->id;
                    $stock->status = "Assigned";
                    $stock->save();
                }
                if($this->image != null){
                    $product->image = $this->image->store('products');
                }
                $product->save();
            }else{
                session()->flash('failed', 'Product Already Exists');
            }
        }else{
            session()->flash('failed', 'Something Went Wrong with the system!');
        }
        
        session()->flash('success', 'Product succesfully Updated!');
        $this->updated();
        $this->togglePop = false;
    }


    public function toggleBarPop($barcode){
        if($this->toggleBarcode == false){
            $product = Products::where('barcode', $barcode)->get();
            $this->proName = str_replace(' ', '-', $product[0]->name);
            $this->toggleBarcode = true;
            $this->barCode = $barcode;
        }else{
            $this->toggleBarcode = false;
            $this->barCode = 0;
            $this->proName = null;
        }
    }
}