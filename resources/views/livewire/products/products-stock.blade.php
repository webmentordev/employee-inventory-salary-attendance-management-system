@section('title', 'Products Stock | Employee Management')
<div>
    <h1 class="text-3xl mb-3 font-bold">Products Stocks</span></h1>
    @if (session('failed'))
        <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
    @elseif(session('success'))
        <p class="bg-green-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('success') }}</p>
    @endif
    <div class="bg-white rounded-lg p-3 mb-3">
        <p class="text-gray-800 p-3 mb-3 bg-yellow-200 rounded-t-lg"><i class="fas fa-exclamation fa-fw py-3 px-5 mr-3 rounded-full border-2 border-gray-700"></i> Total Stock can not be updated after added to database. Verify Before adding stock!</p>
        <form wire:submit.prevent="saveData" method="post" class="w-full odd:mr-3">
            <div class="grid grid-cols-5 w-full gap-3">
                <div class="col-span-1 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="size">Stock Size:</label>
                    <input type="number" wire:model="size" name="size" id="size" autocomplete="off" placeholder="Amount Of Stock"
                    class="bg-gray-200 text-gray-800 p-3 rounded-lg 
                    @error('size')
                        mb-3
                    @enderror">
                    @error('size')
                        <p class="text-red-500 px-3">{{ $message }}</p>   
                    @enderror
                </div>

                <div class="col-span-1 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="unit">MainUnit:</label>
                    <select wire:model="unit" name="unit" id="unit" placeholder="unit (1, 1/2 etc)"
                    class="bg-gray-200 text-gray-800 p-[15px] rounded-lg @error('unit') mb-3 @enderror @if ($units->count() == 0 || $units == null) border-2 border-red-500 @endif">
                        @if ($units->count() && $units != null)
                            <option value="" selected>---Select Main Unit---</option>
                            @foreach ($units as $mainUnit)
                                <option value="{{ $mainUnit->id }}">{{ $mainUnit->name }}</option>
                            @endforeach
                        @else
                            <option value="" selected>---Please Add Main Unit---</option>
                        @endif
                    </select>
                    @error('unit')
                        <p class="text-red-500 px-3">{{ $message }}</p>   
                    @enderror
                </div>

                <div class="col-span-1 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="supplier">Supplier:</label>
                    <select wire:model="supplier" name="supplier" id="supplier" placeholder="unit (1, 1/2 etc)"
                    class="bg-gray-200 text-gray-800 p-[15px] rounded-lg @error('unit') mb-3 @enderror @if ($suppliers->count() == 0 || $suppliers == null) border-2 border-red-500 @endif">
                        @if ($suppliers->count() && $suppliers != null)
                            <option value="" selected>---Select Stock Supplier---</option>
                            @foreach ($suppliers as $supply)
                                <option value="{{ $supply->id }}">{{ $supply->name }}</option>
                            @endforeach
                        @else
                            <option value="" selected>---Please Supplier First---</option>
                        @endif
                    </select>
                    @error('unit')
                        <p class="text-red-500 px-3">{{ $message }}</p>   
                    @enderror
                </div>

                <div class="col-span-1 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="stock_price">StockPrice:</label>
                    <input type="number" wire:model="stock_price" name="stock_price" id="stock_price" autocomplete="off" placeholder="Stock Price"
                    class="bg-gray-200 text-gray-800 p-3 rounded-lg 
                    @error('stock_price')
                        mb-3
                    @enderror">
                    @error('stock_price')
                        <p class="text-red-500 px-3">{{ $message }}</p>   
                    @enderror
                </div>
                <button type="submit" class="bg-green-600 mt-8 h-fit text-white font-bold rounded-lg px-4 py-3 block w-full">Add-Stock</button>
            </div>
        </form>
    </div>

    <div class="bg-white p-3 rounded-lg">
        @if ($stocks != null)
            @if ($stocks->count())
            <table class="w-full bg-white rounded-lg shadow-sm">
                <tr>
                    <th class="px-2 py-4">Sr#</th>
                    <th class="px-2 py-4">SockSize</th>
                    <th class="px-2 py-4">SockPrice</th>
                    <th class="px-2 py-4">PricePerUnit</th>
                    <th class="px-2 py-4">StockUnit</th>
                    <th class="px-2 py-4">Product</th>
                    <th class="px-2 py-4">Supplier</th>
                    <th class="px-2 py-4">Created</th>
                    <th class="px-2 py-4">Updated</th>
                    <th class="px-2 py-4">Update</th>
                </tr>
        
                @foreach ($stocks as $key => $stock)
                    <tr class="text-center border-t border-t-gray-200">
                        <td class="py-3">{{ $key + 1 }}</td>
                        <td class="py-3">{{ $stock->stock_size }}</td>
                        <td class="py-3">{{ number_format($stock->stock_price, 1) }}</td>
                        <td class="py-3">{{ number_format($stock->price_per_unit, 1) }}</td>
                        <td class="py-3">{{ $stock->main_unit->name }}</td>
                        <td class="py-3"> @if ($stock->products_id != null) <span class="bg-blue-300 p-2 px-3 rounded-lg">{{ substr($stock->stockOfProduct->name, 0, 10) }}...</span> @else <span class="bg-red-500 text-white p-2 rounded-lg px-3">Not-Assigned</span> @endif </td>
                        <td class="py-3">
                            @if ($stock->supplier != null)
                                {{ $stock->supplier->name }}
                            @else
                                <span>No Supplier</span>
                            @endif
                        </td>
                        <td class="py-3">{{ $stock->created_at->format('D, d, M Y H:i A') }}</td>
                        <td class="py-3">{{ $stock->updated_at->format('D, d, M Y H:i A') }}</td>
                        <td><button wire:click="toggleUpdate({{ $stock->id }})" class="text-sm bg-indigo-500 p-2 rounded-md font-bold text-white"><i class="fas fa-edit mr-2"></i>Update</button></td>
                    </tr>
                @endforeach
                @if ($togglePop == true)
                    <div class="bg-gray-900 bg-opacity-90 fixed z-30 w-full h-screen left-0 top-0 flex justify-center items-center">
                        <div class="bg-white rounded-lg p-10 w-4/12 flex flex-col">
                            <form method="post">
                                <div class="col-span-1 flex flex-col mb-3">
                                    <label class="text-gray-600 font-bold mb-2" for="updateUnit">MainUnit:</label>
                                    <select wire:model="updateUnit" name="updateUnit" id="updateUnit" placeholder="unit (1, 1/2 etc)"
                                    class="bg-gray-200 text-gray-800 p-[15px] rounded-lg @error('updateUnit') mb-3 @enderror @if ($units->count() == 0 || $units == null) border-2 border-red-500 @endif">
                                        @if ($units->count() && $units != null)
                                            <option value="" selected>---Select Main Unit---</option>
                                            @foreach ($units as $mainUnit)
                                                <option value="{{ $mainUnit->id }}">{{ $mainUnit->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" selected>---Please Add Main Unit---</option>
                                        @endif
                                    </select>
                                    @error('updateUnit')
                                        <p class="text-red-500 px-3">{{ $message }}</p>   
                                    @enderror
                                </div>
                
                                <div class="col-span-1 flex flex-col mb-3">
                                    <label class="text-gray-600 font-bold mb-2" for="updateSupplier">Supplier:</label>
                                    <select wire:model="updateSupplier" name="updateSupplier" id="updateSupplier"
                                    class="bg-gray-200 text-gray-800 p-[15px] rounded-lg @error('updateSupplier') mb-3 @enderror @if ($suppliers->count() == 0 || $suppliers == null) border-2 border-red-500 @endif">
                                        @if ($suppliers->count() && $suppliers != null)
                                            <option value="" selected>---Select Stock Supplier---</option>
                                            @foreach ($suppliers as $supply)
                                                <option value="{{ $supply->id }}">{{ $supply->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" selected>---Please Supplier First---</option>
                                        @endif
                                    </select>
                                    @error('updateSupplier')
                                        <p class="text-red-500 px-3">{{ $message }}</p>   
                                    @enderror
                                </div>
                
                                <div class="col-span-1 flex flex-col mb-3">
                                    <label class="text-gray-600 font-bold mb-2" for="updatePrice">StockPrice:</label>
                                    <input type="number" wire:model="updatePrice" name="updatePrice" id="updatePrice" autocomplete="off" placeholder="Stock Price"
                                    class="bg-gray-200 text-gray-800 p-3 rounded-lg 
                                    @error('updatePrice')
                                        mb-3
                                    @enderror">
                                    @error('updatePrice')
                                        <p class="text-red-500 px-3">{{ $message }}</p>   
                                    @enderror
                                </div>
    
                                <ul class="grid grid-cols-2 gap-3">
                                    <button wire:click="togglePopClose()" class="text-white p-3 py-4 rounded-lg bg-red-500">Cancel</button>
                                    <button type="submit" wire:click="updateStock({{ $updateStock_id }})" class="text-white p-3 py-4 rounded-lg bg-blue-500">Confirm</button>
                                </ul>
                            </form>
                        </div>
                    </div>
                @endif
            </table>
            @else
                <p class="text-2xl">No Data available about Stock!</p>
            @endif
        @else
            <p class="text-2xl">No Data available about Stock!</p>
        @endif
    </div>
</div>
