<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SetupController extends Controller
{
    public function index(){
        return view('setup');
    }

    public function store(Request $request){

        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:5'
        ]);

        User::create([
            'id' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1,
            'phone_number' => 03030000000,
            'designation_id' => 1,
            'work_hours' => 1,
            'address' => 'Unknown (First Time Setup Address)',
        ]);

        Designation::create([
            'id' => 1,
            'name' => "Super Administrator",
        ]);

        $data = [
            [
                'id' => 1,
                'name' => 'Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],
            [
                'id' => 2,
                'name' => 'Finance',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],[
                'id' => 3,
                'name' => 'Inventory',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('roles')->insert($data);

        return redirect()->route('home')->with('setup-success', 'Setup Success. Now Login with Email and Password!');
    }
}
