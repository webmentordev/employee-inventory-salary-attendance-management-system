<div>
    @if (session('success'))
        <p class="bg-green-600 text-white p-5 text-center">{{ session('success') }}</p>
    @elseif (session('failed'))
        <p class="bg-red-600 text-white p-5 text-center">{{ session('failed') }}</p>
    @endif
    <div>
        <h1 class="text-2xl mb-3 font-bold">Add User's Salary</h1>
        <form wire:submit.prevent='saveData' method="post">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="user_name" class="text-gray-600 text-sm">User Name</label>
                    <input id="user_name" class="mt-2 w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                    wire:model='user_name' list="users" name="user_name" placeholder="User Name" autocomplete="off">
                    <datalist id="users">
                        @foreach ($users as $user)
                            <option value="{{  $user->name  }}">
                        @endforeach
                    </datalist>
                    @error('user_name')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="salary" class="text-gray-600 text-sm">Salary</label>
                    <input id="salary" class="mt-2 w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                    type="number" wire:model='salary' list="users" name="salary" placeholder="Salary Per Month">
                    @error('salary')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-lg text-white font-bold">Submit</button>
        </form>
    </div>        
</div>
