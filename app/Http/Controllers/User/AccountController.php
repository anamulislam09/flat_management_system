<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Client;
use App\Models\Customer;
use App\Models\CustomerDetail;
use App\Models\Exp_process;
use App\Models\Expense;
use App\Models\Income;
use App\Models\MonthlyBlance;
use App\Models\OpeningBalance;
use App\Models\OthersIncome;
use App\Models\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function Index()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $expense = Expense::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->groupBy('cat_id')->get();
        return view('user.accounts.ladger_account', compact('expense'));
    }

    // public function store()
    // {
    //     $user = User::where('user_id', Auth::user()->user_id)->first();

    //     $month = Carbon::now()->month;
    //     $year = Carbon::now()->year;
    //     $isExist = Exp_process::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->exists();
    //     if ($isExist) {
    //         return redirect()->back()->with('message', 'You have already submitted');
    //     } else {
    //         $expenses = Expense::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->groupBy('month')->get();
    //         foreach ($expenses as $expense) {
    //             $data['year'] = $expense->year;
    //             $data['month'] = $expense->month;
    //             $data['total'] = Expense::where('client_id', $user->client_id)->where('month', $expense->month)->where('year', $expense->year)->SUM('amount');
    //             $data['client_id'] = $expense->client_id;
    //             $data['auth_id'] = $expense->auth_id;
    //             $data['date'] = date('Y-m');
    //             $exp_process = Exp_process::create($data);
    //         }

    //         if ($exp_process) {
    //             $month_exp = Exp_process::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->first();
    //             // total income of this month
    //             $income = DB::table('incomes')
    //                 ->where('month', $month)
    //                 ->where('year', $year)
    //                 ->where('client_id', $user->client_id)
    //                 ->SUM('paid');

    //             // oprning blance
    //             // $previousDate = explode('-', date('Y-m', strtotime(date('Y-m') . ' -1 month')));

    //             $openingBlance = DB::table('monthly_blances')
    //                 ->where('month', $month - 1)
    //                 ->where('year', $year)
    //                 ->where('client_id', $user->client_id)
    //                 ->first();

    //             // oprning blance 
    //             $manualOpeningBlance = DB::table('opening_balances')
    //                 ->where('month', $month)
    //                 ->where('year', $year)
    //                 ->where('client_id', $user->client_id)
    //                 ->first();

    //             $others_income = DB::table('others_incomes')
    //                 ->where('month', $month)
    //                 ->where('year', $year)
    //                 ->where('client_id', $user->client_id)
    //                 ->sum('amount');

    //             if (!$openingBlance && !$manualOpeningBlance) {
    //                 $balance = $income + $others_income - $month_exp->total;

    //                 $data['year'] = $year;
    //                 $data['month'] = $month;
    //                 $data['total_income'] = $income + $others_income;
    //                 $data['total_expense'] = $month_exp->total;
    //                 $data['amount'] = $balance;
    //                 $data['client_id'] = $month_exp->client_id;
    //                 $data['auth_id'] = $month_exp->auth_id;
    //                 $data['date'] = date('Y-m');
    //                 if ($balance >= 0) {
    //                     $data['flag'] = 1;
    //                 } else {

    //                     $data['flag'] = 0;
    //                 }
    //                 $data = Balance::create($data);
    //                 if ($data) {
    //                     return redirect()->back()->with('message', 'Expense store successfully');
    //                 } else {
    //                     return redirect()->back()->with('message', 'Something went wrong!');
    //                 }
    //             } elseif (!$openingBlance && $manualOpeningBlance) {
    //                 if ($manualOpeningBlance->flag == 1) {
    //                     $balance = ($manualOpeningBlance->amount + $income + $others_income) - $month_exp->total;

    //                     $data['year'] = $year;
    //                     $data['month'] = $month;
    //                     $data['total_income'] = $manualOpeningBlance->amount + $income + $others_income;
    //                     $data['total_expense'] = $month_exp->total;
    //                     $data['amount'] = $balance;
    //                     $data['client_id'] = $month_exp->client_id;
    //                     $data['auth_id'] = $month_exp->auth_id;
    //                     $data['date'] = date('Y-m');
    //                     if ($balance >= 0) {
    //                         $data['flag'] = 1;
    //                     } else {

    //                         $data['flag'] = 0;
    //                     }
    //                     $data = Balance::create($data);
    //                     if ($data) {
    //                         return redirect()->back()->with('message', 'Expense store successfully');
    //                     } else {
    //                         return redirect()->back()->with('message', 'Something went wrong!');
    //                     }
    //                 } elseif ($manualOpeningBlance->flag == 0) {
    //                     $balance = ($income + $others_income - $manualOpeningBlance->amount) - $month_exp->total;

    //                     $data['year'] = $year;
    //                     $data['month'] = $month;
    //                     $data['total_income'] = $income + $others_income;
    //                     $data['total_expense'] = $month_exp->total + $manualOpeningBlance->amount;
    //                     $data['amount'] = $balance;
    //                     $data['client_id'] = $month_exp->client_id;
    //                     $data['auth_id'] = $month_exp->auth_id;
    //                     $data['date'] = date('Y-m');
    //                     if ($balance >= 0) {
    //                         $data['flag'] = 1;
    //                     } else {

    //                         $data['flag'] = 0;
    //                     }
    //                     $data = Balance::create($data);
    //                     if ($data) {
    //                         return redirect()->back()->with('message', 'Expense store successfully');
    //                     } else {
    //                         return redirect()->back()->with('message', 'Something went wrong!');
    //                     }
    //                 }
    //             } else {
    //                 if ($openingBlance->flag == 1) {
    //                     $balance = ($openingBlance->amount + $income + $others_income) - $month_exp->total;

    //                     $data['year'] = $year;
    //                     $data['month'] = $month;
    //                     $data['total_income'] = $openingBlance->amount + $income + $others_income;
    //                     $data['total_expense'] = $month_exp->total;
    //                     $data['amount'] = $balance;
    //                     $data['client_id'] = $month_exp->client_id;
    //                     $data['auth_id'] = $month_exp->auth_id;
    //                     $data['date'] = date('Y-m');
    //                     if ($balance >= 0) {
    //                         $data['flag'] = 1;
    //                     } else {

    //                         $data['flag'] = 0;
    //                     }
    //                     $data = Balance::create($data);
    //                     if ($data) {
    //                         return redirect()->back()->with('message', 'Expense store successfully');
    //                     } else {
    //                         return redirect()->back()->with('message', 'Something went wrong!');
    //                     }
    //                 } elseif ($openingBlance->flag == 0) {
    //                     $balance = ($income + $others_income - $openingBlance->amount) - $month_exp->total;

    //                     $data['year'] = $year;
    //                     $data['month'] = $month;
    //                     $data['total_income'] = $income + $others_income;
    //                     $data['total_expense'] = $month_exp->total + $openingBlance->amount;
    //                     $data['amount'] = $balance;
    //                     $data['client_id'] = $month_exp->client_id;
    //                     $data['auth_id'] = $month_exp->auth_id;
    //                     $data['date'] = date('Y-m');
    //                     if ($balance >= 0) {
    //                         $data['flag'] = 1;
    //                     } else {
    //                         $data['flag'] = 0;
    //                     }
    //                     $data = Balance::create($data);
    //                     if ($data) {
    //                         return redirect()->back()->with('message', 'Expense store successfully');
    //                     } else {
    //                         return redirect()->back()->with('message', 'Something went wrong!');
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // }


    public function store()
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $isExistExp_process = Exp_process::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->exists();
        $isExistbalance = Balance::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->exists();

        if ($isExistExp_process || $isExistbalance) {
            return redirect()->back()->with('message', 'You have already submitted');
        }

        $expenses = Expense::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->groupBy('month')->get();
        foreach ($expenses as $expense) {
            $data = [
                'year' => $expense->year,
                'month' => $expense->month,
                'total' => (float) Expense::where('client_id', $user->client_id)->where('month', $expense->month)->where('year', $expense->year)->sum('amount'),
                'client_id' => $expense->client_id,
                'auth_id' => $expense->auth_id,
            ];
            Exp_process::create($data);
        }

        $monthExpTotal = (float) Expense::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->sum('amount');
        // $monthExp = Exp_process::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->first();
        $income = (float) DB::table('incomes')->where('month', $month)->where('year', $year)->where('client_id', $user->client_id)->sum('paid');
        $othersIncome = (float) DB::table('others_incomes')->where('month', $month)->where('year', $year)->where('client_id', $user->client_id)->sum('amount');

        $openingBalance = DB::table('balances')->where('month', $month - 1)->where('year', $year)->where('client_id', $user->client_id)->first();
        $manualOpeningBalance = DB::table('opening_balances')->where('month', $month)->where('year', $year)->where('client_id', $user->client_id)->first();

        if (!isset($manualOpeningBalance) && !isset($openingBalance)) {
            $totalIncome = $income + $othersIncome;
            $totalExpense = $monthExpTotal;
            $balance = $totalIncome - $totalExpense;
        } else {
            if ($manualOpeningBalance) {
                $openingAmount = (float) ($manualOpeningBalance->flag == 1 ? $manualOpeningBalance->amount : $manualOpeningBalance->amount);
                $flag = $manualOpeningBalance->flag;
            } else {
                $openingAmount = (float) ($openingBalance->amount ?? 0);
                $flag = $openingBalance->flag;
            }
            if ($flag == 1) {
                $totalIncome = $openingAmount + $income + $othersIncome;
                $totalExpense = $monthExpTotal;
                $balance = $totalIncome - $totalExpense;
            } else {
                $totalIncome = $income + $othersIncome;
                $totalExpense = $monthExpTotal + $openingAmount;
                $balance = $totalIncome - $totalExpense;
            }
        }

        $data = [
            'year' => $year,
            'month' => $month,
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'amount' => $balance,
            'client_id' => $user->client_id,
            'auth_id' => $user->client_id,
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

    public function IndexCollection()
    {   //show voucher page
        return view('user.income.collection_voucher');
    }

    public function CollectionAll(Request $request)
    { // show collection 
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $isExist = Income::where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0)->where('client_id', $user->client_id)->exists();
        if (!$isExist) {
            return redirect()->back()->with('message', 'Data Not Found');
        } else {
            $data = Income::where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0)->where('client_id', $user->client_id)->get();
            $months = Income::where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0)->where('client_id', $user->client_id)->first();

            return redirect()->back()->with(['data' => $data, 'months' => $months]);
        }
    }

    //  //show voucher page
    //  public function ExpenseIndex()
    //  {
    //      $months = Carbon::now()->month;
    //      $year = Carbon::now()->year;
    //      $user = User::where('user_id', Auth::user()->user_id)->first();
    //      $exp = Expense::where('client_id', $user->client_id)->where('month', $months)->where('year', $year)->groupBy('cat_id')->get();
    //      $month = Expense::where('client_id', $user->client_id)->where('month', $months)->where('year', $year)->first();
    //      return view('user.accounts.expense_voucher', compact('exp', 'month'));
    //  }

    //  // show collection 
    // public function ExpenseAll(Request $request)
    // {
    //     $user = User::where('user_id', Auth::user()->user_id)->first();
    //     $isExist = Expense::where('client_id', $user->client_id)->where('month', $request->month)->where('year', $request->year)->exists();
    //     if (!$isExist) {
    //         return redirect()->back()->with('message', 'Data Not Found');
    //     } else {
    //         $data = Expense::where('client_id', $user->client_id)->where('month', $request->month)->where('year', $request->year)->groupBy('cat_id')->get();
    //         $months = Expense::where('client_id', $user->client_id)->where('month', $request->month)->where('year', $request->year)->first();
    //         //    dd($month->month);
    //         // return view('admin.accounts.expense_voucher', compact('data', 'months'));
    //         return redirect()->back()->with(['data' => $data, 'months' => $months]);
    //     }
    // }

    // Show voucher page
    public function ExpenseIndex(Request $request)
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

        return view('user.accounts.expense_voucher', compact('monthly_exp', 'month', 'months', 'year'));
    }

    // Show filtered collection by year
    public function ExpenseAll(Request $request)
    {
        $months = $request->input('month');
        $year = $request->input('year');

        return redirect()->route('manager.account.expense.index', ['month' => $months, 'year' => $year]);
    }

    // BalanceSheet
    public function balanceSheetIndex()
    {
        return view('user.accounts.balance_sheet');
    }

    public function balanceSheet($year, $month)
    {
        $month = $month;
        $year = $year;
        $user = User::where('user_id', Auth::user()->user_id)->first();
        if ($month == date('m') && $year == date('Y')) {
            $expense = Expense::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->sum('amount');
            $income = Income::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->sum('paid');
            $others_income = OthersIncome::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->sum('amount');

            // $previousDate = explode('-', date('Y-m', strtotime($year . '-' . 01 . " -1 month")));
            // $year = $previousDate[0];
            // $month = $previousDate[1];

            $monthlyOB = Balance::where('client_id', $user->client_id)->where('month', $month - 1)->where('year', $year)->first();
            if ($monthlyOB) {
                $income += $monthlyOB->amount;
            } else {
                $manualOpeningBalance = OpeningBalance::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->first();
                if ($manualOpeningBalance) {
                    $income += ($manualOpeningBalance->flag == 1 ? $manualOpeningBalance->amount : -$manualOpeningBalance->amount);
                }
            }
            $income += $others_income;
        } else {
            // dd($month);
            $data = Balance::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->first();
            $income = isset($data) ? $data->total_income : 0;
            $expense = isset($data) ? $data->total_expense : 0;
        }

        $data['income'] = $income;
        $data['expense'] = $expense;
        $data['balance'] = $data['income'] - $data['expense'];
        $data['flag'] = $data['balance'] >= 0 ? 'Profit' : 'Loss';
        return response()->json($data, 200);
    }

    public function Incomes()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $data = Income::where('client_id', $user->client_id)->orderBy('month', 'DESC')->get();
        return view('user.accounts.incomes', compact('data'));
    }

    // Account Expense generate all voucher 
    public function GenerateExpenseVoucherAll(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $inv = Expense::where('client_id', $user->client_id)->where('month', $request->month)->where('year', $request->year)->groupBy('cat_id')->get();
        $total = Expense::where('client_id', $user->client_id)->where('month', $request->month)->where('year', $request->year)->sum('amount');
        $month = Expense::where('client_id', $user->client_id)->where('month', $request->month)->where('year', $request->year)->first();


        $Client = Client::where('id', $user->client_id)->first();

        $data = [
            'inv' => $inv,
            'total' => $total,
            'month' => $month,
            'client' => $Client,
        ];
        $pdf = PDF::loadView('user.accounts.exp_voucher_all', $data);
        return $pdf->stream('sdl_exp.pdf');
    }


    // Logout method ends here
    public function AdminLogout()
    {
        if (Auth::user()->role_id == 0) {
            Auth::logout();
            return redirect()->route('user.login_form')->with('message', 'User Logout Successfully');
        } else {
            Auth::logout();
            return redirect()->route('user.login_form')->with('message', 'Manager Logout Successfully');
        }
        //end method
    }
}
