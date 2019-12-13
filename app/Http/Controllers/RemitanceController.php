<?php

namespace App\Http\Controllers;

use App\Remitance;
use App\Customer;
use App\User;
use Illuminate\Http\Request;
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
            $request->validate([
                'remit_type' => '|required|string',
                'exchange_house' => '|required|string',
                'reference' => '|required|unique:remitances',
                'payment_date' => '|required|date',
                'sending_country' => '|required|string',
                'sender' => '|required|string',
                'incentive_date' => '|nullable|date',
                'payment_type' => '|required|string',
                'payment_by' => '|required|string',
                'note' => '|nullable|string',
            ]) +
                [
                    "customer_id" => $customer_id,
                    "user_id" => \Auth::id(),
                    'amount' => floatval($request->input('amount')),
                    'incentive_amount' => $incentive_amount,
                ]
        );
        $users = User::where('role', 1)->get();
        if ($incentive_amount <= 0) {
            foreach ($users as $user) {
                $user->notify(new CustomerCreated("/customer/$customer_id", "Remitance Paid to $customer->name but Incentive DUE", \Auth::user()->name));
            }
        } else {
            foreach ($users as $user) {
                $user->notify(new CustomerCreated("/customer/$customer_id", "Remitance Paid to $customer->name", \Auth::user()->name));
            }
        }

        return redirect("/customer/$customer_id")->with('success', 'Remitance Successfully Added');
    }


    public function show(Remitance $remitance)
    {
        return view('remitance.show', compact('remitance'));
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
