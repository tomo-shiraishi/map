<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        return view('user.index');
    }


    public function create()
    {
        return view('user.create');
    }


    public function confirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|max:10',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect('user/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $blade['user_name'] = $request->user_name;
        $blade['email'] = $request->email;
        $blade['password'] = $request->password;

        return view('user.confirm', $blade);
    }


    public function complete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|max:10',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect('user/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        return view('user.complete');
    }




}
