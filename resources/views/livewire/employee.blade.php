@section('title', 'Employee | Employee Management')
<div>
    @if ($update == true)
        <button class="py-2 font-bold mb-2 text-white px-5 rounded-lg bg-indigo-700 mr-3" wire:click='addUser'>Add</button>
        <button class="py-2 font-bold mb-2 text-white px-5 rounded-lg bg-indigo-700" wire:click='showUsers'>Users</button>
        @livewire('update-user-form')
    @elseif($show == true)
        <button class="py-2 font-bold mb-2 text-white px-5 rounded-lg bg-indigo-700 mr-3" wire:click='addUser'>Add</button>
        <div>
            <h1 class="text-4xl mb-3 font-bold">Users Database</h1>
            @if ($users[0]->designation != null)
                <table class="w-full bg-white rounded-lg shadow-sm">
                    <tr>
                        <th class="px-2 py-4 ml-3">Image</th>
                        <th class="px-2 py-4">Name</th>
                        <th class="px-2 py-4">Email</th>
                        <th class="px-2 py-4">Designation</th>
                        <th class="px-2 py-4">Role</th>
                        <th class="px-2 py-4">Phone</th>
                        <th class="px-2 py-4">WorkHour</th>
                        <th class="px-2 py-4">Created</th>
                        <th class="px-2 py-4">Updated</th>
                        <th class="px-2 py-4">Status</th>
                        <th class="px-2 py-4">Update</th>
                    </tr>
                    @foreach ($users as $user)
                        <tr class="text-center border-t border-t-gray-200">
                            <td class="py-3"><div style="background-image:url({{ asset('storage/'.$user->image) }}); width:50px; height:50px; border-radius: 100%" class="bg-cover bg-center m-auto"></div></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->designation->name }}</td>
                            <td>{{ $user->role->name }}</td>
                            <td>0{{ $user->phone_number }}</td>
                            <td>{{ $user->work_hours }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                            <td>{{ $user->updated_at->diffForHumans() }}</td>
                            <td class="capatalize"> @if ($user->status == 'active')
                                <i class="fas fa-check text-white text-sm bg-green-600 p-stat rounded-full"></i>
                            @else
                                <i class="fas fa-times text-white text-sm bg-red-500 p-stat px-left rounded-full"></i>
                            @endif </td>
                            <td><a href="/update/{{ $user->id }}"class="text-sm bg-indigo-500 p-2 rounded-md font-bold text-white warp-none"><i class="fas fa-edit mr-2"></i>Update</a></td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="py-6 p-3 rounded-lg text-white bg-gray-600 mb-3">Please Insert Designations & Roles to insert Employee data.</p>     
            @endif
            {{-- {{ $users->links() }} --}}
        </div>
    @elseif($create == true)
        <button class="py-2 font-bold mb-2 text-white px-5 rounded-lg bg-indigo-700" wire:click='showUsers'>Users</button>
        @livewire('user-form')
    @endif
</div>