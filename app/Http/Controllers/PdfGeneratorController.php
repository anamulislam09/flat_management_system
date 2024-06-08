<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Expense;
use App\Models\ExpenseVoucher;
use App\Models\Income;
use App\Models\User;
use App\Models\Vendor;
use PDF;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;

class PdfGeneratorController extends Controller
{
    // Expense Management generate all voucher 
    public function CreateVoucher($id)
    {
        $exp = Expense::where('id', $id)->where('client_id', Auth::guard('admin')->user()->id)->first();
        return view('admin.expenses.expense.receiver_info', compact('exp'));
    }

    public function CreateVoucherStore(Request $request)
    {

        $data['date'] = date('m/d/y');
        $data['client_id'] = Auth::guard('admin')->user()->id;
        $data['auth_id'] = Auth::guard('admin')->user()->id;
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        Vendor::create($data);
        return redirect()->back()->with('message', 'Successfully added');
    }

    public function GenerateVoucher(Request $request)
    {
        $exp = Expense::where('id', $request->exp_id)->where('client_id', Auth::guard('admin')->user()->id)->first();

        $v_id = 1;
        $isExist = ExpenseVoucher::where('client_id', Auth::guard('admin')->user()->id)->exists();
        if ($isExist) {
            $voucher_id = ExpenseVoucher::where('client_id', Auth::guard('admin')->user()->id)->max('voucher_id');
            $data['voucher_id'] = $this->formatSrl(++$voucher_id);
        } else {
            $data['voucher_id'] = $this->formatSrl($v_id);
        }
        // dd($request);

        $data['month'] = $exp->month;
        $data['year'] = $exp->year;
        $data['date'] = date('m/d/y');
        $data['client_id'] = $exp->client_id;
        $data['auth_id'] = Auth::guard('admin')->user()->id;
        $data['cat_id'] = $exp->cat_id;
        $data['amount'] = abs($request->amount);
        $data['vendor_id'] = $request->vendor_id;
        // dd($data);
        $voucher = ExpenseVoucher::create($data);
        if ($voucher) {
            $inv = ExpenseVoucher::where('client_id', Auth::guard('admin')->user()->id)->latest()->first();
            $exp_name = Category::where('id', $inv->cat_id)->first();
            $vendor = Vendor::where('client_id', Auth::guard('admin')->user()->id)->where('id', $inv->vendor_id)->first();
            $client = Client::where('id', Auth::guard('admin')->user()->id)->first();

            $data = [
                'inv' => $inv,
                'exp_name' => $exp_name,
                'vendor' => $vendor,
                'client' => $client,
            ];
            $pdf = PDF::loadView('admin.expenses.voucher.index', $data);
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
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $inv = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->groupBy('cat_id')->get();
        $total = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->sum('amount');
        // $total = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month) ->where('year', $year)->sum('amount');
        $client = Client::where('id', Auth::guard('admin')->user()->id)->first();
        // $custDetails = CustomerDetail::where('client_id', $customer->id)->first();

        $data = [
            'inv' => $inv,
            'total' => $total,
            'client' => $client,
            // 'custDetails' => $custDetails,
        ];
        $pdf = PDF::loadView('admin.expenses.voucher.exp_all', $data);
        return $pdf->stream('sdl.pdf');
    }

    // Account Expense generate all voucher 
    public function GenerateExpenseVoucherAll(Request $request)
    {
        $inv = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $request->month)->where('year', $request->year)->groupBy('cat_id')->get();
        $total = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $request->month)->where('year', $request->year)->sum('amount');
        $month = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $request->month)->where('year', $request->year)->first();

        $client = Client::where('id', Auth::guard('admin')->user()->id)->first();
        // $custDetails = CustomerDetail::where('client_id', $customer->id)->first();

        $data = [
            'inv' => $inv,
            'total' => $total,
            'month' => $month,
            'client' => $client,
            // 'custDetails' => $custDetails,
        ];
        $pdf = PDF::loadView('admin.accounts.exp_voucher_all', $data);
        return $pdf->stream('sdl_exp.pdf');
    }

    // Income Management generate income voucher 
    public function GenerateIncomeVoucher($id)
    {
        $inv = Income::where('client_id', Auth::guard('admin')->user()->id)->where('id', $id)->first();
        $user = User::where('client_id', Auth::guard('admin')->user()->id)->where('flat_id', $inv->flat_id)->first();
        $client = Client::where('id', Auth::guard('admin')->user()->id)->first();
        // $custDetails = CustomerDetail::where('client_id', $customer->id)->first();

        $data = [
            'inv' => $inv,
            'user' => $user,
            'client' => $client,
            // 'custDetails' => $custDetails,
        ];
        $pdf = PDF::loadView('admin.expenses.voucher.money_receipt', $data);
        return $pdf->stream('sdl_collection.pdf');
    }

    // Income Management generate all income voucher 
    public function GenerateIncomeVoucherAll(Request $request)
    {
        $inv = Income::where('client_id', Auth::guard('admin')->user()->id)->where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0)->get();
        $month = Income::where('client_id', Auth::guard('admin')->user()->id)->where('month', $request->month)->where('year', $request->year)->where('status', '!=', 0)->first();
        // $user = User::where('client_id', Auth::guard('admin')->user()->id)->where('flat_id', $inv->flat_id)->first();
        $client = Client::where('id', Auth::guard('admin')->user()->id)->first();
        // $custDetails = CustomerDetail::where('client_id', $customer->id)->first();

        $data = [
            'inv' => $inv,
            'month' => $month,
            'client' => $client,
            // 'custDetails' => $custDetails,
        ];
        // dd($data);
        $pdf = PDF::loadView('admin.expenses.voucher.money_receipt_all', $data);
        return $pdf->stream('sdl_collection.pdf');
    }
    // Income Management generate all income voucher 
}
