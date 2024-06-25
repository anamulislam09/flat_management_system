<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Expense;
use App\Models\Income;
use App\Models\OpeningBalance;
use App\Models\OthersIncome;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Display the form and current month data
    public function MonthlyExpense(Request $request)
    {
        $months = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $monthly_exp = Expense::where('client_id', $user->client_id)
            ->where('month', $months)
            ->where('year', $year)
            ->groupBy('cat_id')
            ->get();
        $month = Expense::where('client_id', $user->client_id)
            ->where('month', $months)
            ->where('year', $year)
            ->first();

        return view('user.report.monthly_expenses', compact('monthly_exp', 'month', 'months', 'year'));
    }

    // Handle form submission for filtering
    public function MonthlyAllExpense(Request $request)
    {
        $months = $request->input('month');
        $year = $request->input('year');
        return redirect()->route('manager.expenses.month', ['month' => $months, 'year' => $year]);
    }

    // Display current year data by default
    public function YearlyExpense()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $currentYear = Carbon::now()->year;
        $yearly_expense = Expense::where('client_id', $user->client_id)
            ->where('year', $currentYear)
            ->groupBy('cat_id')
            ->get();
        $years = Expense::where('client_id', $user->client_id)
            ->where('year', $currentYear)
            ->first();

        return view('user.report.yearly_expenses', compact('yearly_expense', 'years', 'currentYear'));
    }

    // Handle filtering by year
    public function YearlyAllExpense(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $yearly_expense = Expense::where('client_id', $user->client_id)
            ->where('year', $request->year)
            ->groupBy('cat_id')
            ->get();

        $year = Expense::where('year', $request->year)
            ->where('client_id', $user->client_id)
            ->first();

        return redirect()->route('manager.expenses.year')->with(['yearly_expense' => $yearly_expense, 'years' => $year, 'currentYear' => $request->year]);
    }

    // Report for Monthly income
    public function MonthlyIncome(Request $request)
    {
        $months = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $m_income = Income::where('month', $months)
            ->where('year', $year)
            ->where('client_id', $user->client_id)
            ->sum('paid');
        $month = Income::where('month', $months)
            ->where('year', $year)
            ->where('client_id', $user->client_id)
            ->first();
        $m_opening_balance = OpeningBalance::where('month', $months)
            ->where('year', $year)
            ->where('client_id', $user->client_id)
            ->first();
        $m_other_income = OthersIncome::where('month', $months)
            ->where('year', $year)
            ->where('client_id', $user->client_id)
            ->get();

        return view('user.report.monthly_incomes', compact('m_income', 'month', 'm_opening_balance', 'm_other_income', 'months', 'year'));
    }

    public function MonthlyAllIncome(Request $request)
    {
        $months = $request->input('month');
        $year = $request->input('year');

        return redirect()->route('manager.incomes.month', ['month' => $months, 'year' => $year]);
    }

    public function handleMonthlyIncome(Request $request)
    {
        $months = $request->input('month');
        $year = $request->input('year');

        return redirect()->route('incomes.month', ['month' => $months, 'year' => $year]);
    }


    // // Report for yearly income
    // public function YearlyIncome()
    // {
    //     $months = Carbon::now()->month;
    //     $year = Carbon::now()->year;
    //     $user = User::where('user_id', Auth::user()->user_id)->first();
    //     $y_income = Income::where('year', $year)->where('client_id', $user->client_id)->sum('paid');
    //     $years = Income::where('year', $year)->where('client_id', $user->client_id)->first();
    //     $y_opening_balance = OpeningBalance::where('year', $year)->where('client_id', $user->client_id)->first();
    //     $y_other_income = OthersIncome::where('year', $year)->where('client_id', $user->client_id)->get();

    //     return view('user.report.yearly_incomes', compact('y_income', 'years', 'y_opening_balance', 'y_other_income'));
    // }

    // public function YearlyAllIncome(Request $request)
    // {
    //     $user = User::where('user_id', Auth::user()->user_id)->first();
    //     $isExist = Income::where('year', $request->year)->where('status', '!=', 0)->where('client_id', $user->client_id)->exists();
    //     if (!$isExist) {
    //         return redirect()->back()->with('message', 'No Income Available of This Year');
    //     } else {
    //         $yearly_income = Income::where('year', $request->year)->where('client_id', $user->client_id)->sum('paid');
    //         $year = Income::where('year', $request->year)->where('client_id', $user->client_id)->first();
    //         $opening_balance = OpeningBalance::where('year', $request->year)->where('client_id', $user->client_id)->first();
    //         $others_income = OthersIncome::where('year', $request->year)->where('client_id', $user->client_id)->get();
    //         // dd($months);
    //         return redirect()->back()->with(['yearly_income' => $yearly_income, 'opening_balance' => $opening_balance, 'year' => $year, 'others_income' => $others_income]);
    //     }
    // }
    // // Report for yearly income
    // public function YearlyIncome()
    // {
    //     $months = Carbon::now()->month;
    //     $year = Carbon::now()->year;
    //     $user = User::where('user_id', Auth::user()->user_id)->first();
    //     $y_income = Income::where('year', $year)->where('client_id', $user->client_id)->sum('paid');
    //     $years = Income::where('year', $year)->where('client_id', $user->client_id)->first();
    //     $y_opening_balance = OpeningBalance::where('year', $year)->where('client_id', $user->client_id)->first();
    //     $y_other_income = OthersIncome::where('year', $year)->where('client_id', $user->client_id)->get();

    //     return view('user.report.yearly_incomes', compact('y_income', 'years', 'y_opening_balance', 'y_other_income'));
    // }

    // public function YearlyAllIncome(Request $request)
    // {
    //     $user = User::where('user_id', Auth::user()->user_id)->first();
    //     $isExist = Income::where('year', $request->year)->where('status', '!=', 0)->where('client_id', $user->client_id)->exists();
    //     if (!$isExist) {
    //         return redirect()->back()->with('message', 'No Income Available of This Year');
    //     } else {
    //         $yearly_income = Income::where('year', $request->year)->where('client_id', $user->client_id)->sum('paid');
    //         $year = Income::where('year', $request->year)->where('client_id', $user->client_id)->first();
    //         $opening_balance = OpeningBalance::where('year', $request->year)->where('client_id', $user->client_id)->first();
    //         $others_income = OthersIncome::where('year', $request->year)->where('client_id', $user->client_id)->get();
    //         // dd($months);
    //         return redirect()->back()->with(['yearly_income' => $yearly_income, 'opening_balance' => $opening_balance, 'year' => $year, 'others_income' => $others_income]);
    //     }
    // }


        // Display current year data by default
public function YearlyIncome()
{
    $currentYear = Carbon::now()->year;
    $user = User::where('user_id', Auth::user()->user_id)->first();
    $y_income = Income::where('year', $currentYear)->where('client_id', $user->client_id)->sum('paid');
    $years = Income::where('year', $currentYear)->where('client_id', $user->client_id)->first();
    $y_opening_balance = OpeningBalance::where('year', $currentYear)->where('client_id', $user->client_id)->first();
    $y_other_income = OthersIncome::where('year', $currentYear)->where('client_id', $user->client_id)->get();

    return view('user.report.yearly_incomes', compact('y_income', 'years', 'y_opening_balance', 'y_other_income', 'currentYear'));
}

// Handle filtering by year
public function YearlyAllIncome(Request $request)
{
    $user = User::where('user_id', Auth::user()->user_id)->first();
    $yearly_income = Income::where('year', $request->year)->where('client_id', $user->client_id)->sum('paid');
    $year = Income::where('year', $request->year)->where('client_id', $user->client_id)->first();
    $opening_balance = OpeningBalance::where('year', $request->year)->where('client_id', $user->client_id)->first();
    $others_income = OthersIncome::where('year', $request->year)->where('client_id', $user->client_id)->get();

    return redirect()->route('manager.incomes.year')->with(['yearly_income' => $yearly_income, 'opening_balance' => $opening_balance, 'year' => $year, 'others_income' => $others_income, 'currentYear' => $request->year]);
}


    // Report for yearly income

    public function BalanceSheet()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $data = Balance::where('client_id', $user->client_id)->get();
        return view('user.report.balanceSheet', compact('data'));
    }
}
