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

    public function monthly_full(Request $request){
        $date = strtotime($request->input('date'));
        
        $remitances = Remitance::query()
                        ->whereYear('payment_date', date('Y', $date))
                        ->whereMonth('payment_date', date('m', $date))
                        ->where('remit_type', 'spotcash')
                        ->where('payment_type', 'cash')
                        ->selectRaw('SUM(amount) as total, payment_date')
                        ->groupBy('payment_date')
                        ->orderBy('payment_date', 'asc')
                        ->get();
                        // ->sum('amount');

                        dd($remitances);
        // return view('report.monthly_full', compact('date', 'remitances'));
    }

    public function monthly(Request $request)
    {
        $date = strtotime($request->input('date'));

        $spotcash = Remitance::query()
            ->whereYear('payment_date', date('Y', $date))
            ->whereMonth('payment_date', date('m', $date))
            ->where('remit_type', 'spotcash')
            ->where('payment_type', 'cash')
            ->get()
            ->sum('amount');

        $coc = Remitance::query()
            ->whereYear('payment_date', date('Y', $date))
            ->whereMonth('payment_date', date('m', $date))
            ->where('remit_type', 'coc')
            ->where('payment_type', 'cash')
            ->get()
            ->sum('amount');

        $acpay = Remitance::query()
            ->whereYear('payment_date', date('Y', $date))
            ->whereMonth('payment_date', date('m', $date))
            ->where('payment_type', 'transfer')
            ->get()
            ->sum('amount');

        return view('report.monthly', compact('date', 'spotcash', 'coc', 'acpay'));
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
        $remitances = Remitance::where('customer_id', $customer->id)
            ->where('incentive_voucher', $request->data)
            ->get();
        if (!$remitances) {
            return redirect()->back()->with('danger', 'Voucher not found in Database');
        }
        return view('report.incentive', compact('remitances', 'customer'));
    }

    public function customer(Customer $customer)
    {
        return view('report.customer', compact('customer'));
    }
}
