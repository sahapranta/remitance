<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarkAsReadController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        return view('notifications');
    }

    public function read()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        if ($request->isMethod('delete')) {
            auth()->user()->notifications()->delete();
            return redirect()->back();
        } else {
            return redirect()->back()->with('success', 'Try Again');
        }
    }
}
