<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    /*-------------------Income start here--------------*/

    public function Create()
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $data = Income::where('month', $month)->where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.income.income', compact('data'));
    }

    // store income 
    public function Store(Request $request)
    {
        $isExists = Flat::where('client_id', Auth::guard('admin')->user()->id)->exists();
        if (!$isExists) {
            return redirect()->back()->with('message', 'Flat not found!');  // User has no exist
        } else {
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
            // User has exist
            if ($request->month > $month || $request->year > $year) {
                return redirect()->back()->with('message', "OPS! It is not possible to add data for advance month. Please select the current month or year.");
            } else {
                if (($month - 1 == $request->month) && ($year == $request->year)) {
                    $previousData = Income::where('month', $request->month)->where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->exists();
                    if ($previousData) {
                        return redirect()->back()->with('message', 'You have already created!');
                    } else {
                        $flats = Flat::where('client_id', Auth::guard('admin')->user()->id)->get();

                        for ($i = 0; $i < count($flats); $i++) {
                            Income::insert([
                                'month' => $request->month,
                                'year' => $request->year,
                                'flat_id' => $flats[$i]->flat_unique_id,
                                'client_id' => $flats[$i]->client_id,
                                // 'auth_id' => Auth::guard('admin')->user()->id,
                                'flat_name' => $flats[$i]->flat_name,
                                'charge' => $flats[$i]->charge,
                                'amount' => $flats[$i]->amount,
                                'due' => $flats[$i]->amount,
                                'date' => date('Y-m'),
                            ]);
                        }
                        return redirect()->back()->with('message', 'Service charge added successfully');
                    }
                } elseif (($month - 1 == $request->month) || ($year != $request->year)) {
                    return redirect()->back()->with('message', "PLS, Select current year.");
                } else {
                    /*-------------------if previous year has data start here --------------*/
                    if (($request->month == 1)) {
                        $month = $request->month;
                        $year = $request->year;
                        $data = Income::where('month', $month)->where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->exists();
                        if ($data) {
                            return redirect()->back()->with('message', 'You have already create!');
                        } else {
                            $data = Income::where('client_id', Auth::guard('admin')->user()->id)->exists();
                            if ($data) {
                                $lastYear = date('Y') - 1;
                                $lastmonth = 12;

                                $flats = Income::where('month', $lastmonth)->where('year', $lastYear)->where('client_id', Auth::guard('admin')->user()->id)->get();
                                for ($i = 0; $i < count($flats); $i++) {
                                    $previousMonthData = Income::where('month', $lastmonth)->where('year', $lastYear)->where('user_id', $flats[$i]->flat_id)->where('client_id', Auth::guard('admin')->user()->id)->first();

                                    $income = Income::insert([
                                        'month' => $month,
                                        'year' => $year,
                                        'flat_id' => $flats[$i]->flat_unique_id,
                                        'client_id' => $flats[$i]->client_id,
                                        // 'auth_id' => Auth::guard('admin')->user()->id,
                                        'flat_name' => $flats[$i]->flat_name,
                                        'charge' => $flats[$i]->charge,
                                        'amount' => $flats[$i]->amount,
                                        'due' => $flats[$i]->amount + $previousMonthData->due,
                                        'date' => date('Y-m'),
                                    ]);
                                }

                                if ($income) {
                                    return redirect()->back()->with('message', 'Service charge added successfully');
                                } else {
                                    return redirect()->back()->with('message', 'something went wrong');
                                }
                            } else {
                                $flats = Flat::where('client_id', Auth::guard('admin')->user()->id)->get();
                                $month = $request->month;
                                $year = $request->year;

                                for ($i = 0; $i < count($flats); $i++) {
                                    Income::insert([
                                        'month' => $month,
                                        'year' => $year,
                                        'flat_id' => $flats[$i]->flat_unique_id,
                                        'client_id' => $flats[$i]->client_id,
                                        // 'auth_id' => Auth::guard('admin')->user()->id,
                                        'flat_name' => $flats[$i]->flat_name,
                                        'charge' => $flats[$i]->charge,
                                        'amount' => $flats[$i]->amount,
                                        'due' => $flats[$i]->amount,
                                        'date' => date('Y-m'),
                                    ]);
                                }
                                return redirect()->back()->with('message', 'Service charge added successfully');
                            }
                        }
                    }
                    /*-------------------if previous year has data ends here --------------*/ else {
                        $month = $request->month;
                        $year = $request->year;
                        $data = Income::where('month', $month)->where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->exists();
                        if ($data) {
                            return redirect()->back()->with('message', 'You have already create!');
                        } else {
                            $data = Income::where('client_id', Auth::guard('admin')->user()->id)->exists();
                            if ($data) {
                                $month = $request->month;
                                $year = $request->year;

                                $previousDate = explode('-', date('Y-m', strtotime(date('Y-m') . " -1 month")));
                                $flats = Income::where('month', $month - 1)->where('year', date('Y'))->where('client_id', Auth::guard('admin')->user()->id)->get();

                                for ($i = 0; $i < count($flats); $i++) {
                                    $previousMonthData = Income::where('month', $month - 1)->where('year', $previousDate[0])->where('flat_id', $flats[$i]->flat_id)->where('client_id', Auth::guard('admin')->user()->id)->first();
                                    Income::insert([
                                        'month' => $month,
                                        'year' => $year,
                                        'flat_id' => $flats[$i]->flat_id,
                                        'client_id' => $flats[$i]->client_id,
                                        // 'auth_id' => Auth::guard('admin')->user()->id,
                                        'flat_name' => $flats[$i]->flat_name,
                                        'charge' => $flats[$i]->charge,
                                        'amount' => $flats[$i]->amount,
                                        'due' => $flats[$i]->amount + $previousMonthData->due,
                                        'date' => date('Y-m'),
                                    ]);
                                }
                                // dd($previousMonthData);
                                return redirect()->back()->with('message', 'Service charged added successfully');
                            } else {
                                $flats = Flat::where('client_id', Auth::guard('admin')->user()->id)->get();
                                $month = $request->month;
                                $year = $request->year;

                                for ($i = 0; $i < count($flats); $i++) {
                                    Income::insert([
                                        'month' => $month,
                                        'year' => $year,
                                        'flat_id' => $flats[$i]->flat_unique_id,
                                        'client_id' => $flats[$i]->client_id,
                                        // 'auth_id' => Auth::guard('admin')->user()->id,
                                        'flat_name' => $flats[$i]->flat_name,
                                        'charge' => $flats[$i]->charge,
                                        'amount' => $flats[$i]->amount,
                                        'due' => $flats[$i]->amount,
                                        'date' => date('Y-m'),
                                    ]);
                                }
                                return redirect()->back()->with('message', 'Service charge added successfully');
                            }
                        }
                    }
                    // return redirect()->back()->with('message', 'Pls! Select Current Year!');
                }
            }
        }
    }
    /*-------------------Income ends here--------------*/


    /*-------------------Collection start here--------------*/
    public function Collection()
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $data = Income::where('month', $month)->where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->get();
        dd($data);
        return view('admin.income.collection', compact('data'));
    }

    public function StoreCollection(Request $request)
    {
        dd($request);
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $flat_id = $request->flat_id;
        $paid = $request->paid;
        $data = Income::where('month', $month)->where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->where('flat_id', $flat_id)->first();

        if ($paid > $data->due) {
            return redirect()->back()->with('message', 'Something went wrong!');
        } else {

            $previousMonthData = Income::where('month', $month - 1)
                ->where('year', $year)
                ->where('flat_id', $flat_id)
                ->where('client_id', Auth::guard('admin')->user()->id)
                ->first();
            $data = Income::where('month', $month)->where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->where('flat_id', $flat_id)->first();
            if (isset($previousMonthData->due)) {
                $amount = $previousMonthData->due + $data->amount;

                $item['paid'] = abs($paid);
                $item['due'] = $data->due - abs($paid);
                $item['auth_id'] = Auth::guard('admin')->user()->id;
                $item['date'] = date('Y-m');

                $isExist = Income::where('client_id', Auth::guard('admin')->user()->id)->exists();
                $inv_id = 1;
                if ($isExist) {
                    $invoice_id = Income::where('client_id', Auth::guard('admin')->user()->id)->max('invoice_id');
                    $item['invoice_id'] = $this->formatSrl(++$invoice_id);
                } else {
                    $item['invoice_id'] =$this->formatSrl($inv_id);
                }


                if ($amount == $paid) {
                    $item['status'] = 1;
                } else {
                    $item['status'] = 2;
                }
            } else {
                $amount = $data->amount;

                $item['paid'] = abs($paid);
                $item['due'] = $data->due - abs($paid);
                $item['auth_id'] = Auth::guard('admin')->user()->id;
                $item['date'] = date('Y-m');

                $isExist = Income::where('client_id', Auth::guard('admin')->user()->id)->exists();
                $inv_id = 1;
                if ($isExist) {
                    $invoice_id = Income::where('client_id', Auth::guard('admin')->user()->id)->max('invoice_id');
                    $item['invoice_id'] = $this->formatSrl(++$invoice_id);
                } else {
                    $item['invoice_id'] = $this->formatSrl($inv_id);
                }

                if ($amount == $paid) {
                    $item['status'] = 1;
                } else {
                    $item['status'] = 2;
                }
            }

            Income::where('month', $month)->where('year', $year)->where('client_id', Auth::guard('admin')->user()->id)->where('flat_id', $flat_id)->update($item);
            return redirect()->route('income.collection')->with('message', 'Collection successful');
        }
    }
    /*-------------------Collection ends here--------------*/

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
