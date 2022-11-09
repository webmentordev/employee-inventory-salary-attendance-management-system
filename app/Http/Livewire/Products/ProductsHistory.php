<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;
use App\Models\StockHistory;

class ProductsHistory extends Component
{
    public $stockHistory;

    public function render()
    {
        return view('livewire.products.products-history');
    }

    public function mount(){
        $this->stockHistory = StockHistory::all();
    }
}