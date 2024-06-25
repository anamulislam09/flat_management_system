<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Models\Balance;
use App\Models\Client;
use App\Models\Exp_process;
use App\Models\Expense;
use App\Models\ExpenseVoucher;
use App\Models\ExpSetup;
use App\Models\Flat;
use App\Models\Income;
use App\Models\OpeningBalance;
use App\Models\OthersIncome;
use App\Models\Package;
use App\Models\SetupHistory;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;

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
        // dd($check);
        $datas = Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password'], 'status' => 1, 'isVerified' => 1]);
        if (!$datas) {
            return back()->with('message', 'Something Went Wrong!');
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
        $otp = Str::random(4);
        $data['otp'] = $otp;
        $data['image'] = $request->image;
        $client = Client::create($data);

        if ($client) {
            $data = Client::latest()->first();

            $post_url = "http://api.smsinbd.com/sms-api/sendsms";
            $post_values['api_token'] = "V8qsvGXfqBFhS4FozsQq7MyaeqTzXY2es6ufjQ3M";
            $post_values['senderid'] = "8801969908462";
            $post_values['message'] = "Your OPT Code is: " . $data->otp;
            $post_values['contact_number'] = $data->phone;

            $post_string = "";
            foreach ($post_values as $key => $value) {
                $post_string .= "$key=" . urlencode($value) . "&";
            }
            $post_string = rtrim($post_string, "& ");

            $request = curl_init($post_url);
            curl_setopt($request, CURLOPT_HEADER, 0);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);
            $post_response = curl_exec($request);
            curl_close($request);
            $array =  json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $post_response), true);

            return redirect()->route('admin.verfy')->with('message', 'Registration Successfully');
        }
    }

    // register method ends here

    // client verified rouite start here
        // Verify method ends here
        public function Verify()
        {
            $client = Client::latest()->first();
            return view('admin.pages.admin_register_verify', compact('client'));
        }
        // Verify method ends here
    
        // Verify store method ends here
        public function VerifyStore(Request $request)
        {
            $client = Client::where('id', $request->client_id)->first();
            if ($client->otp == $request->otp) {
                $client['isVerified'] = 1;
                $client->save();
                return redirect()->route('admin.verfied');
            } else {
                return redirect()->back()->with('message', 'OTP is Invalied! please, Submit Valied OTP.');
            }
        }
        // Verify store method ends here
    
        // Verified method ends here
        public function Verified(Request $request)
        {
            $client = Client::latest()->first();
            return view('admin.pages.admin_register_verified', compact('client'));
        }
        // Verified method ends here
    // client verified rouite start here



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
        $isverify = DB::table('clients')->where('id', $request->id)->first();
        $package_amount = Package::where('id', $request->package)->first();
        if (Auth::guard('admin')->user()->role == 0) {
            if ($isverify->isVerified == 1) {
            $data = array();
            $data['status'] = $request->status;
            DB::table('Clients')->where('id', $request->id)->update($data);

            $notification = array('message' => 'Customer Update Successfully.', 'alert_type' => 'warning');
            return redirect()->route('client.all')->with($notification);
        } else {
            $notification = array('message' => 'OPS! This Client Was Not Verified.', 'alert_type' => 'danger');
            return redirect()->back()->with($notification);
        }
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
    // public function ForgotPassword(Request $request)
    // {
    //     $client = Client::where('email', '=', $request->email)->first();
    //     if (!empty($client)) {
    //         $client->remember_token = Str::random(40);
    //         $client->save();
    //         Mail::to($client->email)->send(new ForgotPasswordMail($client));
    //         $notification = array('message' => 'Please check your email and forgot your password.', 'alert_type' => 'warning');
    //         return redirect()->back()->with($notification);
    //     } else {
    //         $notification = array('message' => 'Email not found in this system.', 'alert_type' => 'warning');
    //         return redirect()->back()->with($notification);
    //     }
    // }

    

    public function ForgotPassword(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Find the client by email
    $client = Client::where('email', $request->email)->first();

    if ($client) {
        // Generate a new remember token
        $client->remember_token = Str::random(40);
        $client->save();

        try {
            // Send the reset password email
            Mail::to($client->email)->send(new ForgotPasswordMail($client));
            $notification = array(
                'message' => 'Please check your email and reset your password.', 
                'alert_type' => 'success'
            );
        } catch (\Exception $e) {
            // Handle any errors during the email sending process
            $notification = array(
                'message' => 'Failed to send reset password email. Please try again later.', 
                'alert_type' => 'danger'
            );
        }

        return redirect()->back()->with($notification);
    } else {
        $notification = array(
            'message' => 'Email not found in this system.', 
            'alert_type' => 'warning'
        );
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
            $data = Client::where('role', 1)->where('isVerified', 1)->get();
            return view('superadmin.clients.clientAll', compact('data'));
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
            Expense::where('client_id', $request->id)->delete();
            ExpenseVoucher::where('client_id', $request->id)->delete();
            Exp_process::where('client_id', $request->id)->delete();
            Balance::where('client_id', $request->id)->delete();
            Income::where('client_id', $request->id)->delete();
            OpeningBalance::where('client_id', $request->id)->delete();
            OthersIncome::where('client_id', $request->id)->delete();
            User::where('client_id', $request->id)->delete();
            Flat::where('client_id', $request->id)->delete();
            // Flat::where('client_id', $request->id)->delete();
            Vendor::where('client_id', $request->id)->delete();
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
        $data['expense'] = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('amount');
        $data['income'] = Income::where('client_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('paid');
        $manualOpeningBalance = DB::table('opening_balances')->where('client_id', Auth::guard('admin')->user()->id)->where('entry_datetime', $date)->first();
        $data['others_income'] = DB::table('others_incomes')->where('client_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('amount');
        $data['balance'] = Balance::where('client_id', Auth::guard('admin')->user()->id)->where('date', $date)->sum('amount');

        return response()->json($data);
    }
}
