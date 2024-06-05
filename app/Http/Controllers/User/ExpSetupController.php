<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Addressbook;
use App\Models\Category;
use App\Models\ExpSetup;
use App\Models\SetupHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class ExpSetupController extends Controller
{
    public function ExpenseSetupIndex()
    {
        $expenses = Category::get();
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $vendor = Addressbook::where('customer_id', $user->customer_id)->get();
        $data = ExpSetup::where('customer_id', $user->customer_id)->get();
        return view('user.expense-setup.index', compact('expenses', 'data', 'vendor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function ExpenseSetupCreate(Request $request)
    {
        $date = Carbon::today();
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $datas['customer_id'] = $user->customer_id;
        $datas['auth_id'] = Auth::user()->user_id;
        $datas['exp_id'] = $request->exp_id;
        $datas['vendor_id'] = $request->vendor_id;
        $datas['start_date'] = date('Y-m-d');
        $datas['interval_days'] = abs($request->days);
        $datas['end_date'] = $date->addDays(abs($request->days))->toDateString();
        $setup = ExpSetup::create($datas);

        if ($setup) {
            $history = ExpSetup::where('customer_id', $user->customer_id)->latest()->first();
            $data['customer_id'] = $history->customer_id;
            $data['auth_id'] = $history->auth_id;
            $data['exp_id'] = $history->exp_id;
            $data['vendor_id'] = $history->vendor_id;
            $data['start_date'] = $history->start_date;
            $data['interval_days'] = abs($history->interval_days);
            $data['end_date'] = $history->end_date;
            SetupHistory::create($data);
        }
        return Response::json(true, 200);
    }

    public function ExpenseSetupEdit($id)
    {
        $expenses = Category::get();
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $vendor = Addressbook::where('customer_id', $user->customer_id)->get();
        $exp = ExpSetup::where('customer_id', $user->customer_id)->where('id', $id)->first();
        return view('user.expense-setup.edit', compact('expenses', 'exp', 'vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function ExpenseSetupUpdate(Request $request)
    {
        $id = $request->id;
        $date = Carbon::today();
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $exp = ExpSetup::where('customer_id', $user->customer_id)->where('id', $id)->first();

        $exp['start_date'] = date('Y-m-d');
        $exp['vendor_id'] = $request->vendor_id;
        $exp['interval_days'] = abs($request->days);
        $exp['end_date'] = $date->addDays(abs($request->days))->toDateString();
        $setup = $exp->save();
        if ($setup) {
            // $history = ExpSetup::where('customer_id', $user->customer_id)->latest()->first();
            // dd($history);
            $data['customer_id'] = $user->customer_id;
            $data['auth_id'] = Auth::user()->user_id;
            $data['exp_id'] = $request->exp_id;
            $data['vendor_id'] = $request->vendor_id;
            $data['start_date'] = date('Y-m-d');
            $data['interval_days'] = abs($request->days);
            $data['end_date'] = $date->addDays(abs($request->days))->toDateString();
            SetupHistory::create($data);
        }
        return redirect()->route('manager.expense.setup')->with('message', 'Schedule Setup Updated successfully');
    }

    public function ExpenseSetupHistory(){
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $exp = Category::get();
        return view('user.expense-setup.setup_history', compact('user', 'exp'));
    }

    public function ExpenseSetupHistoryAll($exp_id)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $data['history'] = SetupHistory::where('customer_id', $user->customer_id)
            ->where('exp_id', $exp_id)->get();
        foreach ($data['history'] as $key => $history) {
            $data['history'][$key]->name = Category::where('id', $history->exp_id)->first()->name;
            $data['history'][$key]->vName = Addressbook::where('customer_id', $user->customer_id)->where('id', $history->vendor_id)->first()->name;
        }
        return response()->json($data, 200);
    }
}
