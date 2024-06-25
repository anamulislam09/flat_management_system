<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use App\Models\Guest;
use App\Models\GuestHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class GuestController extends Controller
{
    public function Index()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $guests = Guest::where('client_id', $user->client_id)->get();
        return view('user.guest.index', compact('guests'));
    }

    public function Create()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $flats = Flat::where('client_id', $user->client_id)->get();
        return view('user.guest.create', compact('flats'));
    }

    public function store(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
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
        $guest->client_id = $user->client_id;
        $guest->create_by = $user->client_id;
        $guest->name = $request->input('name');
        $guest->phone = $request->input('phone');
        $guest->address = $request->input('address');
        $guest->image = $imageName; // Assuming you have an 'image' column to store the image name
        $data = $guest->save();

        if ($data) {
            $item = Guest::where('client_id', $user->client_id)->latest()->first();
            $guestHistory = new GuestHistory();
            $guestHistory->guest_id = $item->id;
            $guestHistory->client_id = $user->client_id;
            $guestHistory->flat_id = $request->flat_id;
            $guestHistory->purpose = $request->purpose;
            $guestHistory->entry_date = now(); // Assuming you want to use the current datetime
            $guestHistory->create_by = $user->client_id;
            $guestHistory->save();

            return redirect()->route('manager.guestBook.index')->with('message', 'Successfully Inserted.');
        } else {
            return redirect()->back()->with('error', 'Failed to insert.');
        }
    }

    public function Edit($id)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $data = Guest::where('client_id', $user->client_id)->where('id', $id)->first();
        $flats = Flat::where('client_id', $user->client_id)->get();
        return view('user.guest.edit', compact('data', 'flats'));
    }

    public function Update(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        // $data['guest_id'] = $request->guest_id;
        // $data['client_id'] = $user->client_id;
        // $data['flat_id'] = $request->flat_id;
        // $data['purpose'] = $request->purpose;
        // $data['entry_date'] = date('Y-d-m h:i:s');
        // $data['create_by'] = $user->client_id;   
        // GuestHistory::create($data);
        // dd(gettype($request->guest_id));
        // dd($request->guest_id);
        $data = [
            'guest_id' => $request->guest_id,
            'client_id' => $user->client_id,
            'flat_id' => $request->flat_id,
            'purpose' => $request->purpose,
            'entry_date' => now(),
            'create_by' => $user->client_id,
        ];
    
        // dd($data);
        // Insert the data into the GuestHistory table
        GuestHistory::create($data);

        // dd($text);

        return redirect()->back()->with('message', 'Successfully Inserted.');
    }

    public function ShowHistory()
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $history = GuestHistory::where('client_id', $user->client_id)->get();
        return view('user.guest.index_history', compact('history'));
    }
}
