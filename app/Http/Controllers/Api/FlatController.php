<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use App\Models\Flatid;
use App\Models\Flatmaster;
use Illuminate\Http\Request;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;
use Auth;

class FlatController extends Controller
{
    
// Index method start here 
public function Index()
{
    $data = Flat::where('customer_id', Auth::guard('admin')->user()->id)->get();
    $data = Flat::all();
    if ($data->count() > 0) {
        return response()->json([
            'status' => 200,
            'flat' => $data
        ], 200);
    } else {
        return response()->json([
            'status' => 404,
            'message' => 'No data available'
        ], 404);
    }
}
// Index method ends here 

// storer method start here 
public function Store(Request $request)
{
    $authId = $request->auth_id;
    if (Flat::where('customer_id', $authId)->exists()) {
        return redirect()->route('flat.index')->with('message', ' OPS! You have already created!');
    } else {
        $floor = $request->floor;
        $unit = $request->unit;
        $sequence = $request->sequence;
        $authId = $request->auth_id;
        $flatChar = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        //  $flats = $floor;


        for ($i = 0; $i < $floor; $i++) {
            for ($j = 0; $j < $unit; $j++) {
                if ($sequence == 1) {
                    $flatName = $flatChar[$i] . '-' . ($j + 1);
                } elseif ($sequence == 2) {
                    $flatName = $flatChar[$j] . '-' . ($i + 1);
                } elseif ($sequence == 3) {
                    $flatName = ($i + 1) . '-' .  $flatChar[$j];
                }

                $data['customer_id'] = $authId;
                $data['flat_name'] = $flatName;
                $data['floor_no'] = $i + 1;

                $flatmaster = Flatmaster::create($data);

                if ($flatmaster) {
                    $Fid = UniqueIdGenerator::generate(['table' => 'flatids', 'length' => 3]);
                    $flatid['flat_id'] = $Fid;
                    $flatid['customer_id'] = $authId;
                    Flatid::create($flatid);
                }
            }
        }

        if ($flatmaster) {
            $flatmasters = Flatmaster::where('customer_id', $authId)->get();
            // $flatids = Flatid::where('customer_id', Auth::guard('admin')->user()->id)->get();

            // foreach($flatids as $flatid){
            //     $flat_unique_id = $flatid->flat_id . Auth::guard('admin')->user()->id;
            // }
            // dd($flat_unique_id[]);
            // $flat = array();
            foreach ($flatmasters as $flatmaster) {
                $flatid = Flatid::where('id', $flatmaster->id)->where('customer_id', $authId)->first();
                $flat['flat_unique_id'] = $flatid->flat_id;
                $flat['customer_id'] = $authId;
                $flat['flat_name'] = $flatmaster->flat_name;
                $flat['floor_no'] = $flatmaster->floor_no;
               $flat = Flat::create($flat);
            }
        }
        Flatmaster::where('customer_id', $authId)->delete();
        Flatid::where('customer_id', $authId)->delete();

        if ($flat->count() > 0) {
            return response()->json([
                'status' => 200,
                'message' => 'Flat created successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Something went wrong'
            ], 404);
        }
    }
}
// store method ends here 

// flat SingleStore start here
public function SingleStore(Request $request)
{

    $unique_id = Flat::where('customer_id', Auth::guard('admin')->user()->id)->max('flat_unique_id');

    $zeroo = '0';
    $data['flat_unique_id'] = ($zeroo) . ++$unique_id;
    $data['customer_id'] = Auth::guard('admin')->user()->id;
    $data['flat_name'] = $request->flat_name;
    $data['floor_no'] = $request->floor_no;
    $flat = Flat::create($data);

    if ($flat->count() > 0) {
        return response()->json([
            'status' => 200,
            'message' => 'Flat created successfully'
        ], 200);
    } else {
        return response()->json([
            'status' => 404,
            'message' => 'Something went wrong'
        ], 404);
    }
}
// flat SingleStore ends here

}
