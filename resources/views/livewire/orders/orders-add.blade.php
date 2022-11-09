@section('title', 'Orders Add | Orders Management')
<div>
    <h1 class="text-3xl mb-3 font-bold">Orders Placement</h1>
    @if (session('failed'))
        <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
    @elseif(session('success'))
        <p class="bg-green-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('success') }}</p>
    @endif
    {{-- <div class="fixed bottom-3 right-3">
        <div class="relative bg-slate-100 shadow-md rounded-full">
            <span class="-top-3 -left-2 absolute text-white bg-blue-600 rounded-full p-1 px-3">{{ count($productCart) }}</span>
            <button class="p-4 text-gray-800 rounded-full"><i class="fas fa-shopping-cart text-3xl"></i></button>
        </div>
    </div> --}}
    <div class="bg-white p-3 rounded-lg">
        <div class="flex flex-col">
            <label class="text-gray-600 font-bold" for="customer_type">Customer Type:</label>
            <select wire:model="customer_type" name="customer_type" id="customer_type"
            class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                <option value="" selected>---Select Customer Type---</option>
                <option value="Walk_In_Customer">Walk-In-Customer</option>
                <option value="Registered_Business">Registered-Business</option>
            </select>
            @error('customer_type')
                <p class="mb-3 text-red-500">{{ $message }}</p>   
            @enderror
        </div>

        @if ($customer_type == "Registered_Business")
            <div class="flex flex-col">
                <label class="text-gray-600 font-bold" for="business">Business:</label>
                <select wire:model="business" name="business" id="business"
                class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                    @if ($businesses->count() && $businesses != null)
                        <option value="" selected>--Select Business--</option>
                        @foreach ($businesses as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    @else
                        <option value="" selected>No Registered Business Found!</option>
                    @endif
                </select>
                @error('business')
                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                @enderror
            </div>
        @endif

        <div class="flex flex-col">
            <label class="text-gray-600 font-bold" for="customer_name">Customer Name:</label>
            <input type="text" wire:model="customer_name" name="customer_name" id="customer_name" placeholder="Customer Name"
            class="bg-gray-200 p-3 mb-3 @if (session('no_customer') && $customer_type == 'Registered_Business') text-gray-400 opacity-2 @endif " autocomplete="off" @if (session('no_customer') && $customer_type == 'Registered_Business') disabled @endif>
            @error('customer_name')
                <p class="mb-3 text-red-500">{{ $message }}</p>   
            @enderror
            @if (session('no_customer') && $customer_type == 'Registered_Business') 
            <p class="mb-1 text-red-500">{{ session('no_customer') }}</p> 
            @endif
        </div>

        <div class="flex flex-col">
            <label class="text-gray-600 font-bold" for="discount">Discount:</label>
            <input type="number" wire:model="discount" name="discount" id="discount" placeholder="Add Dicount"
            class="bg-gray-200 p-[10px] mb-3 @if ($customer_type == "Registered_Business") text-gray-600 @endif" @if ($customer_type == "Registered_Business") disabled @endif>
            @error('discount')
                <p class="mb-3 text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-5 gap-2">
            <div class="flex flex-col col-span-3">
                <label class="text-gray-600 font-bold" for="product">Select Product:</label>
                <select wire:model="product" name="product" id="product"
                class="bg-gray-200 p-3 mb-3 text-gray-900">
                    @if ($products->count() && $products != null)
                        <option value="" selected>--Select Product To add in Cart--</option>
                        @foreach ($products as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    @else
                        <option value="">No Product Exists</option>
                    @endif
                </select>
                @error('product')
                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                @enderror
            </div>
            <div class="flex flex-col col-span-1">
                <label class="text-gray-600 font-bold" for="quantity">Select Quantity:</label>
                <input type="number" wire:model="quantity" name="quantity" id="quantity" placeholder="Select Quantity"
                class="bg-gray-200 p-[10px] mb-3 text-gray-900">
                @error('quantity')
                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                @enderror
            </div>
            <button class="bg-blue-500 h-[43px] mt-6 text-white font-bold" wire:click="addProduct()">Add</button>
        </div>
        @if (count($productCart) > 0)
            <table class="w-full bg-white shadow-sm mb-3">
                <tr class="bg-gray-900 text-white rounded-t-lg">
                    <th class="py-2">Sr#</th>
                    <th class="py-2">Product_Name</th>
                    <th class="py-2">Quantity</th>
                    <th class="py-2">Price_Per_Unit</th>
                    <th class="py-2">Discount</th>
                    <th class="py-2">Active Stock</th>
                    <th class="py-2">Profit_Status</th>
                    <th class="py-2">Remove</th>
                </tr>

                @foreach ($productCart as $key => $item)
                    <tr class="text-center border-t border-t-gray-200 odd:bg-gray-200">
                        <td class="py-4">{{ $key + 1 }}</td>
                        <td class="py-4">{{ $item['name'] }}</td>
                        <td class="py-4">{{ $item['quantity'] }}</td>
                        <td class="py-4">{{ number_format(($item['price'] * $item['quantity']), 2)}}</td>
                        <td class="py-4">{{ $item['discount'].'%' }}</td>
                        <td class="py-4">{{ $item['stock_left'] }}
                            @if ($item['stock_left'] < $item['quantity'])
                                <span class="text-red-600 ml-2">(Stock is Not Available)</span>
                                <span class="hidden">{{ $outOfStock = 1 }}</span>
                            @endif
                        </td>
                        <td class="py-2">
                            @if ($item['profitStatus'] == 'Profit')
                                <span class="bg-blue-500 rounded-lg p-2 px-4">{{ $item['profitStatus'] }}</span>
                            @elseif(($item['profitStatus'] == 'Loss'))
                                <span class="bg-red-800 rounded-lg text-white p-2 px-4">{{ $item['profitStatus'] }}</span>
                            @endif
                        </td>
                        <td class="py-2"><button wire:click="removeProduct({{ $key }})"><i class="fas fa-times p-1 px-2 bg-red-500 text-white rounded-full"></i></button></td>
                    </tr>
                @endforeach
                </table>
            @endif
        @if ($togglePop == true)
            <div class="bg-gray-900 bg-opacity-90 fixed z-30 w-full h-screen left-0 top-0 flex justify-center items-center">
                <div class="bg-white rounded-lg p-10 w-4/12 flex flex-col relative">
                    <i class="fas fa-exclamation-circle text-6xl text-red-500 absolute -top-4 -left-5"></i>
                    <p class="text-center text-gray-600 p-3 text-xl">Are you sure that you want to place the order. You can not remove or update it in future. Make sure quantity and price is correct!</p>
                    <ul class="grid grid-cols-2 gap-3">
                        <button wire:click="togglePopMessage" class="text-white p-3 py-4 rounded-lg bg-red-500">Cancel</button>
                        <button type="submit" wire:click="saveData" class="text-white p-3 py-4 rounded-lg bg-blue-500">Confirm</button>
                    </ul>
                </div>
            </div>
        @endif
        <div class="flex justify-between">
            <div class="flex">
                @if ($outOfStock != 1)
                    <button wire:click="togglePopMessage" class="bg-green-600 mr-3 text-white font-bold rounded-lg px-4 py-3 block w-fit">Checkout</button>
                @endif
                @if (count($productCart) > 0)
                    <button wire:click="resetCart()" class="bg-red-600 text-white font-bold rounded-lg px-4 py-3 block w-fit">Reset</button>
                @endif
            </div>
            <h2 class="font-bold text-gray-600 text-3xl mt-3">Total Price: <span class="text-gray-500">{{ number_format($total_price, 2) }}</span></h2>
        </div>
    </div>
</div>