@section('title', 'Business | Business Management')
<div>
    <h1 class="text-4xl mb-3 font-bold">Business Database</h1>
    @if (session('failed'))
        <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
    @elseif(session('success'))
        <p class="bg-green-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('success') }}</p>
    @endif
    <div class="bg-white rounded-lg p-3 mb-3">
        <p class="text-gray-800 p-3 mb-3 bg-yellow-200 rounded-t-lg"><i class="fas fa-exclamation fa-fw py-3 px-5 mr-3 rounded-full border-2 border-gray-700"></i> Please register business type first then register new business.</p>
        <form wire:submit.prevent="saveData" method="post" class="w-full odd:mr-3">
            <div class="grid grid-cols-4 w-full gap-3">
                <div class="col-span-1 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="name">Business Name:</label>
                    <input type="text" wire:model="name" name="name" id="name" autocomplete="off" placeholder="Business Name"
                    class="bg-gray-200 text-gray-800 p-3 rounded-lg 
                    @error('name')
                        mb-3
                    @enderror">
                    @error('name')
                        <p class="text-red-500 px-3">{{ $message }}</p>   
                    @enderror
                </div>

                <div class="col-span-1 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="type">Business Type:</label>
                    <select wire:model="type" name="type" id="type"
                    class="bg-gray-200 text-gray-800 p-3 py-4 mb-5 rounded-lg">
                        @if ($businessTypes->count() && $businessTypes != null)
                            <option value="" selected>--Select Business Type--</option>
                            @foreach ($businessTypes as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        @else
                            <option value="" selected>--Please add new Business Type first--</option>
                        @endif
                    </select>
                    @error('type')
                        <p class="mb-3 text-red-500">{{ $message }}</p>   
                    @enderror
                </div>
                

                <div class="col-span-1 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="discount">Discount (Optional):</label>
                    <input type="text" wire:model="discount" name="discount" id="discount" autocomplete="off" placeholder="Discount (Optional)"
                    class="bg-gray-200 text-gray-800 p-3 rounded-lg 
                    @error('discount')
                        mb-3
                    @enderror">
                    @error('discount')
                        <p class="text-red-500 px-3">{{ $message }}</p>   
                    @enderror
                </div>
                <button type="submit" class="bg-green-600 mt-8 h-fit text-white font-bold rounded-lg px-4 py-3 block w-full">Submit</button>
            </div>
        </form>
    </div>
    <div class="bg-white p-3 rounded-lg">
        @if ($businesses != null)
            @if ($businesses->count())
            <table class="w-full bg-white rounded-lg shadow-sm">
                <tr>
                    <th class="px-2 py-4">Sr#</th>
                    <th class="px-2 py-4">Name</th>
                    <th class="px-2 py-4">CustomerName</th>
                    <th class="px-2 py-4">BusinessType</th>
                    <th class="px-2 py-4">Discount</th>
                    <th class="px-2 py-4">Created</th>
                    <th class="px-2 py-4">Updated</th>
                    <th class="px-2 py-4">Update</th>
                </tr>
        
                @foreach ($businesses as $key => $business)
                    <tr class="text-center border-t border-t-gray-200">
                        <td class="py-4">{{ $key + 1 }}</td>
                        <td class="py-3">{{ $business->name }}</td>
                        <td class="py-3">
                        @if ($business->registeredCustomer != null)
                            {{ $business->registeredCustomer->first_name }} {{ $business->registeredCustomer->last_name }}
                        @else
                            <span class="p-2 px-4 rounded-lg bg-green-600 text-white">Not Registered</span>
                        @endif</td>
                        <td class="py-3">{{ $business->type->name }}</td>
                        <td class="py-3">
                        @if ($business->default_discount != 0)
                            <span class="bg-blue-500 text-white p-1 px-2 rounded-lg">{{ $business->default_discount }} %</span>
                        @else
                            <span class="bg-red-500 text-white p-1 px-2 rounded-lg">No-Discount</span>
                        @endif</td>
                        <td class="py-3">{{ $business->created_at->diffForHumans() }}</td>
                        <td class="py-3">{{ $business->updated_at->diffForHumans() }}</td>
                        <td><button wire:click="toggleUpdate({{ $business->id }})" class="text-sm bg-indigo-500 p-2 rounded-md font-bold text-white"><i class="fas fa-edit mr-2"></i>Update</button></td>
                    </tr>
                @endforeach
            </table>
            @if ($togglePop == true)
                <div class="bg-gray-900 bg-opacity-90 fixed z-30 w-full h-screen left-0 top-0 flex justify-center items-center">
                    <div class="bg-white rounded-lg p-10 w-4/12">
                        
                        <div class="flex flex-col">
                            <label class="text-gray-600 font-bold mb-2" for="updateName">Business Name:</label>
                            <input type="text" wire:model="updateName" name="updateName" id="updateName" placeholder="Business Name"
                            class="p-3 w-full py-4 bg-gray-300 text-gray-800 mb-2 rounded-lg">
                            @error('updateName')
                                <p class="text-red-500 px-3">{{ $message }}</p>   
                            @enderror
                        </div>

                        <div class="flex flex-col">
                            <label class="text-gray-600 font-bold mb-2" for="updateType">Business Type:</label>
                            <select wire:model="updateType" name="updateType" id="updateType"
                            class="bg-gray-200 text-gray-800 p-3 py-4 mb-5 rounded-lg">
                                @if ($businessTypes->count() && $businessTypes != null)
                                    <option value="" selected>--Select Business Type--</option>
                                    @foreach ($businessTypes as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @else
                                    <option value="" selected>--Please add new Business Type first--</option>
                                @endif
                            </select>
                            @error('updateType')
                                <p class="mb-3 text-red-500">{{ $message }}</p>   
                            @enderror
                        </div>

                        <div class="flex flex-col">
                            <label class="text-gray-600 font-bold mb-2" for="updateDiscount">Discount:</label>
                            <input type="number" wire:model="updateDiscount" name="updateDiscount" id="updateDiscount" placeholder="Discount (Optional)"
                            class="p-3 w-full py-4 bg-gray-300 text-gray-800 mb-2 rounded-lg">
                            @error('updateDiscount')
                                <p class="text-red-500 px-3">{{ $message }}</p>   
                            @enderror
                        </div>

                        <ul class="grid grid-cols-2 gap-3">
                            <button wire:click="togglePopClose()" class="text-white p-3 py-4 rounded-lg bg-red-500">Cancel</button>
                            <button wire:click="updateBusiness({{ $updateBusiness_id }})" class="text-white p-3 py-4 rounded-lg bg-blue-500">Confirm</button>
                        </ul>
                    </div>
                </div>
            @endif
            @else
                <p class="text-2xl">No Data available about Business!</p>
            @endif
        @else
            <p class="text-2xl">No Data available about Business!</p>
        @endif
    </div>
</div>