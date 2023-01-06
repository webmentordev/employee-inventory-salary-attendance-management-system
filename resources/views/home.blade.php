<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Employee Management</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="bg-gray-100 h-screen flex items-center justify-center">
        <section class="text-gray-600 body-font relative">
            <div class="container px-6 py-9 mx-auto w-form bg-white rounded-md shadow-sm border border-gray-200">
                <div class="flex flex-col text-center w-full">
                    <h1 class="sm:text-3xl text-7xl font-bold title-font text-gray-900">Login account</h1>
                </div>
                
                <div class="mx-auto">
                    <div class="flex flex-col justify-center w-full">
                        <div class="w-full">
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                @if (session('setup-success'))
                                    <p class="text-green-700 py-3 px-5 text-center">{{ session('setup-success') }}</p>
                                @endif
                                <div class="">
                                    @if (session('failed'))
                                        <p class="text-red-500 p-5 text-center">{{ session('failed') }}</p>
                                    {{-- @elseif(session('success'))
                                        <p class="text-green-700 py-3 px-5 text-center">{{ session('success') }}</p> --}}
                                    @endif
                                    <div class="relative mb-2">
                                        <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" autocomplete="off">
                                        @error('email')
                                            <p class="text-red-500 my-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <div class="relative">
                                        <label for="password" class="leading-7 text-sm text-gray-600">Password</label>
                                        <input type="password" id="password" name="password"
                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" autocomplete="off">
                                            @error('password')
                                                <p class="text-red-500 my-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    <input type="checkbox" name="remember" id="remember" class="mr-2 mb-2">
                                    <label for="remember">Remember me</label>
                                </div>
                                <div class="p-2 w-full">
                                    <button type="submit"
                                        class="flex mx-auto text-white bg-indigo-600 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-500 rounded text-lg">Login</button>
                                </div>
                                @if (session('logout-success'))
                                    <p class="text-green-700 py-3 px-5 text-center">{{ session('logout-success') }}</p>
                                @endif
                                @if (count($users) == 0)
                                    <a class="bg-green-700 p-2 px-6 rounded-sm text-white text-sm font-semibold" href="/setup">Setup</a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>    
</body>
</html>