@section('title', 'Orders Database | Orders Management')
<div>
    <h1 class="text-3xl mb-3 font-bold">Orders List</h1>
    <div class="bg-white p-3 rounded-lg">
        @if (session('failed'))
            <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
        @elseif(session('success'))
            <p class="bg-green-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('success') }}</p>
        @endif
        <select wire:model="status" name="status" id="status" class="bg-gray-300 p-3 w-full rounded-lg focus:no-underline">
            <option value="" selected>---Select All---</option>
            <option value="Pending">Pending</option>
            <option value="Transporting">Transporting</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
        </select>
        @if ($orders != null)
            @if ($orders->count())
            <table class="w-full bg-white rounded-lg shadow-sm">
                <tr>
                    <th class="px-2 py-4">Sr#</th>
                    <th class="px-2 py-4">Name</th>
                    <th class="px-2 py-4">Customer Type</th>
                    <th class="px-2 py-4">Product</th>
                    <th class="px-2 py-4">Quantity</th>
                    <th class="px-2 py-4">Total_Price</th>
                    <th class="px-2 py-4">Status</th>
                    <th class="px-2 py-4">Invoice</th>
                    <th class="px-2 py-4">Discount</th>
                    <th class="px-2 py-4">Order Placed</th>
                    <th class="px-2 py-4">Status Updated</th>
                    <th class="px-2 py-4">Update</th>
                </tr>
                @foreach ($orders as $key => $order)
                    <tr class="text-center border-t border-t-gray-200 odd:bg-gray-200">
                        <td class="py-3">{{ $key + 1 }}</td>
                        <td class="py-3">{{ $order->customer_name }}</td>
                        <td class="py-3">{{ $order->customer_type }}</td>
                        <td class="py-3">{{ $order->product->name }}</td>
                        <td class="py-3">{{ $order->quantity }}</td>
                        <td class="py-3">{{ number_format($order->total_price, 2) }}</td>
                        <td class="py-3">
                            @if ($order->status == 'Pending')
                                <span class="p-1 px-2 rounded-lg bg-yellow-400 text-black">{{ $order->status }}</span>
                            @elseif($order->status == 'Completed')
                                <span class="text-sm bg-green-600 p-2 rounded-md font-bold text-white">{{ $order->status }}</span>
                            @elseif($order->status == 'Transporting')
                                <span class="p-1 px-2 rounded-lg bg-blue-600 text-white">{{ $order->status }}</span>
                            @elseif($order->status == 'Cancelled')
                                <span class="p-1 px-2 rounded-lg bg-red-600 text-white">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td class="py-3">
                            @if ($order->invoice != null)
                                @if($order->invoice->status == 'paid')
                                    <span class="p-1 px-2 rounded-lg bg-green-800 text-white">Paid</span>
                                @else
                                    <span class="p-1 px-2 rounded-lg bg-red-400 text-black">Unpaid</span>
                                @endif
                            @else
                                <span class="p-1 px-2 rounded-lg bg-red-400 text-black">Unpaid</span>
                            @endif
                        </td>
                        <td class="py-3">
                            @if ($order->discount > 0)
                                <span class="bg-blue-500 p-2 rounded-full text-white">{{ $order->discount.'%' }}</span>
                            @else
                                <span class="bg-red-500 p-2 rounded-full text-white">0%</span>
                            @endif
                        </td>
                        <td class="py-3">{{ $order->created_at->format('d, M Y H:i A') }}</td>
                        <td class="py-3">{{ $order->updated_at->format('d, M Y H:i A') }}</td>
                        <td>
                            @if ($order->status != 'Completed')
                                <button wire:click="toggleUpdate({{ $order->id }})" class="text-sm bg-indigo-500 p-2 rounded-md font-bold text-white"><i class="fas fa-edit mr-2"></i>Update</button>
                            @else
                                <span class="text-sm bg-green-600 p-2 rounded-md font-bold text-white">Completed</span>
                            @endif
                        </td>
                        {{-- <td><button class="rounded-full bg-black text-white p-1" wire:click="addToInvoice({{ $order->quantity }})">Pay</button></td> --}}
                    </tr>
                @endforeach
                @if ($togglePop == true)
                <div class="bg-gray-900 bg-opacity-90 fixed z-30 w-full h-screen left-0 top-0 flex justify-center items-center">
                    <div class="bg-white rounded-lg p-10 w-4/12 flex flex-col">
                        @if (session('failed-order'))
                            <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{!! session('failed-order') !!}</p>
                        @endif
                        <form method="post">
                            <label class="text-gray-600 font-bold" for="customer_name">Customer Name:</label>
                            <input type="text" wire:model="customer_name" name="customer_name" id="customer_name" placeholder="Customer Name"
                            class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                            @error('customer_name')
                                <p class="mb-3 text-red-500">{{ $message }}</p>   
                            @enderror
                        
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

                            <label class="text-gray-600 font-bold" for="product">Products</label>
                            <select wire:model="product" name="product" id="product"
                            class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                                @if ($products->count() && $products != null)
                                    <option value="" selected>--Select Product--</option>
                                    @foreach ($products as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @else
                                    <option value="" selected>--Please add new Product First--</option>
                                @endif
                            </select>
                            @error('product')
                                <p class="mb-3 text-red-500">{{ $message }}</p>   
                            @enderror

                            <label class="text-gray-600 font-bold" for="updateStatus">Status:</label>
                            <select wire:model="updateStatus" name="updateStatus" id="updateStatus"
                            class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                                <option value="Pending">Pending</option>
                                <option value="Transporting">Transporting</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                            @error('updateStatus')
                                <p class="mb-3 text-red-500">{{ $message }}</p>   
                            @enderror

                            {{-- <label class="text-gray-600 font-bold" for="updateDiscount">Discount:</label>
                            <input type="number" wire:model="updateDiscount" name="updateDiscount" id="updateDiscount" placeholder="Discount"
                            class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                            @error('updateDiscount')
                                <p class="mb-3 text-red-500">{{ $message }}</p>   
                            @enderror --}}

                            <label class="text-gray-600 font-bold" for="quantity">Quantity:</label>
                            <input type="number" wire:model="quantity" name="quantity" id="quantity" placeholder="Customer Name"
                            class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                            @error('quantity')
                                <p class="mb-3 text-red-500">{{ $message }}</p>   
                            @enderror

                            <p class="text-gray-500 text-2xl mb-3"><span class="text-gray-800 font-bold">Total Price:</span> {{ number_format($total_price, 2) }}</p>

                            <ul class="grid grid-cols-2 gap-3">
                                <button wire:click="togglePopClose" class="text-white p-3 py-4 rounded-lg bg-red-500">Cancel</button>
                                <button type="submit" wire:click="updateOrder({{ $updateOrder_id }})" class="text-white p-3 py-4 rounded-lg bg-blue-500">Confirm</button>
                            </ul>
                        </form>
                    </div>
                </div>
            @endif
            </table>
            @else
                <p class="text-2xl py-3">No Data available about {{ $status }} Orders!</p>
            @endif
        @else
            <p class="text-2xl py-3">No Data available about Orders!</p>
        @endif
    </div>
</div>