@section('title', 'Products | Employee Management')
<div>

    <h1 class="text-3xl mb-3 font-bold">Products List</span></h1>
    @if (session('failed'))
        <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
    @elseif(session('success'))
        <p class="bg-green-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('success') }}</p>
    @endif
    <input type="search" name="search" id="search" wire:model="search" placeholder="Search Product"
    class="bg-gray-700 text-gray-300 p-3 mb-5 w-full rounded-lg" autocomplete="off">
    <div class="bg-white p-3 rounded-lg">
        @if ($products != null)
            @if ($products->count())
            <span class="hidden">{{ $outOfStock = 0 }}</span>
            <table class="w-full bg-white rounded-lg shadow-sm">
                <tr>
                    <th class="px-2 py-4">Sr#</th>
                    <th class="px-2 py-4">Image</th>
                    <th class="px-2 py-4">Name</th>
                    <th class="px-2 py-4">Catagory</th>
                    <th class="px-2 py-4">Brand</th>
                    <th class="px-2 py-4">StockAvailable</th>
                    <th class="px-2 py-4">Backup Stock</th>
                    <th class="px-2 py-4">Unit</th>
                    <th class="px-2 py-4">Price Per Unit</th>
                    <th class="px-2 py-4">PerStockPrice</th>
                    <th class="px-2 py-4">Created</th>
                    <th class="px-2 py-4">Updated</th>
                    <th class="px-2 py-4">Update</th>
                    <th class="px-2 py-4">Barcode</th>
                </tr>
        
                @foreach ($products as $key => $product)
                    <tr class="text-center border-t border-t-gray-200 odd:bg-gray-200">
                        <td class="py-3">{{ $key + 1 }}</td>
                        <td class="py-3"><a href="{{ asset('storage/'.$product->image) }}" target="_blank"><div style="background-image:url({{ asset('storage/'.$product->image) }}); width:50px; height:50px; border-radius: 100%" class="bg-cover bg-center m-auto"></div></a></td>
                        <td class="py-3">{{ $product->name }}</td>
                        <td class="py-3">{{ $product->catagory->name }}</td>
                        <td class="py-3">
                        @if ($product->brand != null)
                            {{ $product->brand->name }}
                        @else
                            <span class="p-2 px-3 rounded-lg bg-red-500 text-white">No-Brand</span>
                        @endif
                        </td>
                        <td class="py-3">@if($product->stock->stock_size > 0) <span class="bg-green-800 font-bold text-white p-2 px-3 rounded-lg">{{ $product->stock->stock_size }} left</span> @else <span class="bg-red-500 text-white p-2 px-3 rounded-lg">Out-Of-Stock</span> @endif <br> @if($product->stock->stock_size <= 3) <span class="text-red-500 text-sm">Low Stock</span> @endif</td>
                            @if ($product->stock->stock_size == 0)
                                <span class="hidden">{{ $outOfStock += 1 }}</span>
                            @endif
                        <td class="py-3">{{ $product->unit->subunit.' - '.$product->unit->main_unit->name }}</td>
                        <td class="py-3">{{ number_format($product->price, 1) }}</td>
                        <td class="py-3">{{ number_format($product->stock->price_per_unit, 1) }}</td>
                        <td class="py-3">
                        @if ($product->price > $product->stock->price_per_unit)
                            <span class="p-2 px-3 rounded-lg bg-green-500 text-white font-bold">{{ number_format((($product->price - $product->stock->price_per_unit) / $product->stock->price_per_unit) * 100, 1) }}% Profit</span>
                        @elseif ($product->price == $product->stock->price_per_unit)
                            <span class="p-2 px-3 rounded-lg bg-yellow-500 text-white font-bold">NoProfitLoss</span>
                        @else
                            <span class="p-2 px-3 rounded-lg bg-red-500 text-white font-bold">{{ number_format((($product->price - $product->stock->price_per_unit) / $product->stock->price_per_unit) * 100, 1) }}% Loss</span>
                        @endif
                        </td>
                        <td class="py-3">{{ $product->created_at->format('d, M Y H:i') }}</td>
                        <td class="py-3">{{ $product->updated_at->format('d, M Y H:i') }}</td>
                        <td><button wire:click="toggleUpdate({{ $product->id }})" class="text-sm bg-indigo-500 p-2 rounded-md font-bold text-white"><i class="fas fa-edit mr-2"></i>Update</button></td>
                        <td><button wire:click="toggleBarPop({{ $product->barcode }})" class="text-sm bg-indigo-500 p-2 rounded-md font-bold text-white"><i class="fas fa-barcode"></i></button></td>
                    </tr>
                @endforeach

                @if ($toggleBarcode == true)
                    <div class="bg-gray-900 bg-opacity-90 fixed z-30 w-full h-screen left-0 top-0 flex justify-center items-center" wire:click="toggleBarPop(0)">
                        <div class="bg-white rounded-lg p-10 w-5/12 relative">
                            @php
                                $generatorJPG = new Picqer\Barcode\BarcodeGeneratorJPG();
                            @endphp
                            <a class="absolute -top-5 -right-5" href="data:image/png;base64,{{ base64_encode($generatorJPG->getBarcode($barCode, $generatorJPG::TYPE_CODE_128)) }}" download="{{ $proName.'-'.rand(1,100000) }}-barcode"><i class="fas fa-download text-white p-3 bg-purple-800 rounded-full mb-3 float-right text-3xl"></i></a>
                            <img class="w-full" src="data:image/png;base64,{{ base64_encode($generatorJPG->getBarcode($barCode, $generatorJPG::TYPE_CODE_128)) }}">
                        </div>
                    </div>
                @endif

                @if ($togglePop == true)
                    <div class="bg-gray-900 bg-opacity-90 fixed z-30 w-full h-screen left-0 top-0 flex justify-center items-center">
                        <div class="bg-white rounded-lg p-10 w-4/12">
                            <form method="post">
                                <div class="flex flex-col">
                                    <label class="text-gray-600 font-bold" for="name">Product Name:</label>
                                    <input type="text" wire:model="name" name="name" id="name" placeholder="Product Name"
                                    class="bg-gray-200 text-gray-800 p-3 mb-5">
                                    @error('name')
                                        <p class="mb-3 text-red-500">{{ $message }}</p>   
                                    @enderror
                                    <label class="text-gray-600 font-bold" for="catagory_id">Product Catagory:</label>
                                    <select wire:model="catagory_id" name="catagory_id" id="catagory_id"
                                    class="bg-gray-200 text-gray-800 p-3 mb-5">
                                        @if ($catagories->count() && $catagories != null)
                                            <option value="" selected>--Select Product Catagory--</option>
                                            @foreach ($catagories as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" selected>--Please add new Catagory first--</option>
                                        @endif
                                    </select>
                                    @error('catagory_id')
                                        <p class="mb-3 text-red-500">{{ $message }}</p>   
                                    @enderror
                    
                                    <label class="text-gray-600 font-bold" for="brand_id">Product Brand:</label>
                                    <select wire:model="brand_id" name="brand_id" id="brand_id"
                                    class="bg-gray-200 text-gray-800 p-3 mb-5">
                                        @if ($brands->count() && $brands != null)
                                            <option value="" selected>--Select Product Brand--</option>
                                            @foreach ($brands as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" selected>--Please add new Brand first--</option>
                                        @endif
                                    </select>
                                    @error('brand_id')
                                        <p class="mb-3 text-red-500">{{ $message }}</p>   
                                    @enderror
                    
                                    <label class="text-gray-600 font-bold" for="stocks_id">Product Stock:</label>
                                    <select wire:model="stocks_id" name="stocks_id" id="stocks_id"
                                    class="bg-gray-200 text-gray-800 p-3 mb-5">
                                        @if ($stocks->count() && $stocks != null)
                                            <option value="" selected>--Select Stock--</option>
                                            @foreach ($stocks as $item)
                                                <option value="{{ $item->id }}">{{ $item->stock_size.$item->main_unit->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" selected>--Please add stock first--</option>
                                        @endif
                                    </select>
                                    @error('stocks_id')
                                        <p class="mb-3 text-red-500">{{ $message }}</p>   
                                    @enderror
                    
                                    <label class="text-gray-600 font-bold" for="units_id">Product Unit:</label>
                                    <select wire:model="units_id" name="units_id" id="units_id"
                                    class="bg-gray-200 text-gray-800 p-3 mb-5">
                                        @if ($units->count() && $units != null)
                                            <option value="" selected>--Select Product Unit--</option>
                                            @foreach ($units as $item)
                                                <option value="{{ $item->id }}">{{ $item->subunit.$item->main_unit->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" selected>--Please add Unit first--</option>
                                        @endif
                                    </select>
                                    @error('units_id')
                                        <p class="mb-3 text-red-500">{{ $message }}</p>   
                                    @enderror
                    
                                    <label class="text-gray-600 font-bold" for="name">Product Price Per:</label>
                                    <input type="number" wire:model="price" name="price" id="price" placeholder="Price Per Main Unit"
                                    class="bg-gray-200 text-gray-800 p-3 mb-5">
                                    @error('price')
                                        <p class="mb-3 text-red-500">{{ $message }}</p>
                                    @enderror
                    
                                    <label class="text-gray-600 font-bold" for="image">Product Image:</label>
                                    <input type="file" wire:model="image" name="image" id="image"
                                    class="bg-gray-200 text-gray-800 p-3 mb-5">
                                    @error('image')
                                        <p class="mb-3 text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <ul class="grid grid-cols-2 gap-3">
                                    <button wire:click="togglePopClose()" class="text-white p-3 py-4 rounded-lg bg-red-500">Cancel</button>
                                    <button wire:click="updateProduct({{ $updateProduct_id }})" class="text-white p-3 py-4 rounded-lg bg-blue-500">Confirm</button>
                                </ul>
                            </form>
                        </div>
                    </div>
                @endif
            </table>

            @if ($outOfStock != 0)
                <p class="p-3 text-red-600">Product(s) Out Of Stock. Please Add and Assign New Stock!</p>
            @endif
            @else
                <p class="text-2xl">No Data available about Products!</p>
            @endif
        @else
            <p class="text-2xl">No Data available about Products!</p>
        @endif
    </div>
</div>
