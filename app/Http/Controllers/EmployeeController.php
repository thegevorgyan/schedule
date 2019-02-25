<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $username = Auth::user()->email;
        return view('employee',  ['username' => $username]);
    }

    public function show()
    {
        $username = Auth::user()->email;
        $tasks = DB::table('tasks')
        ->orderBy('id', 'desc')
        ->where('user_login', '=', $username)
        ->get();
        
        return view('employee_task', ['tasks' => $tasks, 'username' => $username]); 
    }

    public function view_account()
    {
        return view('employee_account');
    }

    public function get_account()
    {
        $username = Auth::user()->email;
        $info = DB::table('users')->where('email', $username)->first();
        return view('employee_account', ['info' => json_encode($info), 'username' => $username]);
    }

    public function store(Request $request)
    {
        $request->input('comments') == '' ? $comments = '' : $comments = $request->input('comments');

        DB::table('tasks')->insert([
            'user_login' => Auth::user()->email,
            'task_name' => $request->input('tsk_name'),
            'comments' => $comments,
            'hours' => $request->input('hour'),
            'minutes' => $request->input('minute'),
            'day' => $request->input('date')            
        ]);
    }

    public function update(Request $request, $id)
    {  
        $request->input('comments') == '' ? $comments = '' : $comments = $request->input('comments');

        DB::table('tasks')->where('id', '=', $id)->update([
            'user_login' => Auth::user()->email,
            'task_name' => $request->input('tsk_name'),
            'comments' => $comments,
            'hours' => $request->input('hour'),
            'minutes' => $request->input('minute'),
            'day' => $request->input('date')
        ]);
    }

    public function destroy(Request $request)
    {
        DB::table('tasks')
            ->where('id', '=', $request->input('id'))
            ->delete();
    }
	
	public function add()
    {
        return view('employee_task_add');
    }

    public function edit($id)
    {
        $tasks_row = DB::table('tasks')
        ->where(['id'=> $id, 'user_login' => Auth::user()->email])
        ->get();

        if(count($tasks_row) == 1){
            return view('employee_task_edit', [ 'tasksRow' => $tasks_row ]);
        } else{
            abort(403);
        }
    }

}
