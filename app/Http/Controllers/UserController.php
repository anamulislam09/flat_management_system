<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Expense;
use App\Models\Flat;
use App\Models\Income;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function Index()
  {
    $data = User::where('client_id', Auth::guard('admin')->user()->id)->get();
    return view('admin.users.index', compact('data'));
  }

  //create single user method start here
  public function SingleCreate()
  {
    return view('admin.users.create_single');
  }

  public function SingleStore(Request $request)
  {
    $name = $request->name;
    $user_id  = $request->user_id;
    $phone = $request->phone;
    $nid_no = $request->nid_no;
    $address = $request->address;
    $email = $request->email;

    $user = User::insert([
      'user_id' => $user_id,
      'client_id' => Auth::guard('admin')->user()->id,
      'name' => $name,
      'phone' => $phone,
      'nid_no' => $nid_no,
      'role_id' => 1,
      'address' => $address,
      'email' => $email,
      'password' => Hash::make($phone),
    ]);
    return redirect()->route('users.index')->with('message', 'User Created Successfully');
  }
  //create single user method emds here

  // edit method 
  public function Edit($id)
  {
    $data = User::where('client_id', Auth::guard('admin')->user()->id)->where('id', $id)->first();
    // $roles = Role::all();
    return view('admin.users.edit', compact('data'));
    //end method
  }

  public function Update(Request $request)
  {
    $id = $request->id;
    $client_id = $request->client_id;
    $data = User::where('client_id', $client_id)->where('user_id', $id)->first();
    $data['name'] = $request->name;
    $data['email'] = $request->email;
    $data['phone'] = $request->phone;
    $data['nid_no'] = $request->nid_no;
    $data['address'] = $request->address;
    $data['password'] = Hash::make($request->phone);
    $data['status'] = $request->status ? 1 : 0;
    // dd($data);
    $data->save();
    return redirect()->back()->with('message', 'User Update Successfully');
    //end method
  }

  /*-----------------User login start here-------------------*/
  public function LoginForm()
  {
    return view('user.user_profile.login');
  }

  public function Login(Request $request)
  {
    $IsManager = User::where('user_id', $request->user_id)->where('phone', $request->password)->first();
    $check = $request->all();
    $datas = Auth::guard('web')->attempt(['user_id' => $check['user_id'], 'password' => $check['password'], 'status' => 1]);
    if (!$datas) {
      return back()->with('message', 'Something Went Wrong! ');
    } else {
      if (Auth::guard('web')->attempt(['user_id' => $check['user_id'], 'password' => $check['password']])) {
        if ($IsManager->role_id == 1) {
          return redirect()->route('user.Profile')->with('message', 'Manager Login Successfully');
        } else {
          return redirect()->route('user.Profile')->with('message', 'User Login Successfully');
        }
      } else {
        return back()->with('message', 'Invalid Email or Password! ');
      }
    }
  }

  public function Profile()
  {
    return view('user.user_profile.index');
  }

  // user dashboard date transaction start here 

  public function GetTransaction($date)
  {
    // $Manager = User::where('user_id', Auth::user()->user_id)->first();

    // $data['flats'] = Flat::where('client_id', $Manager->client_id)->count();
    //   $data['expense'] = Expense::where('client_id', $Manager->client_id)->where('date', $date)->sum('amount');
    //   $data['income'] = Income::where('client_id', $Manager->client_id)->where('date', $date)->sum('paid');
    //   $manualOpeningBalance = DB::table('opening_balances')->where('client_id', $Manager->client_id)->where('entry_datetime', $date)->first();
    //   $data['others_income'] = DB::table('others_incomes')->where('client_id', $Manager->client_id)->where('date', $date)->sum('amount');
    //   $data['balance'] = Balance::where('client_id', $Manager->client_id)->where('date', $date)->sum('amount');


    $timestamp = strtotime($date);
    $month = date('n', $timestamp); // 'n' gives month without leading zeros
    $year = date('Y', $timestamp);
    $user = User::where('user_id', Auth::user()->user_id)->first();

    $data['flats'] = Flat::where('client_id', $user->client_id)->count();
    $data['expense'] = Balance::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->value('total_expense');
    $data['income'] = Balance::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->value('total_income');
    $data['balance'] = Balance::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->value('amount');

    return response()->json($data);
  }
  // user dashboard date transaction ends here 
}
