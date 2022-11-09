@section('title', 'My Attendance | Employee Management')
<div>
    <h1 class="text-4xl mb-3 font-bold">My Attendance Form:</h1>
    @if (session('failed'))
        <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
    @elseif(session('success'))
        <p class="bg-green-600 rounded-lg text-white border-l-[10px] border-green-900 px-3 py-4 mb-3">{{ session('success') }}</p>
    @endif
    <div class="h-[80vh] flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg">
            <h1 class="mb-3 text-lg"><span class="font-bold">Attendance for: </span> {{ date('D, d, M Y') }}</h1>
            @if ($attendance->Count() && $attendance != null)
                <p class="text-center mb-2">Worked For <span>{{ $attendance[0]->updated_at->diffInMinutes($attendance[0]->created_at) }} Minutes</span></p>
            @endif

            @if ($breaks->Count() && $breaks != null)
                <p class="text-center mb-2">Took {{ $breaks->Count() }} Breaks Today</span></p>
            @else
                <p class="text-center mb-2">Took {{ $breaks->Count() }} Breaks Today</span></p>
            @endif

            <div class="grid grid-cols-2 gap-2">
                @if ($user[0]->attendance != null)
                    @if ($user[0]->attendance->created_at->format('d/m/Y') == date('d/m/Y') && $user[0]->attendance->status == 'present')
                        <button wire:click="updateOut" class="text-white p-3 font-bold bg-purple-600 rounded-lg">CheckOut</button>
                        @if($user[0]->break->count())
                            @if ($user[0]->break->last()->created_at->format('d/m/Y') == date('d/m/Y') && $user[0]->break->last()->status == 'break')
                                <button wire:click="endBreak" class="text-white p-3 font-bold bg-red-600 rounded-lg w-full">BreakOut</button>
                            @else
                                <button wire:click="startBreak" class="text-white p-3 font-bold bg-blue-600 rounded-lg w-full">Break</button>
                            @endif
                        @else
                            <button wire:click="startBreak" class="text-white p-3 font-bold bg-blue-600 rounded-lg">Break</button>
                        @endif
                    @elseif($user[0]->attendance->created_at->format('d/m/Y') == date('d/m/Y') && $user[0]->attendance->status == 'Leave')
                        <p>Leave Assigned! Thank You!</p>
                    @elseif($user[0]->attendance->created_at->format('d/m/Y') == date('d/m/Y') && $user[0]->attendance->status == 'Completed')
                        <p>Worked Completed! Thank You!</p>
                    @else
                        <button wire:click="updateStatus" class="text-white p-3 font-bold bg-green-600 rounded-lg w-full">CheckIn</button>
                        <button wire:click="updateLeave" class="text-white p-3 font-bold bg-gray-900 rounded-lg w-full">Leave</button>
                    @endif
                @else
                    <button wire:click="updateStatus" class="text-white p-3 font-bold bg-green-600 rounded-lg w-full">CheckIn</button>
                    <button wire:click="updateLeave" class="text-white p-3 font-bold bg-gray-900 rounded-lg w-full">Leave</button>
                @endif
            </div>
        </div>
    </div>
</div>