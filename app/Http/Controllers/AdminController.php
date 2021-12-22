<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Admin;

class AdminController extends Controller
{
    public function admin()
    {
        return "testin purpose";
    }
    public function shoLoginForm()
    {
      return view('admin.auth.login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
    		$data = $request->input();
             $adminCount = Admin::where(['email'=>$data['email'],'password'=>md5($data['password'])])->count();
    		if ($adminCount > 0) {
                // Session::put('adminSession',$data['username']);
    			return redirect('/admin/dashboard');
    		} else {
    			return redirect('/admin')->with('flash_massage_error', 'Invaild Username or Password');
    		}
    	}
    	return view('admin.auth.login');
   
    }
}
