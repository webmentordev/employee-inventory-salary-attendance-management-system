@section('title', 'Dashboard | Employee Management System')
<div>
    <h1 class="text-2xl mb-3 font-bold">Dashboard</h1>
    <div class="grid grid-cols-3 gap-4 mb-2">
        <div class="flex px-3 py-4 bg-white border-l-4 border-gray-600 shadow-lg items-center">
            <i class="fas fa-user text-4xl mr-3"></i>
            <div class="flex flex-col">
                <h2 class="font-bold text-2xl">{{ $users }}</h2>
                <p class="text-gray-500">Registered Employees</p>
            </div>
        </div>

        <div class="grid grid-cols-2 px-3 py-4 bg-white border-l-4 border-gray-600 shadow-lg items-center">
            <div class="box flex items-center">
                <i class="fas fa-cog text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $designations }}</h2>
                    <p class="text-gray-500">Total Desginations</p>
                </div>
            </div>
            <div class="box flex items-center border-l-2 border-gray-700 px-3">
                <i class="fas fa-users text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $roles }}</h2>
                    <p class="text-gray-500">Total Roles</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 px-3 py-4 bg-white border-l-4 border-gray-600 shadow-lg items-center">
            <div class="box flex items-center">
                <i class="fas fa-address-book text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $active }}</h2>
                    <p class="text-gray-500">Active Employees</p>
                </div>
            </div>
            <div class="box flex items-center border-l-2 border-gray-700 px-3">
                <i class="fas fa-times text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $inactive }}</h2>
                    <p class="text-gray-500">Inactive Employees</p>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-2 px-3 py-4 bg-white border-l-4 border-gray-600 shadow-lg items-center">
            <div class="box flex items-center">
                <i class="fas fa-cart-plus text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $orders  }}</h2>
                    <p class="text-gray-500">Orders Completed</p>
                </div>
            </div>
            <div class="box flex items-center border-l-2 border-gray-700 px-3">
                <i class="fas fa-list text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $orders_pending }}</h2>
                    <p class="text-gray-500">Orders Pending</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 px-3 py-4 bg-white border-l-4 border-gray-600 shadow-lg items-center">
            <div class="box flex items-center">
                <i class="fas fa-shopping-cart text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $products }}</h2>
                    <p class="text-gray-500">Total Products</p>
                </div>
            </div>
            <div class="box flex items-center border-l-2 border-gray-700 px-3">
                <i class="fas fa-list text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $catagories }}</h2>
                    <p class="text-gray-500">Total Catagories</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 px-3 py-4 bg-white border-l-4 border-gray-600 shadow-lg items-center">
            <div class="box flex items-center">
                <i class="fas fa-briefcase text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $business }}</h2>
                    <p class="text-gray-500">Registered Business</p>
                </div>
            </div>
            <div class="box flex items-center border-l-2 border-gray-700 px-3">
                <i class="fas fa-parachute-box text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $supplier }}</h2>
                    <p class="text-gray-500">Registered Suppliers</p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-5 col-span-3 px-3 py-4 bg-white border-x-4 border-gray-600 shadow-lg items-center">
            <div class="box flex items-center">
                <i class="fas fa-database text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $stock }}</h2>
                    <p class="text-gray-500">Total Available Stock</p>
                </div>
            </div>

            <div class="box flex items-center border-l-2 border-gray-700 px-3">
                <i class="fas fa-coins text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ number_format($stock_worth, 2) }}</h2>
                    <p class="text-gray-500">Overall Stock Cost</p>
                </div>
            </div>

            <div class="box flex items-center border-l-2 border-gray-700 px-3">
                <i class="fas fa-check-to-slot text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $stock_sold }}</h2>
                    <p class="text-gray-500">Stock Sold</p>
                </div>
            </div>

            <div class="box flex items-center border-l-2 border-gray-700 px-3">
                <i class="fas fa-boxes-stacked text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ $stockHistory }}</h2>
                    <p class="text-gray-500">Overall Stock Size</p>
                </div>
            </div>

            <div class="box flex items-center border-l-2 border-gray-700 px-3">
                <i class="fas fa-coins text-4xl mr-3"></i>
                <div class="flex flex-col">
                    <h2 class="font-bold text-2xl">{{ number_format($soldPrice, 2) }}</h2>
                    <p class="text-gray-500">Worth Of Stock Sold</p>
                </div>
            </div>
        </div>
    </div>
    <div class="chart flex justify-center items-center m-auto w-11/12">
        <canvas id="myChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');

        let delayed;
        let hours = {{ $workHours }}
        // let gradient = ctx.createLinearGradient(0,0,0, 400);
        // gradient.addColorStop(0, 'rgba(58, 123, 213, 1)');
        // gradient.addColorStop(1, 'rgba(0, 210, 255, 0.3)');

        console.log(@json($dates))
        const config = {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: [
                    {
                        data: @json($result),
                        label: `Total ${hours} Work Hours a Month`,
                        borderColor: '#1c43a6',
                        backgroundColor: 'rgba(28, 67, 166, 0.1)',
                        fill: true,
                        tension: 0.2,
                        pointBackgroundColor: "#1c43a6"
                    },
                ],
            },
            options:{
                responsive: true,
                radius: 10,
                hoverRadius: 12,
                hitRadius: 30,
                animation: {
                    onComplete: () =>{
                        delayed = true;
                    },
                    delay: (context) =>{
                        let delay = 0;
                        if(context.type === 'data' && context.mode === 'default' && !delayed){
                            delay = context.dataIndex * 200 + context.datasetIndex * 200;
                        }
                        return delay;
                    },
                },
                scales: {
                    y:{
                        ticks: {
                            callback: function(value){
                                return value+' Hours';
                            }
                        },
                        beginAtZero: true
                    },
                }
            }
        }

        const myChart = new Chart(ctx, config);
    </script>
</div>
