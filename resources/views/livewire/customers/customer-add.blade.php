@section('title', 'Add Customers | Customer Management')
<div>
    <h1 class="text-3xl mb-3 font-bold">Customer Add</span></h1>
    <div class="bg-white rounded-lg p-3 w-full">
        <p class="text-gray-800 p-3 mb-3 bg-yellow-200 rounded-t-lg"><i class="fas fa-exclamation fa-fw py-3 px-5 mr-3 rounded-full border-2 border-gray-700"></i> Please register business first then add new customer so you can register it.</p>
        @if (session('failed'))
            <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
        @elseif(session('success'))
            <p class="bg-green-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('success') }}</p>
        @endif
        <form wire:submit.prevent="saveData" method="post" class="w-full odd:mr-3">
            <div class="flex flex-col">
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-gray-600 font-bold" for="first_name">First Name:</label>
                        <input type="text" wire:model="first_name" name="first_name" id="first_name" placeholder="First Name"
                        class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                        @error('first_name')
                            <p class="mb-3 text-red-500">{{ $message }}</p>   
                        @enderror
                    </div>

                    <div class="flex flex-col">
                        <label class="text-gray-600 font-bold" for="last_name">Last Name:</label>
                        <input type="text" wire:model="last_name" name="last_name" id="last_name" placeholder="Last Name"
                        class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                        @error('last_name')
                            <p class="mb-3 text-red-500">{{ $message }}</p>   
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-gray-600 font-bold" for="email">Customer Email:</label>
                        <input type="email" wire:model="email" name="email" id="email" placeholder="Email Address"
                        class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                        @error('email')
                            <p class="mb-3 text-red-500">{{ $message }}</p>   
                        @enderror
                    </div>

                    <div class="flex flex-col">
                        <label class="text-gray-600 font-bold" for="mobile_number">Mobile Number:</label>
                        <input type="number" wire:model="mobile_number" name="mobile_number" id="mobile_number" placeholder="Mobile Number"
                        class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                        @error('mobile_number')
                            <p class="mb-3 text-red-500">{{ $message }}</p>   
                        @enderror
                    </div>
                </div>

                
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-gray-600 font-bold" for="city">Customer City:</label>
                        <input type="text" wire:model="city" name="city" id="city" placeholder="Customer City"
                        class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                        @error('city')
                            <p class="mb-3 text-red-500">{{ $message }}</p>   
                        @enderror
                    </div>

                    <div class="flex flex-col">
                        <label class="text-gray-600 font-bold" for="country">Customer Country:</label>
                        <input type="text" wire:model="country" name="country" id="country" placeholder="Customer Country"
                        class="bg-gray-200 text-gray-800 p-3 mb-5" autocomplete="off">
                        @error('country')
                            <p class="mb-3 text-red-500">{{ $message }}</p>   
                        @enderror
                    </div>
                </div>

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
                class="bg-gray-200 text-gray-800 p-3 mb-5" cols="30" rows="4"></textarea>
                @error('c_address')
                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                @enderror
            </div>
            <div class="flex justify-between">
                <button type="submit" class="bg-green-600 text-white font-bold rounded-lg px-4 py-3 block w-fit">Upload</button>
                <a href="/customers" class="bg-blue-500 text-white rounded-lg px-4 py-3 block w-fit">Show Customers</a>
            </div>
        </form>
    </div>
</div>
