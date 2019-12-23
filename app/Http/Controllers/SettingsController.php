<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $coc = Settings::where('name', 'coc')->get();
        $settings = Settings::all();
        return view('settings.index', compact('coc', 'settings'));
    }
    public function store(Request $request)
    {
        Settings::create($request->all());
        return redirect('/settings')->with('success', 'New Settings Added Successfully');
    }
    public function update(Request $request, Settings $settings)
    {
        $settings->update($request->all());
        return redirect('/settings')->with('success', "$settings->name updated Successfully");
    }
    public function cache()
    {
        \Artisan::call('view:cache');
        \Artisan::call('route:cache');
        return redirect()->back()->with('success', 'Routes and Views Cached for faster Usages');
    }

    public function cache_clear()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
        \Artisan::call('route:clear');
        return redirect()->back()->with('success', 'All Cache are Successfully Cleared');
    }

    public function offus()
    {
        return view('offus');
    }

    public function offus_upload(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $pattern = "/\bcommit\b/i"; //commit 
        $lines = preg_grep($pattern, file($path));

        // dd(file_get_contents($path));
        return $lines;
    }        

}
