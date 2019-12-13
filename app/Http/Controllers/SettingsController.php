<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {        
        $coc = Settings::where('name', 'coc')->get();
        $settings = Settings::all();
        return view('settings.index', compact('coc', 'settings'));
    }
    public function store(Request $request)
    {
        $settings = Settings::create($request->all());
        return redirect('/settings')->with('success', 'New Settings Added Successfully');
    }
    public function update(Request $request, Settings $settings)
    {        
        $settings->update($request->all());
        return redirect('/settings')->with('success', "$settings->name updated Successfully");
    }
}
