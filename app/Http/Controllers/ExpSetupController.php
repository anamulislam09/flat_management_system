<?php

namespace App\Http\Controllers;

use App\Models\Addressbook;
use App\Models\Category;
use App\Models\ExpSetup;
use App\Models\SetupHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Auth;
use Carbon\Carbon;
use DateTime;

class ExpSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function ExpenseSetupIndex()
    {
        $expenses = Category::get();
        $vendor = Addressbook::where('client_id', Auth::guard('admin')->user()->id)->get();
        $data = ExpSetup::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.expense.expense-setup.index', compact('expenses', 'data', 'vendor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function ExpenseSetupCreate(Request $request)
    {
        $date = Carbon::today();

        $datas['client_id'] = Auth::guard('admin')->user()->id;
        $datas['auth_id'] = Auth::guard('admin')->user()->id;
        $datas['exp_id'] = $request->exp_id;
        $datas['vendor_id'] = $request->vendor_id;
        $datas['start_date'] = date('Y-m-d');
        $datas['interval_days'] = abs($request->days);
        $datas['end_date'] = $date->addDays(abs($request->days))->toDateString();
        $setup = ExpSetup::create($datas);

        if ($setup) {
            $history = ExpSetup::where('client_id', Auth::guard('admin')->user()->id)->latest()->first();
            $data['client_id'] = $history->client_id;
            $data['auth_id'] = $history->client_id;
            $data['exp_id'] = $history->exp_id;
            $data['vendor_id'] = $history->vendor_id;
            $data['start_date'] = $history->start_date;
            $data['interval_days'] = abs($history->interval_days);
            $data['end_date'] = $history->end_date;
            SetupHistory::create($data);
        }
        return Response::json(true, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpSetup $expSetup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function ExpenseSetupEdit($id)
    {
        $expenses = Category::get();
        $vendor = Addressbook::where('client_id', Auth::guard('admin')->user()->id)->get();
        $exp = ExpSetup::where('client_id', Auth::guard('admin')->user()->id)->where('id', $id)->first();
        return view('admin.expense.expense-setup.edit', compact('expenses', 'exp', 'vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function ExpenseSetupUpdate(Request $request)
    {
        $id = $request->id;
        $date = Carbon::today();
        $exp = ExpSetup::where('client_id', Auth::guard('admin')->user()->id)->where('id', $id)->first();

        $exp['start_date'] = date('Y-m-d');
        $exp['vendor_id'] = $request->vendor_id;
        $exp['interval_days'] = abs($request->days);
        $exp['end_date'] = $date->addDays(abs($request->days))->toDateString();
        $setup = $exp->save();
        if ($setup) {
            // $history = ExpSetup::where('client_id', Auth::guard('admin')->user()->id)->latest()->first();
            // dd($history);
            $data['client_id'] = Auth::guard('admin')->user()->id;
            $data['auth_id'] = Auth::guard('admin')->user()->id;
            $data['exp_id'] = $request->exp_id;
            $data['vendor_id'] = $request->vendor_id;
            $data['start_date'] = date('Y-m-d');
            $data['interval_days'] = abs($request->days);
            $data['end_date'] = $date->addDays(abs($request->days))->toDateString();
            SetupHistory::create($data);
        }

        return redirect()->route('expense.setup')->with('message', 'Schedule Setup Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function ExpenseSetupHistory()
    {
        $user = User::where('user_id', Auth::guard('admin')->user()->user_id)->first();
        $exp = Category::get();
        return view('admin.expense.expense-setup.setup_history', compact('user', 'exp'));
    }

    public function ExpenseSetupHistoryAll($exp_id)
    {
        $data['history'] = SetupHistory::where('client_id', Auth::guard('admin')->user()->id)
            ->where('exp_id', $exp_id)->get();
        foreach ($data['history'] as $key => $history) {
            $data['history'][$key]->name = Category::where('id', $history->exp_id)->first()->name;
            $data['history'][$key]->vName = Addressbook::where('client_id', Auth::guard('admin')->user()->id)->where('id', $history->vendor_id)->first()->name;
        }
        return response()->json($data, 200);
    }
}
