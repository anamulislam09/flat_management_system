<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function Index()
    {
        $packages = Package::get();
        return view('superadmin.packages.index', compact('packages'));
    }

    public function Create()
    {
        return view('superadmin.packages.create');
    }

    public function Store(Request $request)
    {
        $data['package_name'] = $request->package_name;
        $data['amount'] = $request->amount;
        $data['duration'] = $request->duration;
        Package::create($data);
        return redirect()->route('package.all')->with('message', 'Package Created Successfully');
    }

    // public function Edit($id)
    // {
    //     $data = Package::FindOrFail($id);
    //     return view('superadmin.packages.edit', compact('data'));
    // }

    // public function Update(Request $request)
    // {
    //     $data = Package::where('id', $request->id)->first();
    //     $data['amount'] = $request->amount;
    //     $data['duration'] = $request->duration;
    //     $data->save();
    //     return redirect()->back()->with('message', 'Package Updated Successfully');
    // }

    public function Delete($id)
    {
        $data = Package::where('id', $id)->first();
        $data->delete();
        return redirect()->back()->with('message', 'Package Deleted successfully.');
    }
}
