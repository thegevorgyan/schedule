<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('employee_account');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show()
    {
        $username = Auth::user()->email;
        $info = DB::table('users')
                ->select('first_name', 'last_name', 'email')
                ->where('email', $username)
                ->first();
        return json_encode($info);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $username = Auth::user()->email;
        $message['status'] = '201';

        foreach ($request->input('info') as $value) {             
            if($value['change_pwd'] == false){

                $info = DB::table('users')
                ->select('password')
                ->where('email', $username)
                ->first();

                if(Hash::check($value['current_pwd'], $info->password)){
                    $data = DB::table('users')
                        ->where(['email' => $username])
                        ->update([
                            'first_name' => $value['first_name'],
                            'last_name' => $value['last_name']                                
                        ]);
                    return $message['status'] = '200';    
                }else {
                    return $message['status'] = '203';
                }
            }
        }     
        return $message['status'] = '201';   
    }

    public function destroy($id)
    {
        //
    }
}
