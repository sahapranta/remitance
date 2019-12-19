<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function admin(Request $request)
    {
        $user_id = $request->input('user');            
        if ($request->input('role') == 'admin') {            
            User::find($user_id)->increment('role');            
        } elseif ($request->input('role') == 'user') {
            User::find($user_id)->decrement('role');
        }
        return redirect()->back()->with('success', 'User Role Changed to ' . strtoupper($request->input('role')));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($request->input('password')) {
            $request->validate([
                'password' => 'min:8',
            ]);
            $user->update($request->except(['password'])+['password'=>Hash::make($request->input('password'))]);
        } else {
            $user->update($request->except(['password']));
        }
        return redirect()->route('user.index')->with('success', "{$user->name} Updated Successfully");
    }
}
