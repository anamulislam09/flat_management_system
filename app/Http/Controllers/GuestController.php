<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function Index()
    {
        $guests = Guest::where('client_id', Auth()->guard('admin')->user()->id)->get();
        return view('admin.guest.index', compact('guests'));
    }

    public function Create()
    {
        $flats = Flat::where('client_id', Auth()->guard('admin')->user()->id)->get();
        return view('admin.guest.create', compact('flats'));
    }

    public function Store(Request $request)
    {
dd($request);
        $data['date'] = date('m/d/y');
        $data['client_id'] = Auth()->guard('admin')->user()->id;
        $data['auth_id'] = Auth()->guard('admin')->user()->id;
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        Guest::create($data);
        return redirect()->route('guestBook.index')->with('message', 'Created Successfully!');
    }

    public function Edit($id)
    {
        $data = Vendor::where('client_id', Auth()->guard('admin')->user()->id)->where('id', $id)->first();
        return view('admin.vendors.edit', compact('data'));
    }

    public function Update(Request $request)
    {
        $id = $request->id;
        $data = Vendor::where('client_id', Auth()->guard('admin')->user()->id)->where('id', $id)->first();
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data->save();
        return redirect()->back()->with('message', 'Vendor Update Successfully');
    }

    public function ShowHistory()
    {
        $vendors = Vendor::where('client_id', Auth()->guard('admin')->user()->id)->get();
        return view('admin.vendors.index', compact('vendors'));
    }
}
