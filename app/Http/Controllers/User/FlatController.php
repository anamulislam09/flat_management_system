<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FlatController extends Controller
{
    public function Index()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $data = Flat::where('customer_id', $user->customer_id)->get();
        return view('user.flat.index', compact('data'));
    }

    // flat single create start here
    public function SingleCreate()
    {
        return view('user.flat.single_create');
    }
    // flat single create start here

    // flat SingleStore start here
    public function SingleStore(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $unique_name = Flat::where('customer_id', $user->customer_id)->where('flat_name', $request->flat_name)->exists();
        if ($unique_name) {
            return redirect()->back()->with('message', 'Flat name already taken.');
        } else {
            $unique_id = Flat::where('customer_id', $user->customer_id)->max('flat_unique_id');
            $flat = Flat::where('customer_id', $user->customer_id)->first();

            $zeroo = '0';
            $data['flat_unique_id'] = ($zeroo) . ++$unique_id;
            $data['customer_id'] = $user->customer_id;
            $data['flat_name'] = $request->flat_name;
            $data['floor_no'] = $request->floor_no;
            $data['charge'] = "Service Charge";
            $data['amount'] = $flat->amount;
            $data['create_date'] = date('d');
            $data['create_month'] = date('F');
            $data['create_year'] = date('Y');

            $flat = Flat::create($data);
            if ($flat) {
                $latest_flat = Flat::where('customer_id', $user->customer_id)->latest()->first();
                $user = User::insert([
                    'user_id' => $latest_flat->customer_id . $latest_flat->flat_unique_id,
                    'customer_id' => $latest_flat->customer_id,
                    'flat_id' => $latest_flat->flat_unique_id,
                    'charge' => $latest_flat->charge,
                    'amount' => $latest_flat->amount,
                ]);
                if ($user) {
                    return redirect()->route('manager.flat.index')->with('message', 'Flat creted successfully');
                } else {
                    return redirect()->back()->with('message', 'Something Went Wrong');
                }
            }
        }
    }
    // flat SingleStore ends here

    // show all users 
    public function UserIndex()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $flat = Flat::where('customer_id', $user->customer_id)->get();;
        if (!empty($flat)) {
            $data = User::where('customer_id', $user->customer_id)->get();
            return view('user.users.index', compact('data'));
        }
        // $data = User::where('customer_id', Auth::guard('admin')->user()->id)->get();;
        return view('user.users.index');
        //end method
    }

     // edit method 
  public function Edit($id)
  {
    $user = User::where('user_id', Auth::user()->user_id)->first();
    $data = User::where('customer_id', $user->customer_id)->where('id', $id)->first();
    // $roles = Role::all();
    return view('user.users.edit', compact('data'));
    //end method
  }

  public function Update(Request $request)
  {
    $user = User::where('user_id', Auth::user()->user_id)->first();
    $id = $request->id;
    $customer_id = $request->customer_id;
    $data = User::where('customer_id', $user->customer_id)->where('id', $id)->first();
    $data['name'] = $request->name;
    $data['email'] = $request->email;
    $data['phone'] = $request->phone;
    $data['nid_no'] = $request->nid_no;
    $data['address'] = $request->address;
    $data['password'] = Hash::make($request->phone);
    $data['status'] = $request->status ? 1 : 0;
    $data->save();
    return redirect()->back()->with('message', 'User update successfully');
    //end method
  }
}
