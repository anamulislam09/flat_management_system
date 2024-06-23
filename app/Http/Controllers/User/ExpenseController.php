<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Expense;
use App\Models\ExpenseVoucher;
use App\Models\User;
use App\Models\Vendor;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;

class ExpenseController extends Controller
{

    public function Index()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $expSummary = Expense::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->groupBy('cat_id')->get();
        return view('user.expenses.expense_summary', compact('expSummary'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $exp_cat = Category::get();
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $expDetails = Expense::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->orderBy('id', 'DESC')->get();

        return view('user.expenses.create', compact('exp_cat', 'expDetails'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Store(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $data['cat_id'] = $request->cat_id;
        $data['client_id'] = $user->client_id;
        $data['year'] = $year;
        $data['month'] = $month;
        $data['amount'] = abs($request->amount);
        $data['auth_id'] = $user->user_id;
        $exp = Expense::create($data);

        if (!$exp) {
            return redirect()->back()->with('message', 'Something went wrong');
        }
        return redirect()->back()->with('message', 'Expense creted successfully');
    }

    public function Edit($id)
    {
        $data = Expense::findOrFail($id);
        $exp_cat = Category::get();
        return view('user.expenses.edit', compact('data', 'exp_cat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function Update(Request $request)
    {
        $id = $request->id;
        $data = Expense::findOrFail($id);
        $data['cat_id'] = $request->cat_id;
        $data['amount'] = abs($request->amount);
        $data->save();
        return redirect()->back()->with('message', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function Delate($id)
    {
        $data = Expense::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('message', 'Expense deleted successfully.');
    }

    // Expense Management generate all voucher 

    public function CreateVoucher($id)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $exp = Expense::where('id', $id)->where('client_id', $user->client_id)->first();
        return view('user.expenses.receiver_info', compact('exp'));
    }

    public function CreateVoucherStore(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $data['date'] = date('m/d/y');
        $data['client_id'] = $user->client_id;
        $data['auth_id'] = $user->user_id;
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        Vendor::create($data);
        return redirect()->back()->with('message', 'Successfully added');

    }

    public function GenerateVoucher(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $exp = Expense::where('id', $request->exp_id)->where('client_id', $user->client_id)->first();

        $v_id = 1;
        $isExist = ExpenseVoucher::where('client_id', $user->client_id)->exists();
        if ($isExist) {
            $voucher_id = ExpenseVoucher::where('client_id', $user->client_id)->max('voucher_id');
            $data['voucher_id'] = $this->formatSrl(++$voucher_id);
        } else {
            $data['voucher_id'] = $this->formatSrl($v_id);
        }

        $data['month'] = $exp->month;
        $data['year'] = $exp->year;
        $data['date'] = date('m/d/y');
        $data['client_id'] = $exp->client_id;
        $data['auth_id'] = $user->user_id;
        $data['cat_id'] = $exp->cat_id;
        $data['amount'] = abs($request->amount);
        $data['vendor_id'] = $request->vendor_id;
        $voucher = ExpenseVoucher::create($data);
        if ($voucher) {
            $inv = ExpenseVoucher::where('client_id', $user->client_id)->latest()->first();
            $exp_name = Category::where('id', $inv->cat_id)->first();
            $vendor = Vendor::where('client_id', $exp->client_id)->where('id', $inv->vendor_id)->first();
            $client = Client::where('id', $user->client_id)->first();

            $data = [
                'inv' => $inv,
                'exp_name' => $exp_name,
                'vendor' => $vendor,
                'client' => $client,
            ];
            // dd($data);
            $pdf = PDF::loadView('user.voucher.index', $data);
            return $pdf->stream('sdl.pdf');
        }
    }

    // unique id serial function
    public function formatSrl($srl)
    {
        switch (strlen($srl)) {
            case 1:
                $zeros = '00000';
                break;
            case 2:
                $zeros = '0000';
                break;
            case 3:
                $zeros = '000';
                break;
            case 4:
                $zeros = '00';
                break;
            default:
                $zeros = '0';
                break;
        }
        return $zeros . $srl;
    }

    // Expense Management generate all voucher 
    public function GenerateVoucherAll()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $inv = Expense::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->groupBy('cat_id')->get();
        $total = Expense::where('client_id', $user->client_id)->where('month', $month)->where('year', $year)->sum('amount');
        // $total = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month) ->where('year', $year)->sum('amount');

        $client = Client::where('id', $user->client_id)->first();

        $data = [
            'inv' => $inv,
            'total' => $total,
            'client' => $client,
        ];
        $pdf = PDF::loadView('user.voucher.exp_all', $data);
        return $pdf->stream('sdl.pdf');
    }

    // Account Expense generate all voucher 
    public function GenerateExpenseVoucherAll(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $inv = Expense::where('client_id', $user->client_id)->where('month', $request->month)->where('year', $request->year)->groupBy('cat_id')->get();
        $total = Expense::where('client_id', $user->client_id)->where('month', $request->month)->where('year', $request->year)->sum('amount');
        $month = Expense::where('client_id', $user->client_id)->where('month', $request->month)->where('year', $request->year)->first();


        $client = Client::where('id', $user->client_id)->first();

        $data = [
            'inv' => $inv,
            'total' => $total,
            'month' => $month,
            'client' => $client,
        ];
        $pdf = PDF::loadView('user.voucher.exp_voucher_all', $data);
        return $pdf->stream('sdl_exp.pdf');
    }
}
