@section('title', 'Accounts | Employee Management')
<div>
    <h1 class="text-3xl mb-3 font-bold">Accounts Management</span></h1>
    @if ($users[0]->designation != null)
        <table class="w-full bg-white rounded-lg shadow-sm">
            <tr>
                <th class="py-4 w-fit">Sr #</th>
                <th class="py-4 w-fit">Name</th>
                <th class="py-4 w-fit">Designation</th>
                <th class="py-4 w-fit">RoleName</th>
                <th class="py-4 w-fit">Salary <span class="text-gray-500 text-sm">/30Days</span></th>
                <th class="py-4 w-fit">Payments</th>
                <th class="py-4 w-fit">Pay</th>
            </tr>

            @foreach ($users as $key=>$user)
                <tr class="border-t text-center border-t-gray-200 even:bg-gray-100">
                    <td class="p-3">{{ $key+1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->designation->name }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>@if ($user->salary != null)
                            PKR {{ $user->salary->salary }}
                        @else
                            Salary Data Not Found!
                        @endif
                    </td>
                    <td><span class="text-sm p-2 rounded-md font-bold  warp-none">{{ count($user->payments) }} Payments</span></td>
                    <td><a href="/generate-salary/{{ $user->id }}" class="text-sm bg-green-500 p-2 rounded-md font-bold text-white warp-none">PayNow</a></td>
                </tr>
            @endforeach
        </table>
    @else
        <p class="py-6 p-3 rounded-lg text-white bg-gray-600 mb-3">Employee's Designations/Roles are empty. Please insert that data first! </p>
    @endif
</div>