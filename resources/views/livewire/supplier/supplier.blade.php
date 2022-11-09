@section('title', 'Suppliers | Suppliers Management')
<div>
    <h1 class="text-4xl mb-3 font-bold">Suppliers Database</h1>
    @if (session('failed'))
        <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
    @elseif(session('success'))
        <p class="bg-green-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('success') }}</p>
    @endif
    <div class="bg-white rounded-lg p-3 mb-3">
        <form wire:submit.prevent="saveData" method="post" class="w-full odd:mr-3">
            <div class="grid grid-cols-5 w-full gap-3">
                <div class="col-span-1 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="name">Supplier Name:</label>
                    <input type="text" wire:model="name" name="name" id="name" autocomplete="off" placeholder="Supplier Name or Business Name"
                    class="bg-gray-200 text-gray-800 p-3 rounded-lg 
                    @error('name')
                        mb-3
                    @enderror">
                    @error('name')
                        <p class="text-red-500 px-3">{{ $message }}</p>   
                    @enderror
                </div>

                <div class="col-span-1 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="email">Supplier Email:</label>
                    <input type="email" wire:model="email" name="email" id="email" autocomplete="off" placeholder="Supplier Email Address"
                    class="bg-gray-200 text-gray-800 p-3 rounded-lg 
                    @error('email')
                        mb-3
                    @enderror">
                    @error('email')
                        <p class="text-red-500 px-3">{{ $message }}</p>   
                    @enderror
                </div>

                <div class="col-span-1 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="mobile_number">Contact Number:</label>
                    <input type="number" wire:model="mobile_number" name="mobile_number" id="mobile_number" autocomplete="off" placeholder="Mobile Number"
                    class="bg-gray-200 text-gray-800 p-3 rounded-lg 
                    @error('mobile_number')
                        mb-3
                    @enderror">
                    @error('mobile_number')
                        <p class="text-red-500 px-3">{{ $message }}</p>   
                    @enderror
                </div>

                <div class="col-span-1 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="c_address">Address:</label>
                    <input type="text" wire:model="c_address" name="c_address" id="c_address" autocomplete="off" placeholder="Address"
                    class="bg-gray-200 text-gray-800 p-3 rounded-lg 
                    @error('c_address')
                        mb-3
                    @enderror">
                    @error('c_address')
                        <p class="text-red-500 px-3">{{ $message }}</p>   
                    @enderror
                </div>

                <button type="submit" class="bg-green-600 mt-8 h-fit text-white font-bold rounded-lg px-4 py-3 block w-full">Submit</button>
            </div>
        </form>
    </div>
    <div class="bg-white p-3 rounded-lg">
        @if ($suppliers != null)
            @if ($suppliers->count())
            <table class="w-full bg-white rounded-lg shadow-sm">
                <tr>
                    <th class="px-2 py-4">Sr#</th>
                    <th class="px-2 py-4">Name</th>
                    <th class="px-2 py-4">No.OfStocks</th>
                    <th class="px-2 py-4">Contact_Number</th>
                    <th class="px-2 py-4">Email</th>
                    <th class="px-2 py-4">Address</th>
                    <th class="px-2 py-4">Created</th>
                    <th class="px-2 py-4">Updated</th>
                    <th class="px-2 py-4">Update</th>
                </tr>
        
                @foreach ($suppliers as $key => $supplier)
                    <tr class="text-center border-t border-t-gray-200">
                        <td class="py-4">{{ $key + 1 }}</td>
                        <td class="py-3">{{ $supplier->name }}</td>
                        <td class="py-3"><span class="p-2 px-3 rounded-lg bg-green-700 text-white">{{ count($supplier->stocks) }}</span></td>
                        <td class="py-3">0{{ $supplier->mobile_number }}</td> 
                        <td class="py-3">{{ $supplier->email }}</td>
                        <td class="py-3">{{ $supplier->address }}</td>                    
                        <td class="py-3">{{ $supplier->created_at->format('D, d, M Y H:i A') }}</td>
                        <td class="py-3">{{ $supplier->updated_at->format('D, d, M Y H:i A') }}</td>
                        <td><button wire:click="toggleUpdate({{ $supplier->id }})" class="text-sm bg-indigo-500 p-2 rounded-md font-bold text-white"><i class="fas fa-edit mr-2"></i>Update</button></td>
                    </tr>
                @endforeach

                @if ($togglePop == true)
                    <div class="bg-gray-900 bg-opacity-90 fixed z-30 w-full h-screen left-0 top-0 flex justify-center items-center">
                        <div class="bg-white rounded-lg p-10 w-4/12 flex flex-col">
                            <div class="flex flex-col mb-5">
                                <label class="text-gray-600 font-bold mb-2" for="updateName">Supplier Name:</label>
                                <input type="text" wire:model="updateName" name="updateName" id="updateName" autocomplete="off" placeholder="Supplier (Name or Business)"
                                class="bg-gray-200 text-gray-800 p-3 rounded-lg mb-2">
                                @error('updateName')
                                    <p class="text-red-500 px-3">{{ $message }}</p>   
                                @enderror
                            </div>
                            
                            <div class="flex flex-col mb-5">
                                <label class="text-gray-600 font-bold mb-2" for="updateEmail">Supplier Email:</label>
                                <input type="email" wire:model="updateEmail" name="updateEmail" id="updateEmail" autocomplete="off" placeholder="Supplier Email Address"
                                class="bg-gray-200 text-gray-800 p-3 rounded-lg mb-2">
                                @error('updateEmail')
                                    <p class="text-red-500 px-3">{{ $message }}</p>   
                                @enderror
                            </div>
                            
                            <div class="flex flex-col mb-5">
                                <label class="text-gray-600 font-bold mb-2" for="updateMobile">Contact Number:</label>
                                <input type="number" wire:model="updateMobile" name="updateMobile" id="updateMobile" autocomplete="off" placeholder="Mobile Number"
                                class="bg-gray-200 text-gray-800 p-3 rounded-lg mb-2">
                                @error('updateMobile')
                                    <p class="text-red-500 px-3">{{ $message }}</p>   
                                @enderror
                            </div>
                            
                            <div class="flex flex-col mb-5">
                                <label class="text-gray-600 font-bold mb-2" for="updateAddress">Address:</label>
                                <input type="text" wire:model="updateAddress" name="updateAddress" id="updateAddress" autocomplete="off" placeholder="Address"
                                class="bg-gray-200 text-gray-800 p-3 rounded-lg mb-2"> 
                                @error('updateAddress')
                                    <p class="text-red-500 px-3">{{ $message }}</p>   
                                @enderror
                            </div>

                            <ul class="grid grid-cols-2 gap-3">
                                <button wire:click="togglePopClose()" class="text-white p-3 py-4 rounded-lg bg-red-500">Cancel</button>
                                <button type="submit" wire:click="updateSupplier({{ $updateSupplier_id }})" class="text-white p-3 py-4 rounded-lg bg-blue-500">Confirm</button>
                            </ul>
                        </div>
                    </div>
                @endif
            </table>
            @else
                <p class="text-2xl">No Data available about Suppliers!</p>
            @endif
        @else
            <p class="text-2xl">No Data available about Suppliers!</p>
        @endif
    </div>
    
</div>