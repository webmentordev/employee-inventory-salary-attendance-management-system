@section('title', 'Update Designation | Employee Management')
<div>
    <h1 class="text-4xl mb-3 font-bold">Update Designation</h1>
    @if (session('success'))
        <p class="bg-green-800 rounded-lg text-white py-4 px-5">{{ session('success') }}</p>
    @endif
    <form wire:submit.prevent='updateData({{ $designation[0]->id }})' method="post">
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="name" class="text-gray-600 text-sm">Designation Name</label>
                <input id="name" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                type="text" wire:model='name' name="name" placeholder="Designation Name">
                @error('name')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-lg text-white font-bold">Update</button>
    </form>
</div>