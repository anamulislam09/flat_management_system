<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Exp_process;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class LadgerController extends Controller
{
    public function Index()
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $expense = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->groupBy('cat_id')->get();
        return view('admin.accounts.ladger_account', compact('expense'));
    }

    public function store()
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $clientId = Auth::guard('admin')->user()->id;

        if (Exp_process::where('client_id', $clientId)->where('month', $month)->where('year', $year)->exists()) {
            return redirect()->back()->with('message', 'You have already submitted');
        }

        $expenses = Expense::where('client_id', $clientId)->where('month', $month)->where('year', $year)->groupBy('month')->get();
        foreach ($expenses as $expense) {
            $data = [
                'year' => $expense->year,
                'month' => $expense->month,
                'total' => (float) Expense::where('client_id', $clientId)->where('month', $expense->month)->where('year', $expense->year)->sum('amount'),
                'client_id' => $expense->client_id,
                'auth_id' => $expense->auth_id,
            ];
            $exp_process = Exp_process::create($data);
        }

        if (!$exp_process) {
            return redirect()->back()->with('message', 'Something went wrong!');
        }

        $monthExp = Exp_process::where('client_id', $clientId)->where('month', $month)->where('year', $year)->first();
        $income = (float) DB::table('incomes')->where('month', $month)->where('year', $year)->where('client_id', $clientId)->sum('paid');
        $othersIncome = (float) DB::table('others_incomes')->where('month', $month)->where('year', $year)->where('client_id', $clientId)->sum('amount');

        $openingBalance = DB::table('balances')->where('month', $month - 1)->where('year', $year)->where('client_id', $clientId)->first();
        $manualOpeningBalance = DB::table('opening_balances')->where('month', $month)->where('year', $year)->where('client_id', $clientId)->first();

        if (!isset($manualOpeningBalance) && !isset($openingBalance)) {
            $totalIncome = $income + $othersIncome; 
            $totalExpense = $monthExp->total;
            $balance = $totalIncome - $totalExpense;
        } else {
            if ($manualOpeningBalance) {
                $openingAmount = (float) ($manualOpeningBalance->flag ==1 ? $manualOpeningBalance->amount : $manualOpeningBalance->amount);
                $flag = $manualOpeningBalance->flag;
            } else {
                $openingAmount = (float) ($openingBalance->amount ?? 0);
                $flag = $openingBalance->flag;
            }
            if ($flag == 1) {
                $totalIncome = $openingAmount + $income + $othersIncome;
                $totalExpense = $monthExp->total;
                $balance = $totalIncome - $totalExpense;
            } else {
                $totalIncome = $income + $othersIncome;
                $totalExpense = $monthExp->total + $openingAmount;
                $balance = $totalIncome - $totalExpense;
            }
        }

        $data = [
            'year' => $year,
            'month' => $month,
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'amount' => $balance,
            'client_id' => $monthExp->client_id,
            'auth_id' => $monthExp->auth_id,
            'date' => date('Y-m-d'),
            'flag' => $balance >= 0 ? 1 : 0,
        ];

        $balanceData = Balance::create($data);

        if ($balanceData) {
            return redirect()->back()->with('message', 'Ledger Posting successfully');
        } else {
            return redirect()->back()->with('message', 'Something went wrong!');
        }
    }
}
