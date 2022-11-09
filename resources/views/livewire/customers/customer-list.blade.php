@section('title', 'Customers | Customer Management')
<div>
    <h1 class="text-3xl mb-3 font-bold">Customers List</span></h1>
    @if (session('failed'))
        <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
    @elseif(session('success'))
        <p class="bg-green-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('success') }}</p>
    @endif
    <div class="bg-white p-3 rounded-lg">
        @if ($customers != null)
            @if ($customers->count())
            <table class="w-full bg-white rounded-lg shadow-sm">
                <tr>
                    <th class="px-2 py-4">Sr#</th>
                    <th class="px-2 py-4">FullName</th>
                    <th class="px-2 py-4">Email</th>
                    <th class="px-2 py-4">Number</th>
                    <th class="px-2 py-4">Business</th>
                    <th class="px-2 py-4">City</th>
                    <th class="px-2 py-4">Country</th>
                    <th class="px-2 py-4">Address</th>
                    <th class="px-2 py-4">Created</th>
                    <th class="px-2 py-4">Updated</th>
                    <th class="px-2 py-4">Update</th>
                </tr>
        
                @foreach ($customers as $key => $customer)
                    <tr class="text-center border-t border-t-gray-200 odd:bg-gray-200">
                        <td class="py-3">{{ $key + 1 }}</td>
                        <td class="py-3">{{ $customer->first_name }} {{ $customer->last_name }}</td>
                        <td class="py-3">{{ $customer->email }}</td>
                        <td class="py-3">0{{ $customer->mobile_number }}</td>
                        <td class="py-3">{{ $customer->registeredBusiness->name }}</td>
                        <td class="py-3">{{ $customer->city }}</td>
                        <td class="py-3">{{ $customer->country }}</td>
                        <td class="py-3">{{ $customer->address }}</td>
                        <td class="py-3">{{ $customer->created_at->format('d, M Y H:i A') }}</td>
                        <td class="py-3">{{ $customer->updated_at->format('d, M Y H:i A')  }}</td>
                        <td><button wire:click="toggleUpdate({{ $customer->id }})" class="text-sm bg-indigo-500 p-2 rounded-md font-bold text-white"><i class="fas fa-edit mr-2"></i>Update</button></td>
                    </tr>
                @endforeach

                @if ($togglePop == true)
                <div class="bg-gray-900 bg-opacity-90 fixed z-30 w-full h-screen left-0 top-0 flex justify-center items-center">
                    <div class="bg-white rounded-lg p-10 w-4/12 flex flex-col">
                            <form method="post">
                                <label class="text-gray-600 font-bold" for="first_name">First Name:</label>
                                <input type="text" wire:model="first_name" name="first_name" id="first_name" placeholder="First Name"
                                class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                                @error('first_name')
                                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                                @enderror
                            
                                <label class="text-gray-600 font-bold" for="last_name">Last Name:</label>
                                <input type="text" wire:model="last_name" name="last_name" id="last_name" placeholder="Last Name"
                                class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                                @error('last_name')
                                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                                @enderror
                                            
                                <label class="text-gray-600 font-bold" for="email">Customer Email:</label>
                                <input type="email" wire:model="email" name="email" id="email" placeholder="Email Address"
                                class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                                @error('email')
                                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                                @enderror
                            
                                <label class="text-gray-600 font-bold" for="mobile_number">Mobile Number:</label>
                                <input type="number" wire:model="mobile_number" name="mobile_number" id="mobile_number" placeholder="Mobile Number"
                                class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                                @error('mobile_number')
                                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                                @enderror
                            
                                <label class="text-gray-600 font-bold" for="city">Customer City:</label>
                                <input type="text" wire:model="city" name="city" id="city" placeholder="Customer City"
                                class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                                @error('city')
                                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                                @enderror
                                             
                                <label class="text-gray-600 font-bold" for="country">Customer Country:</label>
                                <input type="text" wire:model="country" name="country" id="country" placeholder="Customer Country"
                                class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                                @error('country')
                                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                                @enderror
                                
                                <label class="text-gray-600 font-bold" for="business">Register Business</label>
                                <select wire:model="business" name="business" id="business"
                                class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                                    @if ($businesses->count() && $businesses != null)
                                        <option value="" selected>--Select Business--</option>
                                        @foreach ($businesses as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="" selected>--Please add new Business First--</option>
                                    @endif
                                </select>
                                @error('business')
                                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                                @enderror
                
                                <label class="text-gray-600 font-bold" for="c_address">Customer Address:</label>
                                <textarea wire:model="c_address" name="c_address" id="c_address" placeholder="Address"
                                class="bg-gray-200 text-gray-800 p-3 mb-5" cols="30" rows="4">{{ $c_address }}</textarea>
                                @error('c_address')
                                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                                @enderror
                            </form>
                        <ul class="grid grid-cols-2 gap-3">
                            <button wire:click="togglePopClose()" class="text-white p-3 py-4 rounded-lg bg-red-500">Cancel</button>
                            <button type="submit" wire:click="updateCustomer({{ $updateCustomer_id }})" class="text-white p-3 py-4 rounded-lg bg-blue-500">Confirm</button>
                        </ul>
                    </div>
                </div>
            @endif
            </table>
            @else
                <p class="text-2xl">No Data available about Customers!</p>
            @endif
        @else
            <p class="text-2xl">No Data available about Customers!</p>
        @endif
    </div>
</div>
