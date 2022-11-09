@section('title', 'Attendance | Employee Management')
<div>
    <h1 class="text-3xl mb-3 font-bold">Attendance Management for <span class="text-gray-600">{{ date('D, d M Y') }}</span></h1>

    @if (session('failed'))
        <p class="bg-red-500 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
    @elseif(session('success'))
        <p class="bg-green-700 rounded-lg py-4 text-white px-5 mb-3">{{ session('success') }}</p>
    @endif
    
    @if ($users[0]->designation != null)
        <table class="w-full bg-white rounded-lg shadow-sm">
            <tr>
                <th class="py-4 w-fit">Sr #</th>
                <th class="py-4 w-fit">Name</th>
                <th class="py-4 w-fit">Attendance</th>
                <th class="py-4 w-fit">Status</th>
                <th class="py-4 w-fit">Minutes</th>
                <th class="py-4 w-fit">Breaks #</th>
                <th class="py-4 w-fit">BreakTime</th>
                <th class="py-4 w-fit">Action</th>
            </tr>

            @foreach ($users as $key=>$user)
                <tr class="border-t text-center border-t-gray-200">
                    <td class="py-4">{{ $key+1 }}</td>
                    <td><a href="/attendance-data/{{ $user->id }}" class="underline">{{ $user->name }}</a></td>
                    <div class="hidden">
                        @foreach ($user->break as $timeout)
                            {{ $minutes = $minutes + $timeout->updated_at->diffInMinutes($timeout->created_at) }}
                        @endforeach
                    </div>
                    @if($user->attendance != null)
                        @if ($user->attendance->created_at->format('d/m/Y') == date('d/m/Y') && $user->attendance->status == 'present')
                            <td>Present</td>
                            <td><i class="fas fa-clock text-yellow-500"></i> Working...</td>
                            <td>Working: {{ ($user->attendance->created_at->diffInMinutes(date('Y-m-d H:i:s'))) - $minutes }} Minutes</td>
                            <td>{{ count($user->break) }}</td>
                            <td>@if ($minutes != null)
                                    {{ $minutes }} Minutes
                                @else
                                    0 Minutes
                                @endif
                            </td>
                            {{ $minutes = null }}
                            <td><button wire:click="updateOut({{ $user->id }})" class="text-sm bg-red-500 p-2 rounded-md font-bold text-white warp-none mr-2"><i class="fas fa-times mr-2"></i>CheckOut</button>
                            @if($user->break->count())
                                @if ($user->break->last()->created_at->format('d/m/Y') == date('d/m/Y') && $user->break->last()->status == 'break')
                                    <button wire:click="endBreak({{ $user->break->last()->id }})" class="text-sm bg-blue-500 p-2 rounded-md font-bold text-white warp-none"><i class="fas fa-check mr-2"></i>BreakEnd</button>
                                @else
                                    <button wire:click="startBreak({{ $user->id }})" class="text-sm bg-blue-500 p-2 rounded-md font-bold text-white warp-none"><i class="fas fa-check mr-2"></i>Break</button>
                                @endif
                            @else
                                <button wire:click="startBreak({{ $user->id }})" class="text-sm bg-blue-500 p-2 rounded-md font-bold text-white warp-none"><i class="fas fa-check mr-2"></i>Break</button>
                            @endif
                        </td>
                        @elseif ($user->attendance->created_at->format('d/m/Y') == date('d/m/Y') && $user->attendance->status == 'Leave')
                            <td>Leave</td>
                            <td>Leave</td>
                            <td>Leave</td>
                            <td>Leave</td>
                            <td>Leave</td>
                            <td><span class="text-sm mr-2 bg-gray-900 p-2 px-4 rounded-md font-bold text-white warp-none">Leave</span></td>
                        @elseif ($user->attendance->created_at->format('d/m/Y') == date('d/m/Y') && $user->attendance->status == 'Completed')
                            <td>Completed</td>
                            <td><i class="fas fa-check text-green-500"></i> Work Completed!</td>
                            <td>{{ ($user->attendance->updated_at->diffInMinutes($user->attendance->created_at))- $minutes }}</td>
                            <td>{{ count($user->break) }}</td>
                            <td>{{ $minutes }} Minutes</td>
                            {{ $minutes = null }}
                            <td><span class="text-sm bg-green-500 p-2 rounded-md font-bold text-white warp-none"><i class="fas fa-user mr-2"></i>CheckedOut</span></td>
                        @else
                            <td>Absent</td>
                            <td>Not Arrived</td>
                            <td>0 Hours</td>
                            <td>0 Times</td>
                            <td>0 Hours</td>
                            <td><button wire:click="updateStatus({{ $user->id }})" class="text-sm mr-2 bg-blue-500 p-2 rounded-md font-bold text-white warp-none"><i class="fas fa-check mr-2"></i>CheckIn</button><button wire:click="updateLeave({{ $user->id }})" class="text-sm bg-yellow-400 p-2 rounded-md font-bold text-white warp-none"><i class="fas fa-sign-out mr-2"></i>Leave</button></td>
                        @endif
                    @else
                        <td>Absent</td>
                        <td>Not Arrived</td>
                        <td>0 Hours</td>
                        <td>0 Times</td>
                        <td>0 Minutes</td>
                        <td><button wire:click="updateStatus({{ $user->id }})" class="text-sm mr-2 bg-blue-500 p-2 rounded-md font-bold text-white warp-none"><i class="fas fa-check mr-2"></i>CheckIn</button><button wire:click="updateLeave({{ $user->id }})" class="text-sm bg-yellow-400 p-2 rounded-md font-bold text-white warp-none"><i class="fas fa-sign-out mr-2"></i>Leave</button></td>
                    @endif
                </tr>
            @endforeach
        </table>
    @else
        <p class="py-6 p-3 rounded-lg text-white bg-gray-600 mb-3">Employee's Designation or Role Data is missing please input that first!</p>
    @endif
</div>