<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Exp_detail;
use App\Models\Expense;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class ExpenseController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function Index()
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $expSummary = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->groupBy('cat_id')->get();
        return view('admin.expenses.expense.expense_summary', compact('expSummary'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
        $exp_cat = Category::get();
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $expense = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->orderBy('id', 'DESC')->get();

        return view('admin.expenses.expense.create', compact('exp_cat', 'expense'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Store(Request $request)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $data['cat_id'] = $request->cat_id;
        $data['client_id'] = Auth::guard('admin')->user()->id;
        $data['year'] = $year;
        $data['month'] = $month;
        $data['amount'] = abs($request->amount);
        $data['date'] = date('Y-m');
        $data['auth_id'] = Auth::guard('admin')->user()->id;
        // dd($data);
        $exp = Expense::create($data);

        if (!$exp) {
            return redirect()->back()->with('message', 'Something went wrong');
        } else {
            return redirect()->back()->with('message', 'Expense creted successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Exp_detail $exp_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function Edit($id)
    {
        $data = Expense::findOrFail($id);
        $exp_cat = Category::get();
        return view('admin.expenses.expense.edit', compact('data', 'exp_cat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function Update(Request $request)
    {
        $id = $request->id;
        $data = Expense::findOrFail($id);
        $data['cat_id'] = $request->cat_id;
        $data['amount'] = abs($request->amount);
        $data->save();
        return redirect()->back()->with('message', 'Expense Updated Uuccessfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function Delate($id)
    {
        $data = Expense::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('message', 'Expense deleted successfully.');
    }
}

