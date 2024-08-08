<?php

namespace App\Http\Controllers;

use App\Jobs\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function viewLogin()
    {
        return view('page-login');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['email', 'required'],
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return redirect()->back()->with('message', 'Email or password incorrect');
        }
        return redirect('/');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function users()
    {
        $data['users'] = User::get();
        return view('user-table', $data);
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'unique:users'],
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            Session::flash('errors', 'Email has already taken');
        } else {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $user = Auth::user();

            Notification::dispatch([
                'type' => 'user',
                'email' => $user->email,
                'title' => 'Create user',
                'name' => $request->name,
                'is_publish' => $request->is_publish ? "true" : "false",
                'message' => 'Create success'
            ]);
            Session::flash('message', 'Created success');
        }
        return redirect('/users');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'unique:users', 'email'],
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            Session::flash('errors', 'Update failed');
        } else {
            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $user = Auth::user();

            Notification::dispatch([
                'type' => 'user',
                'email' => $user->email,
                'title' => 'Update user',
                'name' => $request->name,
                'is_publish' => $request->is_publish ? "true" : "false",
                'message' => 'Update success'
            ]);
            Session::flash('message', 'Update success');
        }
        return redirect('users');
    }
    public function delete($id)
    {
        $data = User::where('id', $id)->first();

        $user = Auth::user();

        Notification::dispatch([
            'type' => 'category',
            'email' => $user->email,
            'title' => 'Delete user',
            'name' => $data->name,
            'is_publish'=> $data->is_publish? "true": "false",
            'message' => 'Delete success'
        ]);

        $data->delete();
        return redirect('/users');
    }
}
