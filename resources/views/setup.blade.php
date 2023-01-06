<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First Time Setup | Employee Management</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="bg-gray-100 h-screen flex items-center justify-center">
        <section class="text-gray-600 body-font relative">
            <div class="container px-6 py-9 mx-auto w-setup bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="flex flex-col text-center w-full mb-3">
                    <h1 class="sm:text-3xl text-7xl font-bold title-font text-gray-900">First Setup</h1>
                </div>
                <p class="text-md mb-3">This setup will create a new user, roles. This page will not showup again until you delete data from users and roles table.</p>
                <div class="mx-auto">
                    <div class="flex flex-col justify-center w-full">
                        <div class="w-full">
                            <form action="{{ route('setup') }}" method="post">
                                @csrf
                                <div class="relative mb-2">
                                    <label for="name" class="leading-7 text-sm font-semibold text-gray-600">Full Name:</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" autocomplete="off">
                                    @error('name')
                                        <p class="text-red-500 my-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative mb-2">
                                    <label for="email" class="leading-7 text-sm font-semibold text-gray-600">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" autocomplete="off">
                                    @error('email')
                                        <p class="text-red-500 my-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative mb-2">
                                    <label for="password" class="leading-7 text-sm font-semibold text-gray-600">Password</label>
                                    <input type="password" id="password" name="password" value="{{ old('password') }}"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" autocomplete="off">
                                    @error('password')
                                        <p class="text-red-500 my-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative mb-3">
                                    <label for="password_confirmation" class="leading-7 text-sm font-semibold text-gray-600">Password Confirmation</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" autocomplete="off">
                                    @error('password_confirmation')
                                        <p class="text-red-500 my-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit"
                                        class="text-white inline-block font-semibold bg-indigo-600 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-500 rounded text-lg">Setup</button>
                                @if (session('logout-success'))
                                    <p class="text-green-700 py-3 px-5 text-center font-semibold">{{ session('logout-success') }}</p>
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