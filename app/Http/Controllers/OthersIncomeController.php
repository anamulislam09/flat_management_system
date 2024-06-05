<?php

namespace App\Http\Controllers;

use App\Models\OthersIncome;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;

class OthersIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function OthersIncomeCreate()
    {
        return view('admin.income.others_income');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function OthersIncomeStore(Request $request)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        
        $item['month'] = $month;
        $item['year'] = $year;
        $item['date'] = date('Y-m');
        $item['auth_id'] = Auth::guard('admin')->user()->id;
        $item['client_id'] = Auth::guard('admin')->user()->id;
        $item['income_info'] = $request->income_info;
        $item['amount'] = abs($request->amount);
        OthersIncome::create($item);

        return redirect()->back()->with('message', 'Successfully Inserted');
    }
    /**
     * Display the specified resource.
     */
    public function show(OthersIncome $othersIncome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OthersIncome $othersIncome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OthersIncome $othersIncome)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OthersIncome $othersIncome)
    {
        //
    }
}
