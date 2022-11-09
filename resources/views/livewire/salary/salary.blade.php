@section('title', 'Salary | Employee Management')
<div>
    @if ($update == true)
        <button class="py-2 font-bold mb-2 text-white px-5 rounded-lg bg-indigo-700 mr-3" wire:click='addUser'>Add</button>
        <button class="py-2 font-bold mb-2 text-white px-5 rounded-lg bg-indigo-700" wire:click='showUsers'>Users</button>
        @livewire('salary-update')
    @elseif($show == true)
        <button class="py-2 font-bold mb-2 text-white px-5 rounded-lg bg-indigo-700 mr-3" wire:click='addUser'>Add</button>
        <div>
            <h1 class="text-4xl mb-3 font-bold">Employees Salary Database</h1>
            @if ($users->count())
            <table class="w-full bg-white rounded-lg shadow-sm">
                <tr>
                    <th class="px-2 py-4">Name</th>
                    <th class="px-2 py-4">Salary <span class="text-[12px] text-gray-500">/30-Days</span></th>
                    <th class="px-2 py-4">Salary <span class="text-[12px] text-gray-500">/day</span></th>
                    <th class="px-2 py-4">WorkHours <span class="text-[12px] text-gray-500">/hour</span></th>
                    <th class="px-2 py-4">Role</th>
                    <th class="px-2 py-4">Designation</th>
                    <th class="px-2 py-4">Created</th>
                    <th class="px-2 py-4">Updated</th>
                    <th class="px-2 py-4">Update</th>
                </tr>
        
                @foreach ($users as $user)
                    <tr class="text-center border-t border-t-gray-200">
                        <td class="py-3">{{ $user->user->name }}</td>
                        <td class="py-3">{{ number_format($user->salary, 2) }}</td>
                        <td class="py-3">{{ number_format($user->salary / 30) }}</td>
                        <td class="py-3">{{ $user->user->work_hours }} Hours</td>
                        <td class="py-3">{{ $user->user->role->name }}</td>
                        <td class="py-3">{{ $user->user->designation->name }}</td>
                        <td class="py-3">{{ $user->created_at->diffForHumans() }}</td>
                        <td class="py-3">{{ $user->updated_at->diffForHumans() }}</td>
                        <td><a href="/update-salary/{{ $user->id }}"class="text-sm bg-indigo-500 p-2 rounded-md font-bold text-white"><i class="fas fa-edit mr-2"></i>Update</a></td>
                    </tr>
                @endforeach
            </table>
            @else
                <p class="text-2xl">No Data about Salaries!</p>
            @endif
            {{-- {{ $users->links() }} --}}
        </div>
    @elseif($create == true)
        <button class="py-2 font-bold mb-2 text-white px-5 rounded-lg bg-indigo-700" wire:click='showUsers'>Users</button>
        <livewire:salary.add-salary />
    @endif
</div>