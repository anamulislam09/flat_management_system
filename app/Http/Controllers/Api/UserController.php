<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    // show all users 
    public function Index()
    {
        $data = User::all();
        if ($data->count() > 0) {
            return response()->json([
                'status' => 200,
                'users' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No data available'
            ], 404);
        }
    }

    // show single customer
    public function show($id)
    {
        $data = User::FindOrFail($id);
        if ($data->count() > 0) {
            return response()->json([
                'status' => 200,
                'users' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No such product !'
            ], 404);
        }
    }

    // customers create 
    public function UserRegister(Request $request)
    {
        $flat_unique_id = $request->flat_unique_id;
        $customer_id = $request->customer_id;

        // $flat_name = $request->flat_name;
        $name = $request->name;
        // var_dump($flat_name);
        $phone = $request->phone;
        $nid_no = $request->nid_no;
        $address = $request->address;
        $email = $request->email;
        for ($i = 0; $i < count($flat_unique_id); $i++) {
           $user = User::insert([
                'user_id' => Auth::guard('admin')->user()->id . $flat_unique_id[$i],
                'customer_id' => $customer_id[$i],
                'flat_id' => $flat_unique_id[$i],
                'name' => $name[$i],
                'phone' => $phone[$i],
                'nid_no' => $nid_no[$i],
                'address' => $address[$i],
                'email' => $email[$i],
                'password' => Hash::make($phone[$i]),
            ]);
            $status['status'] = 1;
            DB::table('flats')->update($status);
        }

        if ($user) {
            return response()->json([
                'status' => 200,
                'message' => 'User Created successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }


    // customer edit 
    public function edit($id)
    {
        $data = User::FindOrFail($id);
        if ($data->count() > 0) {
            return response()->json([
                'status' => 200,
                'users' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No such product !'
            ], 404);
        }
    }

    // customer update 
    public function update(Request $request)
    {
        $id = $request->id;

        $data = User::findOrFail($id);
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['email'] = $request->email;
        $data['nid_no'] = $request->nid_no;
        $data['address'] = $request->address;
        $data['status'] = $request->status;
        $data['role_id'] = $request->role_id;
        $data->save();


        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'User Updated successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    // delete single customer
    public function delete($id)
    {
        $data = User::FindOrFail($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => 'User Deleted Successfully!'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No such role !'
            ], 404);
        }
    }


    // customers login 
    public function UserLogin(Request $request)
    {
        $check = $request->all();
        if (Auth::guard('web')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
            return response()->json([
                'status' => 200,
                'message' => 'Login Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Invalid Email or Password!'
            ], 500);
        }
    }
    //end method
}
