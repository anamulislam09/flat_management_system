<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Models\Flatid;
use App\Models\Flatmaster;
use App\Models\Income;
use App\Models\User;
use Illuminate\Http\Request;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;
use Auth;
use Carbon\Carbon;

class FlatController extends Controller
{
    // Index method start here 
    public function Index()
    {

        $data = Flat::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.flat.index', compact('data'));
    }
    // Index method ends here 

    // create method start here 
    public function Create()
    {
        $flat = Flat::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.flat.create', compact('flat'));
    }
    // create method ends here 

    // storer method start here 
    public function Store(Request $request)
    {
        if (Flat::where('client_id', Auth::guard('admin')->user()->id)->exists()) {
            return redirect()->back()->with('message', ' OPS! You have already created!');
        } else {
            $floor = $request->floor;
            $unit = $request->unit;
            $sequence = $request->sequence;
            $amount = abs($request->amount);

            $flatChar = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            //  $flats = $floor;

            $k = 1;

            for ($i = 0; $i < $floor; $i++) {
                for ($j = 0; $j < $unit; $j++) {
                    if ($sequence == 1) {
                        $flatName = $flatChar[$i] . '-' . ($j + 1);
                    } elseif ($sequence == 2) {
                        $flatName = $flatChar[$j] . '-' . ($i + 1);
                    } elseif ($sequence == 3) {
                        $flatName = ($i + 1) . '-' .  $flatChar[$j];
                    }

                    $data['client_id'] = Auth::guard('admin')->user()->id;
                    $data['flat_name'] = $flatName;
                    $data['sequence'] = $sequence;
                    $data['floor_no'] = $i + 1;
                    $data['amount'] = $amount;
                    // dd($data);
                    $flatmaster = Flatmaster::create($data);
                    // dd($flatmaster);

                    if ($flatmaster) {
                        $flatid['flat_id'] = $this->formatSrl($k++);
                        $flatid['client_id'] = Auth::guard('admin')->user()->id;
                        Flatid::create($flatid);
                    }
                }
            }

            if ($flatmaster) {
                $flatmasters = Flatmaster::where('client_id', Auth::guard('admin')->user()->id)->get();

                foreach ($flatmasters as $flatmaster) {
                    $flatid = Flatid::where('id', $flatmaster->id)->where('client_id', Auth::guard('admin')->user()->id)->first();
                    // dd($flatid);
                    $flat['flat_unique_id'] = $flatid->flat_id;
                    $flat['client_id'] = Auth::guard('admin')->user()->id;
                    $flat['flat_name'] = $flatmaster->flat_name;
                    $flat['floor_no'] = $flatmaster->floor_no;
                    $flat['sequence'] = $flatmaster->sequence;
                    $flat['charge'] = "Service Charge";
                    $flat['amount'] = $flatmaster->amount;
                    $flat['create_date'] = date('d');
                    $flat['create_month'] = date('F');
                    $flat['create_year'] = date('Y');

                    $all_flat = Flat::create($flat);
                }
                if ($all_flat) {
                    $flats = Flat::where('client_id', Auth::guard('admin')->user()->id)->get();
                    foreach ($flats as $flat_item) {
                        User::insert([
                            'user_id' => $flat_item->client_id . $flat_item->flat_unique_id,
                            'client_id' => $flat_item->client_id,
                            'flat_id' => $flat_item->flat_unique_id,
                            'charge' => $flat_item->charge,
                            'amount' => $flat_item->amount,
                        ]);
                    }
                }
            }
            Flatmaster::where('client_id', Auth::guard('admin')->user()->id)->delete();
            Flatid::where('client_id', Auth::guard('admin')->user()->id)->delete();

            return redirect()->route('flat.index')->with('message', 'Flat creted successfully');
        }
    }

    // unique id serial function
    public function formatSrl($srl)
    {
        switch(strlen($srl)){
            case 1:
                $zeros = '00';
                break;
            case 2:
                $zeros = '0';
                break;
            default:
                $zeros = '0';
            break;
        }
        return $zeros . $srl;
    }

    // store method ends here 

    // flat single create start here
    public function SingleCreate()
    {
        return view('admin.flat.single_create');
    }
    // flat single create start here

    // flat SingleStore start here
    public function SingleStore(Request $request)
    {
        $unique_name = Flat::where('client_id', Auth::guard('admin')->user()->id)->where('flat_name', $request->flat_name)->exists();
        if ($unique_name) {
            return redirect()->back()->with('message', 'Flat name already taken.');
        } else {
            $unique_id = Flat::where('client_id', Auth::guard('admin')->user()->id)->max('flat_unique_id');
            $flat = Flat::where('client_id', Auth::guard('admin')->user()->id)->first();

            $zeroo = '0';
            $data['flat_unique_id'] = ($zeroo) . ++$unique_id;
            $data['client_id'] = Auth::guard('admin')->user()->id;
            $data['flat_name'] = $request->flat_name;
            $data['floor_no'] = $request->floor_no;
            $data['charge'] = "Service Charge";
            $data['amount'] = $flat->amount;
            $data['create_date'] = date('d');
            $data['create_month'] = date('F');
            $data['create_year'] = date('Y');

            $flat = Flat::create($data);
            if ($flat) {
                $latest_flat = Flat::where('client_id', Auth::guard('admin')->user()->id)->latest()->first();
                $user = User::insert([
                    'user_id' => $latest_flat->client_id . $latest_flat->flat_unique_id,
                    'client_id' => $latest_flat->client_id,
                    'flat_id' => $latest_flat->flat_unique_id,
                    'charge' => $latest_flat->charge,
                    'amount' => $latest_flat->amount,
                ]);
                if ($user) {
                    return redirect()->route('flat.index')->with('message', 'Flat creted successfully');
                } else {
                    return redirect()->back()->with('message', 'Something Went Wrong');
                }
            }
        }
    }
    // flat SingleStore ends here
}
