<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminScheduleController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
       // return view('admin.admin');
    }

    public function show()
    {
      return view('admin.schedule');
    }

    public function get_users(Request $request)
    {        
        if($request->input('name') == 'users'){       
            $users = DB::table('users')
            ->select('first_name', 'last_name', 'email')
            ->get();
            return json_encode($users);  
        } else {
            return 'You do not have a privilege';
        }     
    }

    public function get_schedule(Request $request)
    {        
        if($request->input('email')){
            $tasks = DB::table('tasks')           
            ->select('task_name','hours','minutes','day')
            ->where('user_login', '=', $request->input('email'))
            ->get();
            return json_encode($tasks);  
        } else {
            return 'You do not have a privilege';
        }     
    }

    public function store(Request $request)
    {   
        foreach ($request->input('user') as $value) {            
            DB::table('users')->insert([
                'first_name' => $value['new_first_name'],
                'last_name' => $value['new_last_name'],
                'email' => $value['new_email'],
                'password' => Hash::make($value['new_pwd'])
            ]);
        }
                     
    }

    public function update(Request $request)
    {
    
        if($request->input('action') == 'update'){                    
            foreach ($request->input('id') as $key => $value) {
                DB::table('users')
                ->where('id', '=', $value['id'])
                ->update([
                    'first_name' => $value['user_first_name'],
                    'last_name' => $value['user_last_name'],
                    'email' => $value['user_email'],
                    'password' => $value['user_password']
                ]);
                
            }   
            return $request->input('id');        
        } 
     
    }

    public function destroy(Request $request)
    {
        if($request->input('action') == 'delete'){
            foreach ($request->input('id') as $key => $value) {
                DB::table('users')
                ->where('id', '=', $value)
                ->delete(); 
            }
        } 
    } 

}
