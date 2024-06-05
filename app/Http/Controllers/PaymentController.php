<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function Index()
    {
        $payments = Payment::groupBy('client_id')->get();
        return view('superadmin.payments.index', compact('payments'));
    }

    public function Create()
    {
        $client = Customer::where('role', 1)->get();
        return view('superadmin.payments.create', compact('client'));
    }

    // insert sub category category using ajax request
    public function getPackage(Request $request)
    {
        $clientid = $request->post('client_id');
        $client = Customer::where('id', $clientid)->first();
        $data['package'] = DB::table('packages')->where('id', $client->package_id)->first();
        return response()->json($data);
    }

    public function Store(Request $request)
    {
        $dueAmount = $request->package_bill - $request->collection_amount;

        $v_id = 1;
        $isExist = Payment::exists();
        $Exist = Payment::where('client_id', $request->client_id)->exists();

        if ($isExist) {
            $invoice_id = Payment::max('invoice_id');
            $invoice_id = explode('-', $invoice_id)[1];
            $data['invoice_id'] = 'INV-' . $this->formatSrl(++$invoice_id);
        } else {
            $data['invoice_id'] = 'INV-' . $this->formatSrl($v_id);
        }
        $data['client_id'] = $request->client_id;
        $data['payment_amount'] = $request->package_bill;
        $data['paid'] = $request->collection_amount;
        if ($Exist) {
            $due_amount = Payment::where('client_id', $request->client_id)->latest()->first();
            $due = $due_amount->due - $request->collection_amount;
            $data['due'] = $due;
        } else {
            $data['due'] = $dueAmount;
        }
        $data['date'] = date('Y-m-d');
        $data['month'] = date('m');
        $data['year'] = date('Y');
        $payments = Payment::create($data);
        if ($payments) {
            $balance = DB::table('customers')->where('id', $request->client_id)->first();
            $balance = $balance->customer_balance - $request->collection_amount;
            $client['customer_balance'] = $balance;
            DB::table('customers')->where('id', $request->client_id)->update($client);
            // $client->save();
        }

        return redirect()->route('collections.all')->with('message', 'Payment Inserted Successfully');
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
}
