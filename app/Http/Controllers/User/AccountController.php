<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerDetail;
use App\Models\Exp_detail;
use App\Models\Exp_process;
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
        $expense = Exp_detail::where('customer_id', $user->customer_id)->where('month', $month)->where('year', $year)->groupBy('cat_id')->get();
        return view('user.accounts.ladger_account', compact('expense'));
    }

    public function store()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $isExist = Exp_process::where('customer_id', $user->customer_id)->where('month', $month)->where('year', $year)->exists();
        if ($isExist) {
            return redirect()->back()->with('message', 'You have already submitted');
        } else {
            $expenses = Exp_detail::where('customer_id', $user->customer_id)->where('month', $month)->where('year', $year)->groupBy('month')->get();
            foreach ($expenses as $expense) {
                $data['year'] = $expense->year;
                $data['month'] = $expense->month;
                $data['total'] = Exp_detail::where('customer_id', $user->customer_id)->where('month', $expense->month)->where('year', $expense->year)->SUM('amount');
                $data['customer_id'] = $expense->customer_id;
                $data['auth_id'] = $expense->auth_id;
                $data['date'] = date('Y-m');
                $exp_process = Exp_process::create($data);
            }

            if ($exp_process) {
                $month_exp = Exp_process::where('customer_id', $user->customer_id)->where('month', $month)->where('year', $year)->first();
                // total income of this month
                $income = DB::table('incomes')
                    ->where('month', $month)
                    ->where('year', $year)
                    ->where('customer_id', $user->customer_id)
                    ->SUM('paid');

                // oprning blance
                // $previousDate = explode('-', date('Y-m', strtotime(date('Y-m') . ' -1 month')));

                $openingBlance = DB::table('monthly_blances')
                    ->where('month', $month - 1)
                    ->where('year', $year)
                    ->where('customer_id', $user->customer_id)
                    ->first();

                // oprning blance 
                $manualOpeningBlance = DB::table('opening_balances')
                    ->where('month', $month)
                    ->where('year', $year)
                    ->where('customer_id', $user->customer_id)
                    ->first();

                $others_income = DB::table('others_incomes')
                    ->where('month', $month)
                    ->where('year', $year)
                    ->where('customer_id', $user->customer_id)
                    ->sum('amount');

                if (!$openingBlance && !$manualOpeningBlance) {
                    $balance = $income + $others_income - $month_exp->total;

                    $data['year'] = $year;
                    $data['month'] = $month;
                    $data['total_income'] = $income + $others_income;
                    $data['total_expense'] = $month_exp->total;
                    $data['amount'] = $balance;
                    $data['customer_id'] = $month_exp->customer_id;
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
                        $data['customer_id'] = $month_exp->customer_id;
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
                        $data['customer_id'] = $month_exp->customer_id;
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
                        $data['customer_id'] = $month_exp->customer_id;
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
                        $data['customer_id'] = $month_exp->customer_id;
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
        }
    }

    public function IndexCollection()
    {   //show voucher page
        return view('user.income.collection_voucher');
    }

    public function CollectionAll(Request $request)
    { // show collection 
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $isExist = Income::where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0)->where('customer_id', $user->customer_id)->exists();
        if (!$isExist) {
            return redirect()->back()->with('message', 'Data Not Found');
        } else {
            $data = Income::where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0)->where('customer_id', $user->customer_id)->get();
            $months = Income::where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0)->where('customer_id', $user->customer_id)->first();

            return redirect()->back()->with(['data' => $data, 'months' => $months]);
        }
    }

     //show voucher page
     public function ExpenseIndex()
     {
         $months = Carbon::now()->month;
         $year = Carbon::now()->year;
         $user = User::where('user_id', Auth::user()->user_id)->first();
         $exp = Exp_detail::where('customer_id', $user->customer_id)->where('month', $months)->where('year', $year)->groupBy('cat_id')->get();
         $month = Exp_detail::where('customer_id', $user->customer_id)->where('month', $months)->where('year', $year)->first();
         return view('user.accounts.expense_voucher', compact('exp', 'month'));
     }

     // show collection 
    public function ExpenseAll(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $isExist = Exp_detail::where('customer_id', $user->customer_id)->where('month', $request->month)->where('year', $request->year)->exists();
        if (!$isExist) {
            return redirect()->back()->with('message', 'Data Not Found');
        } else {
            $data = Exp_detail::where('customer_id', $user->customer_id)->where('month', $request->month)->where('year', $request->year)->groupBy('cat_id')->get();
            $months = Exp_detail::where('customer_id', $user->customer_id)->where('month', $request->month)->where('year', $request->year)->first();
            //    dd($month->month);
            // return view('admin.accounts.expense_voucher', compact('data', 'months'));
            return redirect()->back()->with(['data' => $data, 'months' => $months]);
        }
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
             $expense = Exp_detail::where('customer_id', $user->customer_id)->where('month', $month)->where('year', $year)->sum('amount');
             $income = Income::where('customer_id', $user->customer_id)->where('month', $month)->where('year', $year)->sum('paid');
             $others_income = OthersIncome::where('customer_id', $user->customer_id)->where('month', $month)->where('year', $year)->sum('amount');
 
             // $previousDate = explode('-', date('Y-m', strtotime($year . '-' . 01 . " -1 month")));
             // $year = $previousDate[0];
             // $month = $previousDate[1];
 
             $monthlyOB = MonthlyBlance::where('customer_id', $user->customer_id)->where('month', $month-1)->where('year', $year)->first();
             if ($monthlyOB) {
                 $income += $monthlyOB->amount;
             } else {
                 $manualOpeningBalance = OpeningBalance::where('customer_id', $user->customer_id)->where('month', $month)->where('year', $year)->first();
                 if($manualOpeningBalance){
                     $income += ($manualOpeningBalance->flag == 1 ? $manualOpeningBalance->profit : -$manualOpeningBalance->loss);
                 }
                }
                $income += $others_income;
         } else {
             // dd($month);
             $data = MonthlyBlance::where('customer_id', $user->customer_id)->where('month', $month)->where('year', $year)->first();
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
        $data = Income::where('customer_id', $user->customer_id)->orderBy('month', 'DESC')->get();
        return view('user.accounts.incomes', compact('data'));
    }

     // Account Expense generate all voucher 
     public function GenerateExpenseVoucherAll(Request $request)
     {
        $user = User::where('user_id', Auth::user()->user_id)->first();
         $inv = Exp_detail::where('customer_id', $user->customer_id)->where('month', $request->month)->where('year', $request->year)->groupBy('cat_id')->get();
         $total = Exp_detail::where('customer_id', $user->customer_id)->where('month', $request->month)->where('year', $request->year)->sum('amount');
         $month = Exp_detail::where('customer_id', $user->customer_id)->where('month', $request->month)->where('year', $request->year)->first();
        
 
         $customer = Customer::where('id', $user->customer_id)->first();
         $custDetails = CustomerDetail::where('customer_id', $customer->id)->first();
 
         $data = [
             'inv' => $inv,
             'total' => $total,
             'month' => $month,
             'customer' => $customer,
             'custDetails' => $custDetails,
         ];
         $pdf = PDF::loadView('user.accounts.exp_voucher_all', $data);
         return $pdf->stream('sdl_exp.pdf');
     }


      // Logout method ends here
    public function AdminLogout()
    {
        Auth::logout();
        return redirect()->route('user.login_form')->with('message', 'Manager Logout Successfully');
        //end method
    }

}
