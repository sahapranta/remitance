<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Remitance;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $remitances = Remitance::all();
        return view('report.index', compact('remitances'));
    }

    public function datewise_remitance(Request $request)
    {
        $startdate = strtotime($request->input('startdate') ?? now());
        $enddate = strtotime($request->input('enddate') ?? now());

        $spotcash = Remitance::query()
            ->whereBetween('payment_date', [date('Y-m-d', $startdate), date('Y-m-d', $enddate)])
            ->where('remit_type', 'spotcash')
            ->where('payment_type', 'cash')
            ->where('payment_by', '!=', 'agent')
            ->selectRaw('SUM(amount) as spotcash, payment_date')
            ->groupBy('payment_date')
            ->orderBy('payment_date', 'asc')
            ->get()
            ->keyBy('payment_date')
            ->transform(function ($ac) {
                return $ac->spotcash;
            })
            ->toArray();

        $coc = Remitance::query()
            ->whereBetween('payment_date', [date('Y-m-d', $startdate), date('Y-m-d', $enddate)])
            ->where('remit_type', 'coc')
            ->where('payment_type', 'cash')
            ->where('payment_by', '!=', 'agent')
            ->selectRaw('SUM(amount) as coc, payment_date')
            ->groupBy('payment_date')
            ->orderBy('payment_date', 'asc')
            ->get()
            ->keyBy('payment_date')
            ->transform(function ($ac) {
                return $ac->coc;
            })
            ->toArray();

        $acpay = Remitance::query()
            ->whereBetween('payment_date', [date('Y-m-d', $startdate), date('Y-m-d', $enddate)])
            ->where('payment_type', 'transfer')
            ->where('payment_by', '!=', 'agent')
            ->where('remit_type', 'spotcash')
            ->orWhere('remit_type', 'coc')
            ->selectRaw('SUM(amount) as acpay, payment_date')
            ->groupBy('payment_date')
            ->orderBy('payment_date', 'asc')
            ->get()
            ->keyBy('payment_date')
            ->transform(function ($ac) {
                return $ac->acpay;
            })
            ->toArray();


        $qremit = Remitance::query()
            ->whereBetween('payment_date', [date('Y-m-d', $startdate), date('Y-m-d', $enddate)])
            ->where('remit_type', 'qremit')
            ->selectRaw('SUM(amount) as qremit, payment_date')
            ->groupBy('payment_date')
            ->orderBy('payment_date', 'asc')
            ->get()
            ->keyBy('payment_date')
            ->transform(function ($ac) {
                return $ac->qremit;
            })
            ->toArray();

        $online = Remitance::query()
            ->whereBetween('payment_date', [date('Y-m-d', $startdate), date('Y-m-d', $enddate)])
            ->where('remit_type', 'online')
            ->selectRaw('SUM(amount) as online, payment_date')
            ->groupBy('payment_date')
            ->orderBy('payment_date', 'asc')
            ->get()
            ->keyBy('payment_date')
            ->transform(function ($ac) {
                return $ac->online;
            })
            ->toArray();

        $agent = Remitance::query()
            ->whereBetween('payment_date', [date('Y-m-d', $startdate), date('Y-m-d', $enddate)])
            ->where('payment_by', 'agent')
            ->selectRaw('SUM(amount) as agent, payment_date')
            ->groupBy('payment_date')
            ->orderBy('payment_date', 'asc')
            ->get()
            ->keyBy('payment_date')
            ->transform(function ($ac) {
                return $ac->agent;
            })
            ->toArray();


        $period = array();
        for (
            $currentDate = $startdate;
            $currentDate <= $enddate;
            $currentDate += (86400)
        ) {

            $Store = date('Y-m-d', $currentDate);
            $period[] = $Store;
        }

        $type = "Remitance";

        return view('report.datewise', compact('period', 'acpay', 'coc', 'spotcash', 'online', 'qremit', 'agent', 'type'));
    }

    public function datewise_incentive(Request $request)
    {
        $startdate = strtotime($request->input('startdate') ?? now());
        $enddate = strtotime($request->input('enddate') ?? now());

        $spotcash = Remitance::query()
            ->whereBetween('incentive_date', [date('Y-m-d', $startdate), date('Y-m-d', $enddate)])
            ->where('remit_type', 'spotcash')
            ->where('payment_type', 'cash')
            ->where('payment_by', '!=', 'agent')
            ->selectRaw('SUM(incentive_amount) as spotcash, incentive_date')
            ->groupBy('incentive_date')
            ->orderBy('incentive_date', 'asc')
            ->get()
            ->keyBy('incentive_date')
            ->transform(function ($ac) {
                return $ac->spotcash;
            })
            ->toArray();

        $coc = Remitance::query()
            ->whereBetween('incentive_date', [date('Y-m-d', $startdate), date('Y-m-d', $enddate)])
            ->where('remit_type', 'coc')
            ->where('payment_type', 'cash')
            ->where('payment_by', '!=', 'agent')
            ->selectRaw('SUM(incentive_amount) as coc, incentive_date')
            ->groupBy('incentive_date')
            ->orderBy('incentive_date', 'asc')
            ->get()
            ->keyBy('incentive_date')
            ->transform(function ($ac) {
                return $ac->coc;
            })
            ->toArray();

        $acpay = Remitance::query()
            ->whereBetween('incentive_date', [date('Y-m-d', $startdate), date('Y-m-d', $enddate)])
            ->where('payment_type', 'transfer')
            ->where('payment_by', '!=', 'agent')
            ->where('remit_type', 'spotcash')
            ->orWhere('remit_type', 'coc')
            ->selectRaw('SUM(incentive_amount) as acpay, incentive_date')
            ->groupBy('incentive_date')
            ->orderBy('incentive_date', 'asc')
            ->get()
            ->keyBy('incentive_date')
            ->transform(function ($ac) {
                return $ac->acpay;
            })
            ->toArray();


        $qremit = Remitance::query()
            ->whereBetween('incentive_date', [date('Y-m-d', $startdate), date('Y-m-d', $enddate)])
            ->where('remit_type', 'qremit')
            ->selectRaw('SUM(incentive_amount) as qremit, incentive_date')
            ->groupBy('incentive_date')
            ->orderBy('incentive_date', 'asc')
            ->get()
            ->keyBy('incentive_date')
            ->transform(function ($ac) {
                return $ac->qremit;
            })
            ->toArray();

        $online = Remitance::query()
            ->whereBetween('incentive_date', [date('Y-m-d', $startdate), date('Y-m-d', $enddate)])
            ->where('remit_type', 'online')
            ->selectRaw('SUM(incentive_amount) as online, incentive_date')
            ->groupBy('incentive_date')
            ->orderBy('incentive_date', 'asc')
            ->get()
            ->keyBy('incentive_date')
            ->transform(function ($ac) {
                return $ac->online;
            })
            ->toArray();

        $agent = Remitance::query()
            ->whereBetween('incentive_date', [date('Y-m-d', $startdate), date('Y-m-d', $enddate)])
            ->where('payment_by', 'agent')
            ->selectRaw('SUM(incentive_amount) as agent, incentive_date')
            ->groupBy('incentive_date')
            ->orderBy('incentive_date', 'asc')
            ->get()
            ->keyBy('incentive_date')
            ->transform(function ($ac) {
                return $ac->agent;
            })
            ->toArray();


        $period = array();
        for (
            $currentDate = $startdate;
            $currentDate <= $enddate;
            $currentDate += (86400)
        ) {

            $Store = date('Y-m-d', $currentDate);
            $period[] = $Store;
        }
        $type = "Incentive";
        return view('report.datewise', compact('period', 'acpay', 'coc', 'spotcash', 'online', 'qremit', 'agent', 'type'));
    }

    public function daily(Request $request)
    {
        $date = strtotime($request->query('date') ?? now());
        $remitances = Remitance::whereDate('payment_date', date('Y-m-d', $date))
                    // ->orWhereDate('incentive_date', date('Y-m-d', $date))
                    ->get();

        $incentives  = Remitance::whereDate('incentive_date', date('Y-m-d', $date))
                        ->whereDate('payment_date', '!=', date('Y-m-d', $date))
                        ->get()->toArray();                        

        $incentives_sum = Remitance::whereDate('incentive_date', date('Y-m-d', $date))
                        ->whereDate('payment_date', '!=', date('Y-m-d', $date))                        
                        // ->with(['customer'=>function($query){$query->select('name');}])
                        ->groupBy('customer_id')
                        ->selectRaw('SUM(incentive_amount) as incentive_amount, customer_id')                    
                        ->get();
                        
        return view('report.daily', compact('remitances', 'incentives', 'incentives_sum', 'date'));
    }

    public function monthly(Request $request)
    {
        $date = strtotime($request->query('date') ?? now());

        $spotcash = Remitance::query()
            ->whereYear('payment_date', date('Y', $date))
            ->whereMonth('payment_date', date('m', $date))
            ->where('remit_type', 'spotcash')
            ->get()
            ->sum('amount');

        $coc = Remitance::query()
            ->whereYear('payment_date', date('Y', $date))
            ->whereMonth('payment_date', date('m', $date))
            ->where('remit_type', 'coc')
            ->get()
            ->sum('amount');

        $acpay = Remitance::query()
            ->whereYear('payment_date', date('Y', $date))
            ->whereMonth('payment_date', date('m', $date))
            ->where('remit_type', 'qremit')
            ->orWhere('remit_type', 'online')
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

    public function check_ref(Request $request)
    {
        $request->validate([
            'ref' => 'required|string|min:3'
        ]);

        $rem = Remitance::where('reference', $request->input('ref'));

        if ($rem->exists()) {
            $remitance = $rem->first();
            return redirect()->back()->with('link', "Remitance Paid at {$remitance->payment_date} to {$remitance->Customer->name} BDT {$remitance->amount}tk and Incentive {$remitance->incentive_amount}tk");
        } else {
            return redirect()->back()->with('danger', "Remitance with This Reference Not Found");
        }
    }
}
