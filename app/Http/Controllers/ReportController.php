<?php

namespace App\Http\Controllers;

use App\Models\Exp_detail;
use App\Models\Expense;
use App\Models\Income;
use App\Models\MonthlyBlance;
use App\Models\OpeningBalance;
use App\Models\OthersIncome;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    // Report for Monthly Ecpense
    public function MonthlyExpense(Request $request)
    {
        $months = Carbon::now()->month;
        $year = Carbon::now()->year;
        $monthly_exp = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('month', $months)->where('year', $year)->groupBy('cat_id')->get();
        $month = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('month', $months)->where('year', $year)->first();
        return view('admin.report.monthly_expenses', compact('monthly_exp', 'month'));
    }

    // Report for Monthly Ecpense
    public function MonthlyAllExpense(Request $request)
    {
        $isExist = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('month', $request->month)->where('year', $request->year)->exists();
        if (!$isExist) {
            return redirect()->back()->with('message', 'No Expense Available of This Month');
        } else {
            $monthly_expense = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('month', $request->month)->where('year', $request->year)->groupBy('cat_id')->get();
            $months = Exp_detail::where('month', $request->month)->where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->first();

            return redirect()->back()->with(['monthly_expense' => $monthly_expense, 'months' => $months]);
            // return view('admin.report.monthly_expenses', compact('monthly_expense','months'));
        }
    }

    // Report for yearly Ecpense
    public function YearlyExpense()
    {
        $year = Carbon::now()->year;
        $yearly_exp = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('year', $year)->groupBy('cat_id')->get();
        $years = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('year', $year)->first();
        return view('admin.report.yearly_expenses', compact('yearly_exp', 'years'));
    }

    // Report for yearly Ecpense
    public function YearlyAllExpense(Request $request)
    {
        $isExist = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('year', $request->year)->exists();
        if (!$isExist) {
            return redirect()->back()->with('message', 'No Expense Available of This year');
        } else {
            $yearly_expense = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('year', $request->year)->groupBy('cat_id')->get();
            $year = Exp_detail::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->first();

            return redirect()->back()->with(['yearly_expense' => $yearly_expense, 'year' => $year]);
        }
    }

    // Report for Monthly income
    public function MonthlyIncome()
    {
        $months = Carbon::now()->month;
        $year = Carbon::now()->year;
        $m_income = Income::where('month', $months)->where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->sum('paid');
        $month = Income::where('month', $months)->where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->first();
        $m_opening_balance = OpeningBalance::where('month', $months)->where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->first();
        $m_other_income = OthersIncome::where('month', $months)->where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->get();

        return view('admin.report.monthly_incomes', compact('m_income', 'month', 'm_opening_balance', 'm_other_income'));
    }

    public function MonthlyAllIncome(Request $request)
    {
        $isExist = Income::where('client_id', Auth::guard('admin')->user()->id)->where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0 )->exists();
        if (!$isExist) {
            return redirect()->back()->with('message', 'No Income Available of This Month');
        } else {
            $monthly_income = Income::where('month', $request->month)->where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->sum('paid');
            $months = Income::where('month', $request->month)->where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->first();
            $opening_balance = OpeningBalance::where('month', $request->month)->where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->first();
            $others_income = OthersIncome::where('month', $request->month)->where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->get();
            return redirect()->back()->with(['monthly_income' => $monthly_income, 'months' => $months, 'others_income' => $others_income, 'opening_balance' => $opening_balance]);
        }
    }
    // Report for Monthly income

    // Report for yearly income
    public function YearlyIncome()
    {

        $months = Carbon::now()->month;
        $year = Carbon::now()->year;
        $y_income = Income::where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->sum('paid');
        $years = Income::where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->first();
        $y_opening_balance = OpeningBalance::where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->first();
        $y_other_income = OthersIncome::where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->get();

        return view('admin.report.yearly_incomes', compact('y_income', 'years', 'y_opening_balance', 'y_other_income'));
    }

    public function YearlyAllIncome(Request $request)
    {
        $isExist = Income::where('year', $request->year)->where('status', '!=', 0)->where('client_id', Auth::guard('admin')->user()->id)->exists();
        if (!$isExist) {
            return redirect()->back()->with('message', 'No Income Available of This Year');
        } else {
            $yearly_income = Income::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->sum('paid');
            $year = Income::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->first();
            $opening_balance = OpeningBalance::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->first();
            $others_income = OthersIncome::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->get();
            // dd($months);
            return redirect()->back()->with(['yearly_income' => $yearly_income, 'opening_balance' => $opening_balance, 'year' => $year, 'others_income' => $others_income]);
        }
    }
    // Report for yearly income
}
