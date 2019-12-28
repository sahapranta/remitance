<?php

namespace App\Http\Controllers;

use App\Settings;
use App\Customer;
use App\Remitance;
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

        $remitance = $request->input('remitance');
        $rem_pattern = "/\b$remitance\b/i";
        $rem = preg_grep($rem_pattern, file($path));

        $incentive = $request->input('incentive');
        $inc_pattern = "/\b$incentive\b/i";
        $inc = preg_grep($inc_pattern, file($path));
        return compact('rem', 'inc');
    }


    public function create_remitance_offus(Request $request)
    {
        $data = $request->input('data');
        $date = $request->input('date');

        if (empty($data)) {
            // return 'No Data Found';
        }

        $inc =  1;        
        
        foreach ($data as $d) {
            $voucher = 'RM-' . date('Ymd') . '-' .'1' . str_pad($inc, 3, '0', STR_PAD_LEFT);

            $customer = Customer::where('account_id', $d['code'])->get();
            
            if ($customer->isEmpty()) {
                $customer = Customer::create([
                    'name'=> $d['name'],
                    'account_id'=> $d['code'],
                    'user_id' => \Auth::id()
                ]);
            }            

            $remitance = Remitance::create([
                'remit_type'=>'online',
                'exchange_house'=>'online',
                'reference'=>uniqid('on_'),
                'payment_date'=>$date,
                'sending_country'=>'Online',
                'sender'=>'Online',
                'amount'=>$d['amount'],
                'incentive_amount'=>$d['incentive'],
                'incentive_date'=>$date,
                'payment_type'=>'transfer',
                'payment_by'=>'branch',
                'customer_id'=>$customer->id,
                'user_id'=>\Auth::id(),
                'voucher_reference'=>$voucher,
            ]);
        }

        return 'true';
    }

}
