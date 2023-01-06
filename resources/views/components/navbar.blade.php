<div class="w-[18%] bg-black relative h-screen overflow-hidden overflow-y-auto">
    <div class="h-full w-full p-3 bg-black">
        <div style="background-image:url({{ asset('storage/'.auth()->user()->image) }}); width:120px; height:120px; border-radius: 100%" class="mb-4 bg-cover bg-center m-auto"></div>
        <h1 class="text-white font-bold text-uppercase text-center text-3xl mb-6">Dashboard</h1>
        <ul class="flex flex-col">
            <a class="text-gray-300 my-3 px-3 w-full" href="/user-attendance"><i class="mr-3 fas fa-user fa-fw"></i>My Attendance</a>
            @if (auth()->user()->role_id == 1)
                <a class="text-gray-300 my-3 px-3 w-full" href="/dashboard"><i class="mr-3 fas fa-pie-chart fa-fw"></i>Dashboard</a>
                <a class="text-gray-300 my-3 px-3 w-full" href="/employee"><i class="mr-3 fas fa-user fa-fw"></i>Employee</a>
                <a class="text-gray-300 my-3 px-3 w-full" href="/designations"><i class="mr-3 fas fa-list fa-fw"></i>Designations</a>
                <a class="text-gray-300 my-3 px-3 w-full" href="/roles"><i class="mr-3 fas fa-address-book fa-fw"></i>Roles</a>
                <a class="text-gray-300 my-3 px-3 w-full" href="/attendance"><i class="mr-3 fas fa-address-card fa-fw"></i>Attendance</a>
            @endif

            @if (auth()->user()->role_id == 2 || auth()->user()->role_id == 1)
            <a class="text-gray-300 my-3 px-3 w-full" href="/salary"><i class="mr-3 fas fa-money-bill-alt fa-fw"></i>Salary Management</a>
            <a class="text-gray-300 my-3 px-3 w-full" href="/accounts"><i class="mr-3 fas fa-money-bill-alt fa-fw"></i>Accounts</a>
            @endif
            
            @if (auth()->user()->role_id == 3 || auth()->user()->role_id == 1)
                <a class="text-gray-300 my-3 px-3 w-full" href="/suppliers"><i class="mr-3 fas fa-cart-flatbed fa-fw"></i>Suppliers</a>
            @endif
        </ul>

        @if (auth()->user()->role_id == 3 || auth()->user()->role_id == 1)
            <details class=" open:bg-gray-900 p-3 rounded-lg mb-2">
                <summary class="text-gray-300"><i class="fas fa-box-archive mr-3"></i> Orders</summary>
                <ul class="p-3 flex flex-col">
                    <a class="text-gray-300 my-1 px-3 w-full" href="/orders"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Show Orders</a>
                    <a class="text-gray-300 my-1 px-3 w-full" href="/orders/add"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Place Orders</a>
                </ul>
            </details>

            <details class=" open:bg-gray-900 p-3 rounded-lg mb-2">
                <summary class="text-gray-300"><i class="fas fa-shopping-cart mr-3"></i> Products</summary>
                <ul class="p-3 flex flex-col">
                    <a class="text-gray-300 my-1 px-3 w-full" href="/products/catagory"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Catagory</a>
                    <a class="text-gray-300 my-1 px-3 w-full" href="/products/brands"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Brands</a>
                    <details class=" open:bg-gray-900 rounded-lg my-2 ml-5">
                        <summary class="text-gray-300">Products</summary>
                        <ul class="px-3 flex flex-col">
                            <a class="text-gray-300 my-1 px-3 w-full" href="/products"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Show Products</a>
                            <a class="text-gray-300 my-1 px-3 w-full" href="/products/add"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Add Products</a>
                        </ul>
                    </details>
                    
                    <details class=" open:bg-gray-900 rounded-lg my-2 ml-5">
                        <summary class="text-gray-300">Units</summary>
                        <ul class="px-3 flex flex-col">
                            <a class="text-gray-300 my-1 px-3 w-full" href="/products/units"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Show Units</a>
                            <a class="text-gray-300 my-1 px-3 w-full" href="/products/subunits"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Show SubUnits</a>
                        </ul>
                    </details>
                    <details class=" open:bg-gray-900 rounded-lg my-2 ml-5">
                        <summary class="text-gray-300">Stocks</summary>
                        <ul class="px-3 flex flex-col">
                            <a class="text-gray-300 my-1 px-3 w-full" href="/products/stocks"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Stocks Available</a>
                            <a class="text-gray-300 my-1 px-3 w-full" href="/products/stocks/database"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Stocks History</a>
                        </ul>
                    </details>
                </ul>
            </details>

            <details class=" open:bg-gray-900 p-3 rounded-lg mb-2">
                <summary class="text-gray-300"><i class="fas fa-briefcase mr-3"></i> Business</summary>
                <ul class="p-3 flex flex-col">
                    <a class="text-gray-300 my-1 px-3 w-full" href="/business"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Show Business</a>
                    <a class="text-gray-300 my-1 px-3 w-full" href="/business/types"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Show Business Types</a>
                </ul>
            </details>
            <details class=" open:bg-gray-900 p-3 rounded-lg mb-2">
                <summary class="text-gray-300"><i class="fas fa-users mr-3"></i> Customers</summary>
                <ul class="p-3 flex flex-col">
                    <a class="text-gray-300 my-1 px-3 w-full" href="/customers"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Show Customers</a>
                    <a class="text-gray-300 my-1 px-3 w-full" href="/customers/add"><i class="mr-3 fas fa-arrow-right fa-fw"></i>Add Customers</a>
                </ul>
            </details>
        @endif
    </div>
</div>