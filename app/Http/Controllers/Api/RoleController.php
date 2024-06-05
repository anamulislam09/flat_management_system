<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // show all customers 
    public function Index()
    {
        $data = Role::all();
        if ($data->count() > 0) {
            return response()->json([
                'status' => 200,
                'products' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No data available'
            ], 404);
        }
    }

    // customers create 
    public function store(Request $request)
    {
        $Role = Role::insert([

            'name' => $request->name,
            'created_at' =>Carbon::now(),
        ]);

        if ($Role) {
            return response()->json([
                'status' => 200,
                'message' => 'Role inserted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    // customer edit 

    public function destroy($id)
    {
        $role = Role::FindOrFail($id);
        if ($role) {
            $role->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Role Deleted Successfully!'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No such role !'
            ], 404);
        }
    }

    
}
