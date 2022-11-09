<div class="bg-gray-300 h-screen flex items-center justify-center">
    @auth
        <form wire:submit.prevent='logout' method="post" class="fixed top-4 left-4">
            <button type="submit" class="bg-white py-2 px-4 drop-shadow font-bold rounded-md">Logout</button>
        </form>   
    @endauth
    <section class="text-gray-600 body-font relative">
        <div class="container px-6 py-9 mx-auto w-form bg-white rounded-lg drop-shadow-2xl">
            <div class="flex flex-col text-center w-full">
                <h1 class="sm:text-3xl text-7xl font-bold title-font text-gray-900">Login account</h1>
            </div>
            <div class="mx-auto">
                <div class="flex flex-col justify-center w-full">
                    <div class="w-full">
                        <form wire:submit.prevent='submit' method="post">
                            <div class="">
                                @if (session('failed'))
                                    <p class="text-red-500 p-5 text-center">{{ session('failed') }}</p>
                                @elseif(session('success'))
                                    <p class="text-green-700 py-3 px-5 text-center">{{ session('success') }}</p>
                                @endif
                                <div class="relative mb-2">
                                    <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                                    <input type="email" id="email" wire:model='email' name="email"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" autocomplete="off">
                                    @error('email')
                                        <p class="text-red-500 my-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div class="relative">
                                    <label for="password" class="leading-7 text-sm text-gray-600">Password</label>
                                    <input type="password" id="password" wire:model="password" name="password"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out mb-2" autocomplete="off">
                                        @error('password')
                                            <p class="text-red-500 my-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                <input type="checkbox" name="remember" wire:model="remember" id="remember" class="mr-2 mb-2">
                                <label for="remember">Remember me</label>
                            </div>
                            <div class="p-2 w-full">
                                <button type="submit"
                                    class="flex mx-auto text-white bg-indigo-600 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-500 rounded text-lg">Login</button>
                            </div>
                            @if (session('logout-success'))
                                <p class="text-green-700 py-3 px-5 text-center">{{ session('logout-success') }}</p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
