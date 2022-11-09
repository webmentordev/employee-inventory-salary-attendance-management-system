@section('title', 'Add Products | Employee Management')
<div>
    <h1 class="text-3xl mb-3 font-bold">Products Management</span></h1>
    <div class="bg-white rounded-lg p-3 w-full">
        <p class="text-gray-800 p-3 mb-3 bg-yellow-200 rounded-t-lg"><i class="fas fa-exclamation fa-fw py-3 px-5 mr-3 rounded-full border-2 border-gray-700"></i> Please Add Units, Subunits, Catagory & Stock First then add Product.</p>
        @if (session('failed'))
            <p class="bg-red-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('failed') }}</p>
        @elseif(session('success'))
            <p class="bg-green-600 rounded-lg text-white px-3 py-4 mb-3">{{ session('success') }}</p>
        @endif
        <form wire:submit.prevent="saveData" method="post" class="w-full odd:mr-3">
            <div class="flex flex-col">
                <label class="text-gray-600 font-bold" for="name">Product Name:</label>
                <input type="text" wire:model="name" name="name" id="name" placeholder="Product Name"
                class="bg-gray-200 text-gray-800 p-3 mb-5">
                @error('name')
                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                @enderror
                <label class="text-gray-600 font-bold" for="catagory_id">Product Catagory:</label>
                <select wire:model="catagory_id" name="catagory_id" id="catagory_id"
                class="bg-gray-200 text-gray-800 p-3 mb-5">
                    @if ($catagories->count() && $catagories != null)
                        <option value="" selected>--Select Product Catagory--</option>
                        @foreach ($catagories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    @else
                        <option value="" selected>--Please add new Catagory first--</option>
                    @endif
                </select>
                @error('catagory_id')
                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                @enderror

                <label class="text-gray-600 font-bold" for="brand_id">Product Brand:</label>
                <select wire:model="brand_id" name="brand_id" id="brand_id"
                class="bg-gray-200 text-gray-800 p-3 mb-5">
                    @if ($brands->count() && $brands != null)
                        <option value="" selected>--Select Product Brand--</option>
                        @foreach ($brands as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    @else
                        <option value="" selected>--Please add new Brand first--</option>
                    @endif
                </select>
                @error('brand_id')
                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                @enderror

                <label class="text-gray-600 font-bold" for="stocks_id">Product Stock:</label>
                <select wire:model="stocks_id" name="stocks_id" id="stocks_id"
                class="bg-gray-200 text-gray-800 p-3 mb-5">
                    @if ($stocks->count() && $stocks != null)
                        <option value="" selected>--Select Stock--</option>
                        @foreach ($stocks as $item)
                            <option value="{{ $item->id }}">{{ $item->stock_size.$item->main_unit->name }}</option>
                        @endforeach
                    @else
                        <option value="" selected>--Please add stock first--</option>
                    @endif
                </select>
                @error('stocks_id')
                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                @enderror

                <label class="text-gray-600 font-bold" for="units_id">Product Unit:</label>
                <select wire:model="units_id" name="units_id" id="units_id"
                class="bg-gray-200 text-gray-800 p-3 mb-5">
                    @if ($units->count() && $units != null)
                        <option value="" selected>--Select Product Unit--</option>
                        @foreach ($units as $item)
                            <option value="{{ $item->id }}">{{ $item->subunit.$item->main_unit->name }}</option>
                        @endforeach
                    @else
                        <option value="" selected>--Please add Unit first--</option>
                    @endif
                </select>
                @error('units_id')
                    <p class="mb-3 text-red-500">{{ $message }}</p>   
                @enderror

                <label class="text-gray-600 font-bold" for="name">Product Price Per:</label>
                <input type="number" wire:model="price" name="price" id="price" placeholder="Price Per Main Unit"
                class="bg-gray-200 text-gray-800 p-3 mb-5">
                @error('price')
                    <p class="mb-3 text-red-500">{{ $message }}</p>
                @enderror

                <label class="text-gray-600 font-bold" for="image">Product Image:</label>
                <input type="file" wire:model="image" name="image" id="image"
                class="bg-gray-200 text-gray-800 p-3 mb-5">
                @error('image')
                    <p class="mb-3 text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-between">
                <button type="submit" class="bg-green-600 text-white font-bold rounded-lg px-4 py-3 block w-fit">Upload</button>
                <a href="/products" class="bg-blue-500 text-white rounded-lg px-4 py-3 block w-fit">Show Products</a>
            </div>
        </form>
    </div>
</div>