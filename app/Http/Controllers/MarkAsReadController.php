<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Generator as Faker;

class MarkAsReadController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(Faker $faker)
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
            if (auth()->user()->notifications->count() > 0) {
                if (auth()->user()->readNotifications()->count() > 0) {
                    auth()->user()->readNotifications()->delete();
                    return redirect()->back()->with('success', "Notifications Successfully Deleted");
                } else {
                    return redirect()->back()->with('success', "Notifications can be deleted after Marking as Read");
                }
            } else {
                return redirect()->back()->with('success', "You have No Notifications to Delete");                
            }
        } else {
            return redirect()->back()->with('danger', 'Try Again');
        }
    }
}
