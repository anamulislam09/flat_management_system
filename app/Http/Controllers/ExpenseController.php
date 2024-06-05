<?php

namespace App\Http\Controllers;

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
        $expense = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->groupBy('cat_id')->get();
        return view('admin.accounts.ladger_account', compact('expense'));
    }

    public function store(Request $request)
    {
        // $month = Carbon::now()->month;
        // $year = Carbon::now()->year;
        // $isExist = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->exists();
        // if ($isExist) {
        //     return redirect()->back()->with('message', ' You have already close this month');
        // } else {
        //     $expenses = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->groupBy('cat_id')->get();
        //     // $expenses = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->groupBy('cat_id')->get();

        //     foreach ($expenses as $expense) {
        //         $data['year'] = $expense->year;
        //         $data['month'] = $expense->month;
        //         $data['cat_id'] = $expense->cat_id;
        //         $data['sub_total'] = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->where('cat_id', $expense->cat_id)->SUM('amount');
        //         // $data['total'] = $expense->cat_id;
        //         $data['client_id'] = $expense->client_id;
        //         $data['auth_id'] = $expense->auth_id;
        //         Expense::create($data);
        //     }

        //     return redirect()->back()->with('message', 'Month close successfully');
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
