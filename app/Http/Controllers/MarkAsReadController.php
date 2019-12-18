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
        // return view('notifications');   

        dd($faker->dateTimeBetween('- 10 days', '+ 10 days')->format('Y-m-d'));
        
        
    }

    public function read()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        if ($request->isMethod('delete')) {
            auth()->user()->readNotifications()->delete();
            return redirect()->back();
        } else {
            return redirect()->back()->with('success', 'Try Again');
        }
    }
}
