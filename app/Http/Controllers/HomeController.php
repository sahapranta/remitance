<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth', ['except'=>'welcome']);
    }

    
    public function index()
    {        
        return view('home');
    }

    public function welcome()
    {        
        return view('welcome');
    }

  
}
