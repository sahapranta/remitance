<?php

namespace App\Http\Controllers;

use App\Remitance;
use App\Customer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomerCreated;

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
        $incentive_amount = floatval($request->input('incentive_amount'));

        $sa = Remitance::create(
            $request->only('remit_type', 'exchange_house', 'reference', 'payment_date', 'sending_country', 'sender', 'incentive_date', 'payment_type', 'payment_by', 'note') +
                [
                    "customer_id" => $customer_id,
                    "user_id" => \Auth::id(),
                    'amount' => floatval($request->input('amount')),
                    'incentive_amount' => $incentive_amount,
                ]
        );
        
        if ($incentive_amount <= 0 ) {            
            Notification::send(User::all(), new CustomerCreated("/customer/$customer_id", "Remitance Paid to $customer->name but Incentive DUE", \Auth::user()->name));
        } else {
            Notification::send(User::all(), new CustomerCreated("/customer/$customer_id", "Remitance Paid to $customer->name", \Auth::user()->name));
        }

        return redirect("/customer/$customer_id")->with('success', 'Remitance Successfully Added');
    }

    
    public function show(Remitance $remitance)
    {
        //
    }

    
    public function edit(Remitance $remitance)
    {
        return view('remitance.edit', compact('remitance'));
    }

   
    public function update(Request $request, Remitance $remitance)
    {
        $remitance->update($request->only('incentive_amount', 'incentive_date'));
        $customer_id = $remitance->Customer->id;
        return redirect("/customer/$customer_id")->with('success', 'Incentive Successfully Paid');
    }

    
    public function destroy(Remitance $remitance)
    {
        //
    }
}
