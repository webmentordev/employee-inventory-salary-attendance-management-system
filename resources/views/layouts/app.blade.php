<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-scroll.css') }}">
    <link rel="shortcut icon" href="{{ asset('storage/'.auth()->user()->image) }}">
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @livewireStyles
</head>
<body class="antialiased bg-gray-200 h-screen">
    <form action="{{ route('logout') }}" method="post" class="fixed top-4 right-6 z-50">
        @csrf
        <button type="submit" class="bg-white py-2 px-4 text-sm drop-shadow font-bold rounded-md"><i class="mr-2 fas fa-sign-out fa-fw"></i>Logout</button>
    </form>
    <div class="bg-white">
        <div class="flex">
            <x-navbar />
            <div class="w-full bg-gray-100 p-4 h-screen overflow-y-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
@livewireScripts