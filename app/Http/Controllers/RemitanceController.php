<?php

namespace App\Http\Controllers;

use App\Remitance;
use App\Customer;
use Illuminate\Http\Request;

class RemitanceController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        return view('remitance.create');
    }

    
    public function store(Request $request)
    {
        $customer = Customer::find($request->input('customer_id'));
        $customer_id = $customer->id;
        $sa = Remitance::create(
            $request->only('remit_type', 'exchange_house', 'reference', 'payment_date', 'sending_country', 'sender', 'incentive_date', 'payment_type', 'payment_by', 'note') +
                [
                    "customer_id" => $customer_id,
                    "user_id" => \Auth::id(),
                    'amount' => floatval($request->input('amount')),
                    'incentive_amount' => floatval($request->input('incentive_amount'))
                ]
        );
        return redirect("/customer/$customer_id")->with('success', 'Remitance Successfully Added');
    }

    
    public function show(Remitance $remitance)
    {
        //
    }

    
    public function edit(Remitance $remitance)
    {
        //
    }

   
    public function update(Request $request, Remitance $remitance)
    {
        //
    }

    
    public function destroy(Remitance $remitance)
    {
        //
    }
}
