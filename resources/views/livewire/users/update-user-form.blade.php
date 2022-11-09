@section('title', 'Employee | Employee Management')
<div>
    <h1 class="text-4xl mb-3">Update User</h1>
    @if (session('success'))
        <p class="bg-green-600 text-white p-5 text-center">{{ session('success') }}</p>
    @endif
    <form wire:submit.prevent='updateData({{ $user[0]->id }})' method="post">
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="name" class="text-gray-600 text-sm">Fullname</label>
                <input id="name" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                type="text" wire:model='name' name="name" placeholder="Name">
                @error('name')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="text-gray-600 text-sm">Email Address</label>
                <input id="email" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                type="email" wire:model='email' name="email" placeholder="Email">
                @error('email')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="text-gray-600 text-sm">Password</label>
                <input id="password" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                type="password" wire:model='password' name="password" placeholder="Password">
                @error('password')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role_id" class="text-gray-600 text-sm">Role</label>
                <select id="role_id" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-select px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                type="text" wire:model='role_id' name="role_id">
                    <option value="" selected>---please select a role----</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}"><span class="capitalize">{{ $role->name }}</span></option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="designation_id" class="text-gray-600 text-sm">Designation</label>
                <select id="designation_id" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-select px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                type="text" wire:model='designation_id' name="designation_id">
                    <option value="" selected>---please select designation----</option>
                    @foreach ($designations as $designation)
                        <option value="{{ $designation->id }}"><span class="capitalize">{{ $designation->name }}</span></option>
                    @endforeach
                </select>
                @error('designation_id')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="text-gray-600 text-sm">Upload Image</label>
                <div class="flex">
                    <input id="image" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-600 mr-3 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                    type="file" wire:model='image' name="image" accept=".jpg, .png, .jpeg">
                    <div style="background-image:url({{ asset('storage/'.$user[0]->image) }}); width:55px; height:50px; border-radius: 100%" class="bg-cover bg-center -mt-2"></div>
                </div>
                
                @error('image')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone_number" class="text-gray-600 text-sm">Phone Number</label>
                <input id="phone_number" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                type="number" wire:model='phone_number' name="phone_number" placeholder="Phone Number">
                @error('phone_number')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="work_hours" class="text-gray-600">Work Hours</label>
                <input id="work_hours" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                type="number" wire:model='work_hours' name="work_hours" placeholder="Work Hours">
                @error('work_hours')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-2">
                <label for="status" class="text-gray-600 text-sm">Status</label>
                <select id="status" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-select px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                type="text" wire:model='status' name="status">
                    <option value="active" selected><span>Active</span></option>
                    <option value="inactive"><span>Inactive</span></option>
                </select>
                @error('status')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-2">
                <label for="address" class="text-gray-600">Address</label>
                <textarea id="address" class="w-full resize-y bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" 
                wire:model='address' name="address" placeholder="Address" id="" cols="30" rows="4"></textarea>
                @error('address')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-lg text-white font-bold">Update</button>
    </form>
</div>