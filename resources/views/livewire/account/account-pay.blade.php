@section('title', 'Generate Salary | Employee Management')
<div>
    <h1 class="text-3xl mb-3 font-bold">Generate Salary</span></h1>
    @if (session('failedPay'))
        <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failedPay') }}</p>
    @elseif(session('successPay'))
        <p class="bg-green-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('successPay') }}</p>
    @endif
    <div class="w-full bg-white rounded-lg shadow-sm p-6 relative mb-3">
        <p class="p-3 rounded-sm text-white mb-2 bg-gray-900">Salary for Month <span class="underline">{{ $month }}</span></p>
        <input class="rounded-lg p-2 bg-blue-400 focus:outline-none text-white mb-2 w-full"
        type="month" wire:model="date" name="date" id="date" placeholder="Dates">

        <div class="flex mb-3">
           @if ($user[0]->salary != null)
                @if ($user[0]->designation != null)
                    @if ($user->count())
                        @foreach ($user as $item)
                            @if ($item->salary != null)
                                <div class="bg-gray-200 w-full mr-6 rounded-lg p-6">
                                    <h1 class="font-bold text-gray-600 text-3xl">User Information:</h1>
                                    <div class="flex my-4">
                                        <h2 class="mr-2 font-bold">Name:</h2>
                                        <p class="text-gray-600">{{ $item->name }}</p>
                                    </div>
                                    <div class="flex my-4">
                                        <h2 class="mr-2 font-bold">RoleName:</h2>
                                        <p class="text-gray-600">{{ $item->role->name }}</p>
                                    </div>
                                    <div class="flex my-4">
                                        <h2 class="mr-2 font-bold">Designation:</h2>
                                        <p class="text-gray-600">{{ $item->designation->name }}</p>
                                    </div>
                                    <div class="flex my-4">
                                        <h2 class="mr-2 font-bold">Work Hours:</h2>
                                        <p class="text-gray-600">{{ $item->work_hours }} Hours a day</p>
                                    </div>
                                    <div class="flex my-4">
                                        <h2 class="mr-2 font-bold">Salary:</h2>
                                        <p class="text-gray-600">{{ $item->salary->salary }} For 30 Days</p>
                                    </div>
                                </div>
                                <div class="bg-gray-200 w-full rounded-lg p-6">
                                    <h1 class="font-bold text-gray-600 text-3xl">Salary Information:</h1>
                                    <div class="flex my-4">
                                        <h2 class="mr-2 font-bold">{{ $month }} Hours:</h2>
                                        <p class="text-gray-600">{{ $total_hours }}</p>
                                    </div>

                                    <div class="flex my-4">
                                        <h2 class="mr-2 font-bold">Salary Per Day:</h2>
                                        <p class="text-gray-600">{{ round($user[0]->salary->salary / 30) }}</p>
                                    </div>

                                    <div class="flex my-4">
                                        <h2 class="mr-2 font-bold">Salary Per Hour:</h2>
                                        <p class="text-gray-600">{{ $item->name }}</p>
                                    </div>

                                    <div class="flex my-4">
                                        <h2 class="mr-2 font-bold">Salary for <span class="text-blue-600">{{ $month }}</span></h2>
                                        <p class="text-gray-600">PKR: {{ number_format($salary, 2) }}</p>
                                    </div>
                                    <div class="flex my-4">
                                        <h2 class="mr-2 font-bold">Status</h2>
                                        <p class="text-gray-600">
                                            @if ($status == 'Paid')
                                                <span class="bg-green-600 text-white py-2 px-4 font-bold rounded-lg">Paid</span>
                                            @else
                                                <span class="bg-red-500 text-white py-2 px-4 font-bold rounded-lg">Unpaid</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p>Please Put a Right User!</p>
                    @endif
                @else
                    <p class="py-6 p-3 rounded-lg text-white bg-gray-600 mb-3">Employee's Designations/Roles are empty. Please insert that data first! </p>
                @endif
            @else
                <p class="py-6 p-3 rounded-lg text-white bg-gray-600 mb-3">User's Salary Data Not Found. Please add Salary for user first! </p>
           @endif
        </div>
        <p class="text-gray-500 px-3 mb-2">Salary is calculated for the selected whole month at once, even if user has worked or not.  All Holidays including Sundays and Leaves are marked as completed work hours. For now for future salary, only sundays working hours are calculated & salary will be paid for it.</p>
        <button wire:click="openConfirm()" class="px-4 py-1 bg-green-700 text-white rounded-md absolute right-2 bottom-2">Pay</button>
    </div>

    <div class="w-full bg-white rounded-lg shadow-sm p-6">
        <table class="w-full bg-white rounded-b-lg text-center">
            <tr>
                <th class="py-4 w-fit">Sr #</th>
                <th class="py-4 w-fit">Worked</th>
                <th class="py-4 w-fit">Month</th>
                <th class="py-4 w-fit">Salary</th>
                <th class="py-4 w-fit">Paid_At</th>
                <th class="py-4 w-fit">Status</th>
            </tr>
            @if ($payments->count())
                @foreach ($payments as $key => $payment)
                    <tr class="border-t text-center border-t-gray-200">
                        <td class="py-4">{{ $key + 1 }}</td>
                        <td>PKR: {{ number_format($payment->salary, 2) }}</td>
                        <td>{{ $payment->hours }} Hours</td>
                        <td>{{ $payment->period }}</td>
                        <td>{{ $payment->created_at->format('D, d m,Y') }}</td>
                        <td><span class="p-2 bg-green-700 text-white rounded-md">{{ $payment->status }}</span></td>
                    </tr>
                @endforeach
            @else
                <tr class="border-t text-center border-t-gray-200">
                    <td class="py-4">No Salary Data</td>
                    <td>No Salary Data</td>
                    <td>No Salary Data</td>
                    <td>No Salary Data</td>
                    <td>No Salary Data</td>
                    <td>No Salary Data</td>
                </tr>
            @endif
        </table>
    </div>

    @if($alertPop == true)
        <div class="bg-gray-900 bg-opacity-90 fixed z-30 w-full h-screen left-0 top-0 flex justify-center items-center" wire:click="closeConfirm()">
            <div class="bg-white rounded-lg p-10 w-4/12">
                <i class="text-6xl mb-2 text-white align-center p-3 rounded-full bg-red-500 fas fa-exclamation fa-fw"></i>
                <p class="mb-2 text-lg text-gray-500">Do you really want to pay salary for employee? Remember, this process can not be removed.</p>
                <ul class="grid grid-cols-2 gap-3">
                    <button wire:click="closeConfirm()" class="text-white p-3 py-4 rounded-lg bg-red-500">Cancel</button>
                    <button wire:click="paynow({{ $user[0]->id }})" class="text-white p-3 py-4 rounded-lg bg-blue-500">Confirm</button>
                </ul>
            </div>
        </div>
    @endif
</div>