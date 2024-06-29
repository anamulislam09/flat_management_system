<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use App\Models\Guest;
use App\Models\GuestHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuestController extends Controller
{
    public function Index()
    {
        $guests = Guest::where('client_id', Auth()->guard('admin')->user()->id)->get();
        return view('admin.guest.index', compact('guests'));
    }

    public function Create()
    {
        $flats = Flat::where('client_id', Auth()->guard('admin')->user()->id)->get();
        return view('admin.guest.create', compact('flats'));
    }

    public function store(Request $request)
    {
        // Decode the base64 image data
        $imageData = $request->input('image_data');
        $image = str_replace('data:image/png;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);
        $imageName = 'guest_' . time() . '.jpg';
        $imagePath = 'images/' . $imageName;

        // Store the image in the public storage
        // Storage::put($imagePath, base64_decode($image));
        $uploadResult = file_put_contents($imagePath, base64_decode($image));

        // Save the guest details to the database
        $guest = new Guest();
        $guest->create_date = now(); // You can directly use now() to get the current datetime
        $guest->client_id = Auth()->guard('admin')->user()->id;
        $guest->create_by = Auth()->guard('admin')->user()->id;
        $guest->name = $request->input('name');
        $guest->phone = $request->input('phone');
        $guest->address = $request->input('address');
        $guest->image = $imageName; // Assuming you have an 'image' column to store the image name
        $data = $guest->save();

        if ($data) {
            $item = Guest::where('client_id', Auth()->guard('admin')->user()->id)->latest()->first();
            $guestHistory = new GuestHistory();
            $guestHistory->guest_id = $item->id;
            $guestHistory->client_id = Auth()->guard('admin')->user()->id;
            $guestHistory->flat_id = $request->flat_id;
            $guestHistory->purpose = $request->purpose;
            $guestHistory->entry_date = now(); // Assuming you want to use the current datetime
            $guestHistory->create_by = Auth()->guard('admin')->user()->id;
            $guestHistory->save();

            return redirect()->route('guestBook.index')->with('message', 'Successfully Inserted.');
        } else {
            return redirect()->back()->with('error', 'Failed to insert.');
        }
    }

    public function Edit($id)
    {
        $data = Guest::where('client_id', Auth()->guard('admin')->user()->id)->where('id', $id)->first();
        $flatId =GuestHistory::where('client_id', Auth()->guard('admin')->user()->id)->where('guest_id', $data->id)->value('flat_id');
        $flats = Flat::where('client_id', Auth()->guard('admin')->user()->id)->get();
        return view('admin.guest.edit', compact('data', 'flats','flatId'));
    }

    public function Update(Request $request)
    {
        // $data['guest_id'] = $request->guest_id;
        // $data['client_id'] = Auth()->guard('admin')->user()->id;
        // $data['flat_id'] = $request->flat_id;
        // $data['purpose'] = $request->purpose;
        // $data['entry_date'] = date('Y-d-m h:i:s');
        // $data['create_by'] = Auth()->guard('admin')->user()->id;   
        // GuestHistory::create($data);
        // dd(gettype($request->guest_id));
        // dd($request->guest_id);
        $data = [
            'guest_id' => $request->guest_id,
            'client_id' => auth()->guard('admin')->user()->id,
            'flat_id' => $request->flat_id,
            'purpose' => $request->purpose,
            'entry_date' => now(),
            'create_by' => auth()->guard('admin')->user()->id,
        ];
    
        // dd($data);
        // Insert the data into the GuestHistory table
        GuestHistory::create($data);

        // dd($text);

        return redirect()->back()->with('message', 'Successfully Inserted.');
    }

    public function ShowHistory()
    {
        $history = GuestHistory::where('client_id', Auth()->guard('admin')->user()->id)->get();
        return view('admin.guest.index_history', compact('history'));
    }
}
