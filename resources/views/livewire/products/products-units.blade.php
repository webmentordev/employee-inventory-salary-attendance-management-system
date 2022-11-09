@section('title', 'Products Units | Employee Management')
<div>
    <h1 class="text-3xl mb-3 font-bold">Products Units</span></h1>
    @if (session('failed'))
        <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
    @elseif(session('success'))
        <p class="bg-green-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('success') }}</p>
    @endif
    <div class="bg-white rounded-lg p-3 mb-3">
        <form wire:submit.prevent="saveData" method="post" class="w-full odd:mr-3">
            <div class="grid grid-cols-4 w-full gap-3">
                <div class="col-span-3 flex flex-col">
                    <label class="text-gray-600 font-bold mb-2" for="name">Unit Name:</label>
                    <input type="text" wire:model="name" name="name" id="name" placeholder="Unit Name (KG, GRAM etc)"
                    class="bg-gray-200 text-gray-800 p-3 rounded-lg 
                    @error('name')
                        mb-3
                    @enderror">
                    @error('name')
                        <p class="text-red-500 px-3">{{ $message }}</p>   
                    @enderror
                </div>
                <button type="submit" class="bg-green-600 mt-8 h-fit text-white font-bold rounded-lg px-4 py-3 block w-full">Add-Unit</button>
            </div>
        </form>
    </div>

    <div class="bg-white p-3 rounded-lg">
        @if ($units != null)
            @if ($units->count())
            <table class="w-full bg-white rounded-lg shadow-sm">
                <tr>
                    <th class="px-2 py-4">Sr#</th>
                    <th class="px-2 py-4">Name</th>
                    <th class="px-2 py-4">Subunits#</th>
                    <th class="px-2 py-4">Created</th>
                    <th class="px-2 py-4">Updated</th>
                    <th class="px-2 py-4">Update</th>
                </tr>
        
                @foreach ($units as $key => $unit)
                    <tr class="text-center border-t border-t-gray-200">
                        <td class="py-3">{{ $key + 1 }}</td>
                        <td class="py-3">{{ $unit->name }}</td>
                        <td class="py-3">{{ $unit->subunits->count() }}</td>
                        <td class="py-3">{{ $unit->created_at->format('D, d, M Y H:i A') }} - {{ $unit->created_at->diffForHumans() }}</td>
                        <td class="py-3">{{ $unit->updated_at->format('D, d, M Y H:i A') }} - {{ $unit->updated_at->diffForHumans() }}</td>
                        <td><button wire:click="toggleUpdate({{ $unit->id }})" class="text-sm bg-indigo-500 p-2 rounded-md font-bold text-white"><i class="fas fa-edit mr-2"></i>Update</button></td>
                    </tr>
                @endforeach

                @if ($togglePop == true)
                    <div class="bg-gray-900 bg-opacity-90 fixed z-30 w-full h-screen left-0 top-0 flex justify-center items-center">
                        <div class="bg-white rounded-lg p-10 w-4/12">
                            <form method="post">
                                <input type="text" wire:model="updateUnit" name="updateUnit" id="updateUnit" placeholder="Unit Name"
                                class="p-3 w-full py-4 bg-gray-300 text-gray-800 mb-2 rounded-lg">
                                @error('updateUnit')
                                    <p class="text-red-500 px-3">{{ $message }}</p>   
                                @enderror
                                <ul class="grid grid-cols-2 gap-3">
                                    <button wire:click="togglePopClose()" class="text-white p-3 py-4 rounded-lg bg-red-500">Cancel</button>
                                    <button wire:click="updateUnit({{ $updateUnit_id }})" class="text-white p-3 py-4 rounded-lg bg-blue-500">Confirm</button>
                                </ul>
                            </form>
                        </div>
                    </div>
                @endif
            </table>
            @else
                <p class="text-2xl">No Data available about Units!</p>
            @endif
        @else
            <p class="text-2xl">No Data available about Units!</p>
        @endif
    </div>
</div>
