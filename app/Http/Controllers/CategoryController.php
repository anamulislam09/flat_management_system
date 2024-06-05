<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Exp_detail;
use App\Models\Exp_process;
use App\Models\ExpenseVoucher;
use App\Models\Flat;
use App\Models\Income;
use App\Models\MonthlyBlance;
use App\Models\OpeningBalance;
use App\Models\OthersIncome;
use App\Models\User;
use App\Models\YearlyBlance;
use Illuminate\Http\Request;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Index()
    {
        if (Auth::guard('admin')->user()->role == 0) {
            $data = Category::all();
            return view('superadmin.exp_category.index', compact('data'));
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
        if (Auth::guard('admin')->user()->role == 0) {
            return view('superadmin.exp_category.create');
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Store(Request $request)
    {
        $data['name'] = $request->name;
        Category::create($data);

        return redirect()->route('category.index')->with('message', 'Category creted successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Category::findOrFail($id);
        $data->delete();
        return redirect()->route('category.index')->with('message', 'Category deleted successfully.');
    }


}
