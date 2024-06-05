<?php

namespace App\Http\Controllers;

use App\Models\Exp_detail;
use App\Models\Exp_process;
use App\Models\Expense;
use App\Models\Income;
use App\Models\MonthlyBlance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Index()
    {
        $data = Exp_process::where('client_id', Auth::guard('admin')->user()->id)->orderBy('id', 'DESC')->get();
        return view('admin.expense.expense.exp_process', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store()
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $isExist = Exp_process::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->exists();
        if ($isExist) {
            return redirect()->back()->with('message', 'You have already submitted');
        } else {
            $expenses = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->groupBy('month')->get();
            foreach ($expenses as $expense) {
                $data['year'] = $expense->year;
                $data['month'] = $expense->month;
                $data['total'] = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('month', $expense->month)->where('year', $expense->year)->SUM('amount');
                $data['client_id'] = $expense->client_id;
                $data['auth_id'] = $expense->auth_id;
                $data['date'] = date('Y-m');
                $exp_process = Exp_process::create($data);
            }

            if ($exp_process) {
                $month_exp = Exp_process::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->first();
                // total income of this month
                $income = DB::table('incomes')
                    ->where('month', $month)
                    ->where('year', $year)
                    ->where('client_id', Auth::guard('admin')->user()->id)
                    ->SUM('paid');

                // oprning blance
                // $previousDate = explode('-', date('Y-m', strtotime(date('Y-m') . ' -1 month')));

                $openingBlance = DB::table('monthly_blances')
                    ->where('month', $month - 1)
                    ->where('year', $year)
                    ->where('client_id', Auth::guard('admin')->user()->id)
                    ->first();

                // oprning blance 
                $manualOpeningBlance = DB::table('opening_balances')
                    ->where('month', $month)
                    ->where('year', $year)
                    ->where('client_id', Auth::guard('admin')->user()->id)
                    ->first();

                $others_income = DB::table('others_incomes')
                    ->where('month', $month)
                    ->where('year', $year)
                    ->where('client_id', Auth::guard('admin')->user()->id)
                    ->sum('amount');

                if (!$openingBlance && !$manualOpeningBlance) {
                    $balance = $income + $others_income - $month_exp->total;

                    $data['year'] = $year;
                    $data['month'] = $month;
                    $data['total_income'] = $income + $others_income;
                    $data['total_expense'] = $month_exp->total;
                    $data['amount'] = $balance;
                    $data['client_id'] = $month_exp->client_id;
                    $data['auth_id'] = $month_exp->auth_id;
                    $data['date'] = date('Y-m');
                    if ($balance >= 0) {
                        $data['flag'] = 1;
                    } else {

                        $data['flag'] = 0;
                    }
                    $data = MonthlyBlance::create($data);
                    if ($data) {
                        return redirect()->back()->with('message', 'Expense store successfully');
                    } else {
                        return redirect()->back()->with('message', 'Something went wrong!');
                    }
                } elseif (!$openingBlance && $manualOpeningBlance) {
                    if ($manualOpeningBlance->flag == 1) {
                        $balance = ($manualOpeningBlance->profit + $income + $others_income) - $month_exp->total;

                        $data['year'] = $year;
                        $data['month'] = $month;
                        $data['total_income'] = $manualOpeningBlance->profit + $income + $others_income;
                        $data['total_expense'] = $month_exp->total;
                        $data['amount'] = $balance;
                        $data['client_id'] = $month_exp->client_id;
                        $data['auth_id'] = $month_exp->auth_id;
                        $data['date'] = date('Y-m');
                        if ($balance >= 0) {
                            $data['flag'] = 1;
                        } else {

                            $data['flag'] = 0;
                        }
                        $data = MonthlyBlance::create($data);
                        if ($data) {
                            return redirect()->back()->with('message', 'Expense store successfully');
                        } else {
                            return redirect()->back()->with('message', 'Something went wrong!');
                        }
                    } elseif ($manualOpeningBlance->flag == 0) {
                        $balance = ($income + $others_income - $manualOpeningBlance->loss) - $month_exp->total;

                        $data['year'] = $year;
                        $data['month'] = $month;
                        $data['total_income'] = $income + $others_income;
                        $data['total_expense'] = $month_exp->total + $manualOpeningBlance->loss;
                        $data['amount'] = $balance;
                        $data['client_id'] = $month_exp->client_id;
                        $data['auth_id'] = $month_exp->auth_id;
                        $data['date'] = date('Y-m');
                        if ($balance >= 0) {
                            $data['flag'] = 1;
                        } else {

                            $data['flag'] = 0;
                        }
                        $data = MonthlyBlance::create($data);
                        if ($data) {
                            return redirect()->back()->with('message', 'Expense store successfully');
                        } else {
                            return redirect()->back()->with('message', 'Something went wrong!');
                        }
                    }
                } else {
                    if ($openingBlance->flag == 1) {
                        $balance = ($openingBlance->amount + $income + $others_income) - $month_exp->total;

                        $data['year'] = $year;
                        $data['month'] = $month;
                        $data['total_income'] = $openingBlance->amount + $income + $others_income;
                        $data['total_expense'] = $month_exp->total;
                        $data['amount'] = $balance;
                        $data['client_id'] = $month_exp->client_id;
                        $data['auth_id'] = $month_exp->auth_id;
                        $data['date'] = date('Y-m');
                        if ($balance >= 0) {
                            $data['flag'] = 1;
                        } else {

                            $data['flag'] = 0;
                        }
                        $data = MonthlyBlance::create($data);
                        if ($data) {
                            return redirect()->back()->with('message', 'Expense store successfully');
                        } else {
                            return redirect()->back()->with('message', 'Something went wrong!');
                        }
                    } elseif ($openingBlance->flag == 0) {
                        $balance = ($income + $others_income - $openingBlance->amount) - $month_exp->total;

                        $data['year'] = $year;
                        $data['month'] = $month;
                        $data['total_income'] = $income + $others_income;
                        $data['total_expense'] = $month_exp->total + $openingBlance->amount;
                        $data['amount'] = $balance;
                        $data['client_id'] = $month_exp->client_id;
                        $data['auth_id'] = $month_exp->auth_id;
                        $data['date'] = date('Y-m');
                        if ($balance >= 0) {
                            $data['flag'] = 1;
                        } else {

                            $data['flag'] = 0;
                        }
                        $data = MonthlyBlance::create($data);
                        if ($data) {
                            return redirect()->back()->with('message', 'Expense store successfully');
                        } else {
                            return redirect()->back()->with('message', 'Something went wrong!');
                        }
                    }
                }
            }

            // if ($exp_process) {
            //     return redirect()->back()->with('message', 'Expense store successfully');
            // } else {
            //     return redirect()->back()->with('message', 'Something went wrong!');
            // }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Exp_process $exp_process)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exp_process $exp_process)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exp_process $exp_process)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exp_process $exp_process)
    {
        //
    }
}
