<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Addressbook;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Auth;

class VendoreController extends Controller
{
    public function VendorIndex()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $vendors = Vendor::where('client_id', $user->client_id)->get();
        return view('user.vendors.index', compact('vendors'));
    }

    public function VendorCreate()
    {
        return view('user.vendors.create');
    }

    public function VendorStore(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $data['date'] = date('m/d/y');
        $data['client_id'] = $user->client_id;
        $data['auth_id'] = Auth::user()->user_id;
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        Vendor::create($data);
        return redirect()->route('manager.vendor.all')->with('message', 'Vendor Created Successfully!');
    }

    public function VendorEdit($id)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $data = Vendor::where('client_id', $user->client_id)->where('id', $id)->first();
        return view('user.vendors.edit', compact('data'));
    }

    public function VendorUpdate(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $id = $request->id;
        $data = Vendor::where('client_id', $user->client_id)->where('id', $id)->first();
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data->save();
        return redirect()->back()->with('message', 'Vendor Update Successfully');
    }
}
