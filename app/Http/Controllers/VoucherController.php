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
   // show current month data 
   public function Index(Request $request)
   {   $months = $request->input('month', Carbon::now()->month);
       $year = $request->input('year', Carbon::now()->year);
       $clientId = Auth::guard('admin')->user()->id;
   
       $income = Income::where('client_id', $clientId)
                       ->where('month', $months)
                       ->where('year', $year)
                       ->where('status', '!=', 0)
                       ->get();
   
       $month = Income::where('client_id', $clientId)
                       ->where('month', $months)
                       ->where('year', $year)
                       ->where('status', '!=', 0)
                       ->first();
   
       return view('admin.income.collection_voucher', compact('income', 'month', 'months', 'year'));
   }
   // show filter data 
   public function CollectionAll(Request $request)
   {
       $months = $request->input('month');
       $year = $request->input('year');
       return redirect()->route('income.collection.index', ['month' => $months, 'year' => $year]);
   }

    // Show voucher page
    public function ExpenseIndex(Request $request)
    {
        $months = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $clientId = Auth::guard('admin')->user()->id;

        $monthly_exp = Expense::where('client_id', $clientId)
            ->where('month', $months)
            ->where('year', $year)
            ->groupBy('cat_id')
            ->get();
        $month = Expense::where('client_id', $clientId)
            ->where('month', $months)
            ->where('year', $year)
            ->first();

        return view('admin.report.monthly_expenses', compact('monthly_exp', 'month', 'months', 'year'));
    }

    // Show filtered collection by year
    public function ExpenseAll(Request $request)
    {
        $months = $request->input('month');
        $year = $request->input('year');
        $clientId = Auth::guard('admin')->user()->id;

        return redirect()->route('account.expense.index', ['month' => $months, 'year' => $year]);
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

            $monthlyOB = Balance::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month - 1)->where('year', $year)->first();

            if ($monthlyOB) {
                $income += $monthlyOB->amount;
            } else {
                $manualOpeningBalance = OpeningBalance::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->first();
                // dd($manualOpeningBalance);
                if ($manualOpeningBalance) {
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
