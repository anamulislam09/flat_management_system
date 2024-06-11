<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Exp_detail;
use App\Models\Exp_process;
use App\Models\Income;
use App\Models\MonthlyBlance;
use App\Models\OpeningBalance;
use App\Models\User;
use App\Models\YearlyBlance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlanceController extends Controller
{
    // OpeningBalance
    public function OpeningBalance()
    {
        return view('admin.accounts.opening_balance');
    }

    // OpeningBalanceStore
    public function OpeningBalanceStore(Request $request)
    {
        // dd($request);
        $isExist = OpeningBalance::where('client_id', Auth::guard('admin')->user()->id)->exists();
        if ($isExist) {
            return redirect()->back()->with('message', 'You have already created opening balance.');
        } else {
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
            $profit = abs($request->profit);
            $loss = abs($request->loss);

        //    if($request->has('profit') && $request->has('loss')){
        //     return redirect()->back()->with('message', 'Something went wrong.');
        //    }else{
        //     dd("done");
            $data['client_id'] = Auth::guard('admin')->user()->id;
            $data['auth_id'] = Auth::guard('admin')->user()->id;
            $data['year'] = $year;
            $data['month'] = $month;
            $data['profit'] = $profit;
            $data['loss'] = $loss;
            $data['entry_datetime'] = date('Y-m-d');

            if ($request->profit > 0) {
                $data['flag'] = 1;
            } else {
                $data['flag'] = 0;
            }
 
             OpeningBalance::create($data);
            return redirect()->back()->with('message', 'Opening Balance Added Successfully');
        //    }
        }
    }

    // Monthly blance 
    public function Monthly()
    {
        $data = MonthlyBlance::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.blances.month', compact('data'));
    }

    // yearly blance 
    public function Yearly()
    {
        $data = YearlyBlance::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.blances.year', compact('data'));
    }

    // Blance Sheet 
    public function BalanceSheet()
    {
        $data = MonthlyBlance::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.report.balanceSheet', compact('data'));
    }

}
