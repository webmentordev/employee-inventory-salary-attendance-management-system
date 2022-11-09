@section('title', 'Products Catagory | Employee Management')
<div>
    <h1 class="text-3xl mb-3 font-bold">Products Catagory</span></h1>
    @if (session('failed'))
        <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
    @elseif(session('success'))
        <p class="bg-green-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('success') }}</p>
    @endif
    <div class="bg-white rounded-lg p-3 mb-3">
        <form wire:submit.prevent="saveData" method="post" class="w-full odd:mr-3">
            <div class="grid grid-cols-4 w-full gap-3">
                <div class="col-span-3 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="name">Catagory Name:</label>
                    <input type="text" wire:model="name" name="name" id="name" placeholder="Catagory Name"
                    class="bg-gray-200 text-gray-800 p-3 rounded-lg 
                    @error('name')
                        mb-3
                    @enderror">
                    @error('name')
                        <p class="text-red-500 px-3">{{ $message }}</p>   
                    @enderror
                </div>
                <button type="submit" class="bg-green-600 mt-8 h-fit text-white font-bold rounded-lg px-4 py-3 block w-full">Add-Catagory</button>
            </div>
        </form>
    </div>

    <div class="bg-white p-3 rounded-lg">
        @if ($catagories != null)
            @if ($catagories->count())
            <table class="w-full bg-white rounded-lg shadow-sm">
                <tr>
                    <th class="px-2 py-4">Sr#</th>
                    <th class="px-2 py-4">Name</th>
                    <th class="px-2 py-4">No.OfProducts</th>
                    <th class="px-2 py-4">Created</th>
                    <th class="px-2 py-4">Updated</th>
                    <th class="px-2 py-4">Update</th>
                </tr>
        
                @foreach ($catagories as $key => $catagory)
                    <tr class="text-center border-t border-t-gray-200">
                        <td class="py-3">{{ $key + 1 }}</td>
                        <td class="py-3">{{ $catagory->name }}</td>
                        <td class="py-3"><span class="p-2 px-3 rounded-lg bg-green-700 text-white">{{ count($catagory->totalProducts) }}</span></td>
                        <td class="py-3">{{ $catagory->created_at->format('D, d, M Y H:i A') }} - {{ $catagory->created_at->diffForHumans() }}</td>
                        <td class="py-3">{{ $catagory->updated_at->format('D, d, M Y H:i A') }} - {{ $catagory->updated_at->diffForHumans() }}</td>
                        <td><button wire:click="toggleUpdate({{ $catagory->id }})" class="text-sm bg-indigo-500 p-2 rounded-md font-bold text-white"><i class="fas fa-edit mr-2"></i>Update</button></td>
                    </tr>
                @endforeach

                @if ($togglePop == true)
                    <div class="bg-gray-900 bg-opacity-90 fixed z-30 w-full h-screen left-0 top-0 flex justify-center items-center">
                        <div class="bg-white rounded-lg p-10 w-4/12">
                            <form method="post">
                                <input type="text" wire:model="updateCatagory" name="updateCatagory" id="updateCatagory" placeholder="Catagory Name"
                                class="p-3 w-full py-4 bg-gray-300 text-gray-800 mb-2 rounded-lg">
                                @error('updateCatagory')
                                    <p class="text-red-500 px-3">{{ $message }}</p>   
                                @enderror
                                <ul class="grid grid-cols-2 gap-3">
                                    <button wire:click="togglePopClose()" class="text-white p-3 py-4 rounded-lg bg-red-500">Cancel</button>
                                    <button wire:click="updateCatagory({{ $updateCatagory_id }})" class="text-white p-3 py-4 rounded-lg bg-blue-500">Confirm</button>
                                </ul>
                            </form>
                        </div>
                    </div>
                @endif
            </table>
            @else
                <p class="text-2xl">No Data available about Catagories!</p>
            @endif
        @else
            <p class="text-2xl">No Data available about Catagories!</p>
        @endif
    </div>
</div>