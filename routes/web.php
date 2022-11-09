<?php
namespace App;

use App\Models\User;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Salary;
use App\Http\Livewire\Employee;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\UpdateUserForm;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Orders\OrdersAdd;
use App\Http\Livewire\Orders\OrdersList;
use App\Http\Livewire\Supplier\Supplier;
use App\Http\Controllers\SetupController;
use App\Http\Livewire\Account\AccountPay;
use App\Http\Livewire\Account\AccountShow;
use App\Http\Livewire\Salary\SalaryUpdate;
use App\Http\Livewire\Products\ProductsAdd;
use App\Http\Livewire\Business\BusinessList;
use App\Http\Livewire\Business\BusinessType;
use App\Http\Livewire\Customers\CustomerAdd;
use App\Http\Livewire\Management\RoleUpdate;
use App\Http\Livewire\Products\ProductsList;
use App\Http\Controllers\LoginWireController;
use App\Http\Livewire\Attendance\UserAttendance;
use App\Http\Livewire\Customers\CustomerList;
use App\Http\Livewire\Products\ProductsStock;
use App\Http\Livewire\Products\ProductsUnits;
use App\Http\Livewire\Management\Designations;
use App\Http\Livewire\Products\ProductsBrands;
use App\Http\Livewire\Products\ProductsHistory;
use App\Http\Livewire\Attendance\AttendanceForm;
use App\Http\Livewire\Attendance\AttendanceShow;
use App\Http\Livewire\Products\ProductsCatagory;
use App\Http\Livewire\Products\ProductsSubunits;
use App\Http\Livewire\Management\DesignationUpdate;

Route::get('/', function(){
    return view('home', [
        'users'=> User::all()
    ]);
})->name('home')->middleware('guest');

Route::get('/setup', [SetupController::class, 'index'])->name('setup')->middleware('setup');
Route::post('/setup', [SetupController::class, 'store']);

Route::post('/login', [LoginWireController::class, 'store'])->name('login')->middleware('guest');
Route::post('/logout', [LoginWireController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/user-attendance', UserAttendance::class)->name('user-attendance'); 
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard'); 

    Route::get('/employee', Employee::class);
    Route::get('/update/{user_id}', UpdateUserForm::class);
    
    Route::get('/designations', Designations::class);
    Route::get('/update-designation/{design_id}', DesignationUpdate::class);

    Route::get('/roles', Roles::class);
    Route::get('/update-roles/{update_id}', RoleUpdate::class);

    Route::get('/attendance', AttendanceShow::class);
    Route::get('/attendance-data/{user_id}', AttendanceForm::class);
});


Route::middleware(['auth', 'finance'])->group(function () {
    Route::get('/salary', Salary::class)->name('salary');
    Route::get('/update-salary/{salary_id}', SalaryUpdate::class);

    Route::get('/accounts', AccountShow::class);
    Route::get('/generate-salary/{user_id}', AccountPay::class);
});


Route::middleware(['auth', 'inventory'])->group(function () {
    Route::get('/products', ProductsList::class)->name('products');
    Route::get('/products/add', ProductsAdd::class);
    Route::get('/products/catagory', ProductsCatagory::class);
    Route::get('/products/stocks', ProductsStock::class);
    Route::get('/products/units', ProductsUnits::class);
    Route::get('/products/subunits', ProductsSubunits::class);
    Route::get('/products/stocks/database', ProductsHistory::class);
    Route::get('/products/brands', ProductsBrands::class);

    Route::get('/business', BusinessList::class);
    Route::get('/business/types', BusinessType::class);

    Route::get('/customers', CustomerList::class);
    Route::get('/customers/add', CustomerAdd::class);

    Route::get('/suppliers', Supplier::class);

    Route::get('/orders', OrdersList::class);
    Route::get('/orders/add', OrdersAdd::class);
    
});


Route::get('/form', function(){
    return view('livewire.salary.add-salary');
});


// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', Dashboard::class)->name('dashboard'); 

//     Route::get('/employee', Employee::class);
//     Route::get('/update/{user_id}', UpdateUserForm::class);
    
//     Route::get('/designations', Designations::class);
//     Route::get('/update-designation/{design_id}', DesignationUpdate::class);

//     Route::get('/roles', Roles::class);
//     Route::get('/update-roles/{update_id}', RoleUpdate::class);

//     Route::get('/salary', Salary::class);
//     Route::get('/update-salary/{salary_id}', SalaryUpdate::class);

//     Route::get('/attendance', AttendanceShow::class);
//     Route::get('/attendance-data/{user_id}', AttendanceForm::class);

//     Route::get('/accounts', AccountShow::class);
//     Route::get('/generate-salary/{user_id}', AccountPay::class);

//     Route::get('/products', ProductsList::class);
//     Route::get('/products/add', ProductsAdd::class);
//     Route::get('/products/catagory', ProductsCatagory::class);
//     Route::get('/products/stocks', ProductsStock::class);
//     Route::get('/products/units', ProductsUnits::class);
//     Route::get('/products/subunits', ProductsSubunits::class);
//     Route::get('/products/stocks/database', ProductsHistory::class);
//     Route::get('/products/brands', ProductsBrands::class);

//     Route::get('/business', BusinessList::class);
//     Route::get('/business/types', BusinessType::class);

//     Route::get('/customers', CustomerList::class);
//     Route::get('/customers/add', CustomerAdd::class);

//     Route::get('/suppliers', Supplier::class);

//     Route::get('/orders', OrdersList::class);
//     Route::get('/orders/add', OrdersAdd::class);
    
// });