@section('title', 'Designations | Employee Management')
<div>
    @if ($update == true)
        <button class="py-2 font-bold mb-2 text-white px-5 rounded-lg bg-blue-500 mr-3" wire:click='addData'>Add</button>
        <button class="py-2 font-bold mb-2 text-white px-5 rounded-lg bg-green-700" wire:click='showData'>Show</button>
        @livewire('designation-update')
    @elseif($show == true)
        <button class="py-2 font-bold mb-2 text-white px-5 rounded-lg bg-blue-700 mr-3" wire:click='addData'>Add</button>
        <div class="mb-4">
            <h1 class="text-4xl mb-3 font-bold">Designations Database</h1>
            @if ($designations->count())
                <table class="w-full bg-white rounded-lg shadow-sm">
                    <tr>
                        <th class="px-2 py-4">Sr #</th>
                        <th class="px-2 py-4">Name</th>
                        <th class="px-2 py-4">Users</th>
                        <th class="px-2 py-4">Created</th>
                        <th class="px-2 py-4">Updated</th>
                        <th class="px-2 py-4">Update</th>
                    </tr>
                    @foreach ($designations as $key => $designation)
                        <tr class="text-center border-t border-t-gray-200">
                            <td class="py-3">{{ $key + 1 }}</td>
                            <td class="py-3">{{ $designation->name }}</td>
                            <td class="py-3">{{ count($designation->users) }}</td>
                            <td class="py-3">{{ $designation->created_at->diffForHumans() }}</td>
                            <td class="py-3">{{ $designation->updated_at->diffForHumans() }}</td>
                            <td class="py-3"><a href="/update-designation/{{ $designation->id }}"class="text-sm bg-indigo-500 p-2 rounded-md font-bold text-white"><i class="fas fa-edit mr-2"></i>Update</a></td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="py-6 p-3 rounded-lg text-white bg-gray-600 mb-3">Designation Database is empty. You can add by click add above.</p>  
            @endif
        </div>

        @elseif($add == true)
        <h1 class="text-4xl mb-3 font-bold">Add Designation</h1>
        @if (session('success'))
            <p class="bg-green-800 rounded-lg text-white px-2 py-5">{{ session('success') }}</p>
        @endif
        <div>
            
            <form wire:submit.prevent='saveData' method="post">
                <div class="grid grid-cols-4 gap-3">
                    <div>
                        <label for="name" class="text-gray-600 text-sm">Designation Name</label>
                        <input id="name" class="mt-2 w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                        type="text" wire:model='name' name="name" placeholder="Designation Name">
                        @error('name')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-lg text-white font-bold">Add</button>
            </form>
        </div>        
    @endif
</div>
