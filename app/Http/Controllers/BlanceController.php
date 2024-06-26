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
            $amount = abs($request->amount);
            $data['client_id'] = Auth::guard('admin')->user()->id;
            $data['auth_id'] = Auth::guard('admin')->user()->id;
            $data['year'] = $year;
            $data['month'] = $month;
            $data['amount'] = $amount;
            $data['entry_datetime'] = date('Y-m-d');
            $data['flag'] = $request->flag;

            OpeningBalance::create($data);
            return redirect()->back()->with('message', 'Opening Balance Added Successfully');
            //    }
        }
    }
}
