<?php

namespace App\Http\Controllers;

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
    // Display the form and current month data
    public function MonthlyExpense(Request $request)
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

    // Handle form submission for filtering
    public function MonthlyAllExpense(Request $request)
    {
        $months = $request->input('month');
        $year = $request->input('year');
        return redirect()->route('expenses.month', ['month' => $months, 'year' => $year]);
    }


// Display current year data by default
public function YearlyExpense()
{
    $currentYear = Carbon::now()->year;
    $yearly_expense = Expense::where('client_id', Auth::guard('admin')->user()->id)
                             ->where('year', $currentYear)
                             ->groupBy('cat_id')
                             ->get();
    $years = Expense::where('client_id', Auth::guard('admin')->user()->id)
                    ->where('year', $currentYear)
                    ->first();

    return view('admin.report.yearly_expenses', compact('yearly_expense', 'years', 'currentYear'));
}

// Handle filtering by year
public function YearlyAllExpense(Request $request)
{
    $yearly_expense = Expense::where('client_id', Auth::guard('admin')->user()->id)
                             ->where('year', $request->year)
                             ->groupBy('cat_id')
                             ->get();

    $year = Expense::where('year', $request->year)
                   ->where('client_id', Auth::guard('admin')->user()->id)
                   ->first();

    return redirect()->route('expenses.year')->with(['yearly_expense' => $yearly_expense, 'years' => $year, 'currentYear' => $request->year]);
}

    public function showMonthlyIncome(Request $request)
    {
        $months = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $clientId = Auth::guard('admin')->user()->id;

        $m_income = Income::where('month', $months)
            ->where('year', $year)
            ->where('client_id', $clientId)
            ->sum('paid');
        $month = Income::where('month', $months)
            ->where('year', $year)
            ->where('client_id', $clientId)
            ->first();
        $m_opening_balance = OpeningBalance::where('month', $months)
            ->where('year', $year)
            ->where('client_id', $clientId)
            ->first();
        $m_other_income = OthersIncome::where('month', $months)
            ->where('year', $year)
            ->where('client_id', $clientId)
            ->get();

        return view('admin.report.monthly_incomes', compact('m_income', 'month', 'm_opening_balance', 'm_other_income', 'months', 'year'));
    }

    public function handleMonthlyIncome(Request $request)
    {
        $months = $request->input('month');
        $year = $request->input('year');

        return redirect()->route('incomes.month', ['month' => $months, 'year' => $year]);
    }

    // Display current year data by default
public function YearlyIncome()
{
    $currentYear = Carbon::now()->year;
    $y_income = Income::where('year', $currentYear)->where('client_id', Auth::guard('admin')->user()->id)->sum('paid');
    $years = Income::where('year', $currentYear)->where('client_id', Auth::guard('admin')->user()->id)->first();
    $y_opening_balance = OpeningBalance::where('year', $currentYear)->where('client_id', Auth::guard('admin')->user()->id)->first();
    $y_other_income = OthersIncome::where('year', $currentYear)->where('client_id', Auth::guard('admin')->user()->id)->get();

    return view('admin.report.yearly_incomes', compact('y_income', 'years', 'y_opening_balance', 'y_other_income', 'currentYear'));
}

// Handle filtering by year
public function YearlyAllIncome(Request $request)
{
    $yearly_income = Income::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->sum('paid');
    $year = Income::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->first();
    $opening_balance = OpeningBalance::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->first();
    $others_income = OthersIncome::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->get();

    return redirect()->route('incomes.year')->with(['yearly_income' => $yearly_income, 'opening_balance' => $opening_balance, 'year' => $year, 'others_income' => $others_income, 'currentYear' => $request->year]);
}

    // Report for yearly income
}
