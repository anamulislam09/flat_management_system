<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Models\Client;
use App\Models\Flat;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    // login method start here 
    public function index()
    {
        return view('admin.pages.admin_login');
    } //end method

    public function Dashboard()
    {
        return view('admin.index');
    } //end method

    public function Login(Request $request)
    {
        $check = $request->all();
        $datas = Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password'], 'status' => 1]);
        if (!$datas) {
            return back()->with('message', 'Something Went Wrong! ');
        } else {
            $check = $request->all();
            if (Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
                return redirect()->route('admin.dashboard')->with('message', 'Login Successfully');
            } else {
                return back()->with('message', 'Invalid Email or Password! ');
            }
        }
    }
    // login method ends here 

    // register method start here
    public function AdminRegister()
    {
        return view('admin.pages.admin_register');
    } //end method

    public function store(Request $request)
    {
        // $email = Client::where('email', $request->email)->exists();
        // if ($email) {
        //     return redirect()->back()->with('message', 'This Email already used!');
        // } 
        // else {
        // $id = UniqueIdGenerator::generate(['table' => 'Clients', 'length' => 4]);
        $start_at = 1001;

        if ($start_at) {
            $client = Client::find($start_at);
            if (!$client) {
                $data['id'] = $start_at;
            }
        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['nid_no'] = $request->nid_no;
        $data['image'] = $request->image;
        $client = Client::create($data);

        return redirect()->route('login_form')->with('message', 'Admin register Successfully');
    }

    // register method ends here

    // Logout method ends here
    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login_form')->with('message', 'Admin Logout Successfully');
        //end method
    }
    // Logout method ends here

    /*-------------------Clients related method start here--------------*/
    public function Client(Request $request)
    {
        if (Auth::guard('admin')->user()->role == 0) {
            $data = Client::where('role', 1)->get();
            return view('superadmin.clients.index', compact('data'));
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
        //end method
    }

    // ClientEdit edit 
    public function ClientEdit($id)
    {
        if (Auth::guard('admin')->user()->role == 0) {
            $data = Client::findOrFail($id);
            $flat = Flat::where('client_id', $data->id)->first();
            return view('superadmin.clients.edit', compact('data', 'flat'));
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }

    // Client update 
    public function ClientUpdate(Request $request)
    {
        if (Auth::guard('admin')->user()->role == 0) {
            $data = array();
            $data['status'] = $request->status;
            DB::table('Clients')->where('id', $request->id)->update($data);

            $notification = array('message' => 'Client status update successfully.', 'alert_type' => 'warning');
            return redirect()->route('clients.all')->with($notification);
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }

    /*-------------------Clients related method start here--------------*/

    /*-------------------Clients password method start here--------------*/
    public function Forgot()
    {
        return view('admin.pages.forgot_password');
    }
    // receive the email 
    public function ForgotPassword(Request $request)
    {
        $client = Client::where('email', '=', $request->email)->first();
        if (!empty($client)) {
            $client->remember_token = Str::random(40);
            $client->save();
            Mail::to($client->email)->send(new ForgotPasswordMail($client));
            $notification = array('message' => 'Please check your email and forgot your password.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        } else {
            $notification = array('message' => 'Email not found in this system.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }

    public function reset($token)
    {
        $client = Client::where('remember_token', '=', $token)->first();
        if (!empty($client)) {
            $data['Client'] = $client;
            return view('admin.pages.reset');
        } else {
            abort(404);
        }
    }

    public function PostReset($token, Request $request)
    {
        $client = Client::where('remember_token', '=', $token)->first();
        if ($request->password == $request->confirm_password) {
            $client->password = Hash::make($request->password);
            if (empty($client->email_verified_at)) {
                $client->email_verified_at = date('Y-m-d H:i:s');
            }
            $client->remember_token = Str::random(40);
            $client->save();
            $notification = array('message' => 'Password reset successfully.', 'alert_type' => 'warning');
            return redirect()->route('login_form')->with($notification);
        } else {
            $notification = array('message' => 'Password & Confirm Password does not match.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }
    /*-------------------Clients password method ends here--------------*/

    /*--------------------Client data deleted method start here -----------------*/

    // delete all data from Clients 
    public function ClientAll()
    {
        if (Auth::guard('admin')->user()->role == 0) {
            $data = Client::where('role', 1)->get();
            return view('superadmin.Clients.ClientAll', compact('data'));
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }
    //end method

    public function ClientDataDelete(Request $request)
    {
        // dd($request->id);
        if (Auth::guard('admin')->user()->role == 0) {
            Exp_detail::where('client_id', $request->id)->delete();
            ExpenseVoucher::where('client_id', $request->id)->delete();
            Exp_process::where('client_id', $request->id)->delete();
            YearlyBlance::where('client_id', $request->id)->delete();
            Income::where('client_id', $request->id)->delete();
            MonthlyBlance::where('client_id', $request->id)->delete();
            OpeningBalance::where('client_id', $request->id)->delete();
            OthersIncome::where('client_id', $request->id)->delete();
            User::where('client_id', $request->id)->delete();
            Flat::where('client_id', $request->id)->delete();
            // Flat::where('client_id', $request->id)->delete();
            Addressbook::where('client_id', $request->id)->delete();
            ExpSetup::where('client_id', $request->id)->delete();
            SetupHistory::where('client_id', $request->id)->delete();


            return redirect()->back()->with('message', 'All data deleted successfully.');
        } else {
            $notification = array('message' => 'You have no permission.', 'alert_type' => 'warning');
            return redirect()->back()->with($notification);
        }
    }
    //end method
    /*--------------------Client data deleted method ends here -----------------*/

    public function GetTransaction($date)
    {

        $data['flats'] = Flat::where('client_id', Auth::guard('admin')->user()->id)->count();
        $data['expense'] = Exp_detail::where('client_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('amount');
        $data['income'] = Income::where('client_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('paid');
        $manualOpeningBalance = DB::table('opening_balances')->where('client_id', Auth::guard('admin')->user()->id)->where('entry_datetime', $date)->first();
        $data['others_income'] = DB::table('others_incomes')->where('client_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('amount');
        $data['balance'] = MonthlyBlance::where('client_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('amount');

        return response()->json($data);
    }
}
