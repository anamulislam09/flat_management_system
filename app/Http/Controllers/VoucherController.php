<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Exp_detail;
use App\Models\Exp_process;
use App\Models\Expense;
use App\Models\Income;
use App\Models\MonthlyBlance;
use App\Models\OpeningBalance;
use App\Models\OthersIncome;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function Index()
    {   //show voucher page
        $months = Carbon::now()->month;
        $year = Carbon::now()->year;
        $income = Income::where('client_id', Auth::guard('admin')->user()->id)->where('month', $months)->where('year', $year)->where('status', '!=', 0)->get();
        $month = Income::where('client_id', Auth::guard('admin')->user()->id)->where('month', $months)->where('year', $year)->where('status', '!=', 0)->first();
        return view('admin.income.collection_voucher', compact('income', 'month'));
    }

    public function CollectionAll(Request $request)
    { // show collection 
        $isExist = Income::where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0)->where('client_id', Auth::guard('admin')->user()->id)->exists();
        if (!$isExist) {
            return redirect()->back()->with('message', 'Data Not Found');
        } else {
            $data = Income::where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0)->where('client_id', Auth::guard('admin')->user()->id)->get();
            $months = Income::where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0)->where('client_id', Auth::guard('admin')->user()->id)->first();

            return redirect()->back()->with(['data' => $data, 'months' => $months]);
        }
    }

    //show voucher page
    public function ExpenseIndex()
    {
        $months = Carbon::now()->month;
        $year = Carbon::now()->year;
        $exp = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $months)->where('year', $year)->groupBy('cat_id')->get();
        $month = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $months)->where('year', $year)->first();
        return view('admin.accounts.expense_voucher', compact('exp', 'month'));
    }

    // show collection 
    public function ExpenseAll(Request $request)
    {
        $isExist = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $request->month)->where('year', $request->year)->exists();
        if (!$isExist) {
            return redirect()->back()->with('message', 'Data Not Found');
        } else {
            $data = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $request->month)->where('year', $request->year)->groupBy('cat_id')->get();
            $months = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $request->month)->where('year', $request->year)->first();
            //    dd($month->month);
            // return view('admin.accounts.expense_voucher', compact('data', 'months'));
            return redirect()->back()->with(['data' => $data, 'months' => $months]);
        }
    }

    // BalanceSheet
    public function balanceSheetIndex()
    {
        return view('admin.accounts.balance_sheet');
    }

    public function balanceSheet($year, $month)
    {
        $month = $month;
        $year = $year;
        if ($month == date('m') && $year == date('Y')) {
            $expense = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->sum('amount');
            $income = Income::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->sum('paid');
            $others_income = OthersIncome::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->sum('amount');

            // $previousDate = explode('-', date('Y-m', strtotime($year . '-' . 01 . " -1 month")));
            // $year = $previousDate[0];
            // $month = $previousDate[1];

            $monthlyOB = Balance::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month-1)->where('year', $year)->first();

            if ($monthlyOB) {
                $income += $monthlyOB->amount;
            } else {
                $manualOpeningBalance = OpeningBalance::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->first();
                // dd($manualOpeningBalance);
                if($manualOpeningBalance){
                    $income += ($manualOpeningBalance->flag == 1 ? $manualOpeningBalance->profit : -$manualOpeningBalance->loss);
                }
            }
            $income += $others_income;
        } else {
            // dd($month);
            $data = Balance::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->first();
            $income = isset($data) ? $data->total_income : 0;
            $expense = isset($data) ? $data->total_expense : 0;
        }

        $data['income'] = $income;
        $data['expense'] = $expense; 
        $data['balance'] = $data['income'] - $data['expense'];
        $data['flag'] = $data['balance'] >= 0 ? 'Profit' : 'Loss';
        return response()->json($data, 200);
    }

    // Expense rreport 
    public function Incomes()
    {
        $data = Income::where('client_id', Auth::guard('admin')->user()->id)->orderBy('month', 'DESC')->get();
        return view('admin.accounts.incomes', compact('data'));
    }

}
