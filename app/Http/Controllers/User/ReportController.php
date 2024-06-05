<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Exp_detail;
use App\Models\Income;
use App\Models\MonthlyBlance;
use App\Models\OpeningBalance;
use App\Models\OthersIncome;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
     // Report for Monthly Ecpense
     public function MonthlyExpense(Request $request)
     {
        $user = User::where('user_id', Auth::user()->user_id)->first();
         $months = Carbon::now()->month;
         $year = Carbon::now()->year;
         $monthly_exp = Exp_detail::where('customer_id', $user->customer_id)->where('month', $months)->where('year', $year)->groupBy('cat_id')->get();
         $month = Exp_detail::where('customer_id', $user->customer_id)->where('month', $months)->where('year', $year)->first();
         return view('user.report.monthly_expenses', compact('monthly_exp', 'month'));
     }
 
     // Report for Monthly Ecpense
     public function MonthlyAllExpense(Request $request)
     {
        $user = User::where('user_id', Auth::user()->user_id)->first();
         $isExist = Exp_detail::where('customer_id', $user->customer_id)->where('month', $request->month)->where('year', $request->year)->exists();
         if (!$isExist) {
             return redirect()->back()->with('message', 'Data Not Found');
         } else {
             $monthly_expense = Exp_detail::where('customer_id', $user->customer_id)->where('month', $request->month)->where('year', $request->year)->groupBy('cat_id')->get();
             $months = Exp_detail::where('month', $request->month)->where('year', $request->year)->where('customer_id', $user->customer_id)->first();
 
             return redirect()->back()->with(['monthly_expense' => $monthly_expense, 'months' => $months]);
             // return view('admin.report.monthly_expenses', compact('monthly_expense','months'));
         }
     }
 
     // Report for yearly Ecpense
     public function YearlyExpense()
     {
        $user = User::where('user_id', Auth::user()->user_id)->first();
         $year = Carbon::now()->year;
         $yearly_exp = Exp_detail::where('customer_id', $user->customer_id)->where('year', $year)->groupBy('cat_id')->get();
         $years = Exp_detail::where('customer_id', $user->customer_id)->where('year', $year)->first();
         return view('user.report.yearly_expenses', compact('yearly_exp', 'years'));
     }
 
     // Report for yearly Ecpense
     public function YearlyAllExpense(Request $request)
     {
        $user = User::where('user_id', Auth::user()->user_id)->first();
         $isExist = Exp_detail::where('customer_id', $user->customer_id)->where('year', $request->year)->exists();
         if (!$isExist) {
             return redirect()->back()->with('message', 'Data Not Found');
         } else {
             $yearly_expense = Exp_detail::where('customer_id', $user->customer_id)->where('year', $request->year)->groupBy('cat_id')->get();
             $year = Exp_detail::where('year', $request->year)->where('customer_id', $user->customer_id)->first();
 
             return redirect()->back()->with(['yearly_expense' => $yearly_expense, 'year' => $year]);
         }
     }
 
     // Report for Monthly income
     public function MonthlyIncome()
     {
        $months = Carbon::now()->month;
        $year = Carbon::now()->year;
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $m_income = Income::where('month', $months)->where('year', $year)->where('customer_id', $user->customer_id)->sum('paid');
        $month = Income::where('month', $months)->where('year', $year)->where('customer_id', $user->customer_id)->first();
        $m_opening_balance = OpeningBalance::where('month', $months)->where('year', $year)->where('customer_id', $user->customer_id)->first();
        $m_other_income = OthersIncome::where('month', $months)->where('year', $year)->where('customer_id', $user->customer_id)->get();

         return view('user.report.monthly_incomes', compact('m_income', 'month', 'm_opening_balance', 'm_other_income'));
     }
 
     public function MonthlyAllIncome(Request $request)
     {
        $user = User::where('user_id', Auth::user()->user_id)->first();
         $isExist = Income::where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0)->where('customer_id', $user->customer_id)->exists();
         if (!$isExist) {
             return redirect()->back()->with('message', 'No Income Available of This Year');
         } else {
             $monthly_income = Income::where('month', $request->month)->where('year', $request->year)->where('customer_id', $user->customer_id)->sum('paid');
             $months = Income::where('month', $request->month)->where('year', $request->year)->where('customer_id', $user->customer_id)->first();
             $opening_balance = OpeningBalance::where('year', $request->year)->where('customer_id', $user->customer_id)->first();
             $others_income = OthersIncome::where('month', $request->month)->where('year', $request->year)->where('customer_id', $user->customer_id)->get();
             // dd($opening_balance);
             return redirect()->back()->with(['monthly_income' => $monthly_income, 'months' => $months, 'others_income' => $others_income, 'opening_balance' => $opening_balance]);
         }
     }
     // Report for Monthly income
 
     // Report for yearly income
     public function YearlyIncome()
     {
        $months = Carbon::now()->month;
        $year = Carbon::now()->year;
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $y_income = Income::where('year', $year)->where('customer_id', $user->customer_id)->sum('paid');
        $years = Income::where('year', $year)->where('customer_id', $user->customer_id)->first();
        $y_opening_balance = OpeningBalance::where('year', $year)->where('customer_id', $user->customer_id)->first();
        $y_other_income = OthersIncome::where('year', $year)->where('customer_id', $user->customer_id)->get();

         return view('user.report.yearly_incomes', compact('y_income', 'years', 'y_opening_balance', 'y_other_income'));
     }
 
     public function YearlyAllIncome(Request $request)
     {
        $user = User::where('user_id', Auth::user()->user_id)->first();
         $isExist = Income::where('year', $request->year)->where('status', '!=', 0)->where('customer_id', $user->customer_id)->exists();
         if (!$isExist) {
             return redirect()->back()->with('message', 'No Income Available of This Year');
         } else {
             $yearly_income = Income::where('year', $request->year)->where('customer_id', $user->customer_id)->sum('paid');
             $year = Income::where('year', $request->year)->where('customer_id', $user->customer_id)->first();
             $opening_balance = OpeningBalance::where('year', $request->year)->where('customer_id', $user->customer_id)->first();
             $others_income = OthersIncome::where('year', $request->year)->where('customer_id', $user->customer_id)->get();
             // dd($months);
             return redirect()->back()->with(['yearly_income' => $yearly_income, 'opening_balance' => $opening_balance, 'year' => $year, 'others_income' => $others_income]);
         }
     }
     // Report for yearly income

     public function BalanceSheet()
     {
         $user = User::where('user_id', Auth::user()->user_id)->first();
         $data = MonthlyBlance::where('customer_id', $user->customer_id)->get();
         return view('user.report.balanceSheet', compact('data'));
     }
}
