<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Remitance;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $remitances = Remitance::all();
        return view('report.index', compact('remitances'));
    }

    public function remitance_sms(Remitance $remitance)
    {
        return redirect()->back()->with('success', "SMS sent to {$remitance->Customer->mobile}");
    }
    public function remitance(Remitance $remitance)
    {
        return view('report.remitance', compact('remitance'));
    }

    public function incentive(Request $request, Customer $customer)
    {
        $remitances = Remitance::where('customer_id', $customer->id)->where('incentive_voucher', $request->data)->get();
        return view('report.incentive', compact('remitances', 'customer'));
    }

    public function customer(Customer $customer)
    {
        return view('report.customer', compact('customer'));
    }
}
