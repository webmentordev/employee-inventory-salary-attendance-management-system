@section('title', 'User Attendance | Employee Management')
<div>
    <div class="flex">
        <h1 class="text-4xl mb-4 font-bold mr-3">Attendance Management</h1>
        <a class="uppercase rounded-lg font-bold bg-gray-900 text-white h-fit py-2 px-4" href="/generate-salary/{{ $user_id }}">Generate Salary</a>
    </div>
    @if (session('filterFailed'))
        <p class="bg-red-300 rounded-lg text-red-600 px-3 py-4 mb-3">{{ session('filterFailed') }}</p>
    @endif
    <div class="mb-3">
        <h1>From: {{ $fromDate }} | To: {{ $toDate }}</h1>
        <form wire:submit.prevent="updateFilter" class="grid grid-cols-3 gap-4">
            <div>
                <label for="from" class="text-gray-600">From-Date:</label>
                <input type="date" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2"
                id="from_date" name="fromDate" wire:model='fromDate'>
            </div>
            <div>
                <label for="to" class="text-gray-600">To-Date:</label>
                <input type="date" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-600 focus:ring-5 focus:ring-indigo-300 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2"
                id="to_date" name="toDate" wire:model='toDate'>
            </div>
            <button class="bg-blue-500 h-fit font-bold text-white py-[20px] px-6">Filter</button>
        </form>
    </div>
    @if($attendance->count())
        <div class="shadow-lg">
            <div class="bg-gray-500 py-3 px-4 rounded-t-lg grid grid-cols-5">
                <p class="my-2 text-white"><span class="text-gray-900 font-bold mr-3 text-lg">Name:</span>{{ $attendance[0]->user->name }}</p>
                <p class="my-2 text-white"><span class="text-gray-900 font-bold mr-3 text-lg">Role:</span>{{ $attendance[0]->user->role->name }}</p>
                <p class="my-2 text-white"><span class="text-gray-900 font-bold mr-3 text-lg">Designation:</span>{{ $attendance[0]->user->designation->name }}</p>
                <p class="my-2 text-white"><span class="text-gray-900 font-bold mr-3 text-lg">Status:</span>{{ $attendance[0]->user->status }}</p>
                <p class="my-2 text-white"><span class="text-gray-900 font-bold mr-3 text-lg">Working Hours:</span>{{ $attendance[0]->user->work_hours }}</p>
                @if ($attendance[0]->salary != null)
                    <p class="my-2 text-white"><span class="text-gray-900 font-bold mr-3 text-lg">Salary Per 30 Days:</span>PKR: {{ $attendance[0]->salary->salary }}</p>
                    <p class="my-2 text-white"><span class="text-gray-900 font-bold mr-3 text-lg">Salary Per Day:</span>PKR: {{ round($attendance[0]->salary->salary / 30) }}</p>
                    {{-- <p class="my-2 text-white"><span class="text-gray-900 font-bold mr-3 text-lg">Salary Per Hour:</span>PKR: {{ round(($attendance[0]->salary->salary / 30) / $attendance[0]->user->work_hours) }}</p> --}}
                    <p class="my-2 text-white"><span class="text-gray-900 font-bold mr-3 text-lg">Overall Salary:</span>PKR: {{ round($hours / 60) * (round(($attendance[0]->salary->salary / 30) / $attendance[0]->user->work_hours))  }}</p>
                    <p class="my-2 text-white"><span class="text-gray-900 font-bold mr-3 text-lg">BreakHours:</span>{{ intdiv($breakMinutes, 60).':'. ($breakMinutes % 60) }}</p>
                @endif
                <p class="my-2 text-white"><span class="text-gray-900 font-bold mr-3 text-lg">Hours Worked:</span>{{ intdiv($hours, 60).':'. ($hours % 60) }}</p>
            </div>

            @if ($attendance[0]->salary == null)
                <p class="bg-yellow-300 text-gray-900 p-3 py-4 w-full">Please add user's salary. <a href="/salary" class="underline">Click Here</a></p>
            @endif
            <table class="w-full bg-white rounded-b-lg text-center">
                <tr>
                    <th class="py-4 w-fit">Sr #</th>
                    <th class="py-4 w-fit">Status</th>
                    <th class="py-4 w-fit">Started</th>
                    <th class="py-4 w-fit">Finised</th>
                    <th class="py-4 w-fit">Worked</th>
                </tr>
                @foreach ($attendance as $key => $data)
                    <tr class="border-t text-center border-t-gray-200">
                        <td class="py-4">{{ $key + 1 }}</td>
                        <td>@if ($data->status == 'present')
                                <i class="fas fa-clock text-yellow-500"></i> Working...
                            @else
                                {{ $data->status }}
                            @endif
                        </td>
                        <td>{{ $data->created_at->format('D, d M Y H:i A') }}</td>
                        <td>{{ $data->updated_at->format('D, d M Y H:i A') }}</td>
                        {{-- <td>{{ round($data->updated_at->diffInMinutes($data->created_at, true) / 60) }}</td> --}}
                        <td><span class="bg-gray-800 text-white py-2 px-4 rounded-lg">{{ $data->created_at->diff($data->updated_at)->format('%H:%I:%S') }}</span></td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
        <p class="p-3 bg-red-500 text-white text-2xl rounded-lg">Please Put Correct Dates in the system.</p>
    @endif
</div>