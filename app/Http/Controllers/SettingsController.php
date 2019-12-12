<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $coc = Settings::where('name', 'coc')->get();
        return view('settings.index', compact('coc'));
    }
    public function store(Request $request)
    {
        $settings = Settings::create($request->all());
        return redirect('/settings')->with('success', 'New Settings Added Successfully');
    }
}
