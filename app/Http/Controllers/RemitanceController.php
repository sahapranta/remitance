<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Notifications\CustomerCreated;
use App\Remitance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RemitanceController extends Controller
{

    public function index()
    {
        //
    }

    public function pay_all_incentive(Customer $customer)
    {        
        if (count($customer->unpaid_remitances)>0) {            
            return view('customer.pay_all', compact('customer'));
        } else {
            return redirect()->back()->with('danger', 'No Incentive Left for Paying');
        }
    }    

    public function pay_multiple_incentive(Request $request, Customer $customer)
    {        
        $r = [];
        foreach ($request->data as $val) {
            $r[] = Remitance::where('id', $val['id'])->update([
                'incentive_amount' =>$val['incentive_amount'],
                'incentive_date' => date('Y-m-d', strtotime($val['incentive_date'])),
            ]);     
        }
       return json_encode($r);
    }

    public function create()
    {
        return view('remitance.create');
    }

    public function store(Request $request)
    {
        $customer         = Customer::find($request->input('customer_id'));
        $customer_id      = $customer->id;
        $incentive_amount = floatval($request->input('incentive_amount'));

        Validator::make($request->all(), [
            'incentive_date'  => Rule::requiredIf($incentive_amount > 0),
            'remit_type'      => 'required|string',
            'exchange_house'  => 'required|string',
            'reference'       => 'required|unique:remitances',
            'payment_date'    => 'required|date',
            'sending_country' => 'required|string',
            'sender'          => 'required|string',
            'payment_type'    => 'required|string',
            'payment_by'      => 'required|string',
            'note'            => 'nullable|string',
        ])->validate();

        $sa = Remitance::create(
            $request->only(
                'incentive_date',
                'remit_type',
                'exchange_house',
                'reference',
                'payment_date',
                'sending_country',
                'sender',
                'payment_type',
                'payment_by',
                'note',
            ) + [
                "customer_id"      => $customer_id,
                "user_id"          => \Auth::id(),
                'amount'           => floatval($request->input('amount')),
                'incentive_amount' => $incentive_amount,
                'voucher_reference' => $request->input('payment_date'),
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

    public function edit(Request $request, Remitance $remitance)
    {
        if ($request->query('incentive') === 'true') {
            if ($remitance->incentive_amount > 0) {
                return redirect()->back()->with('danger', 'Incentive Already Paid');
            }
            return view('remitance.pay_incentive', compact('remitance'));
        } else {
            return view('remitance.edit', compact('remitance'));
        }
    }

    public function update(Request $request, Remitance $remitance)
    {
        if ($request->query('incentive') === 'true') {
            $remitance->update($request->only('incentive_amount', 'incentive_date'));
            $customer_id = $remitance->Customer->id;
            return redirect("/customer/$customer_id")->with('success', 'Incentive Successfully Paid');
        } else {
            $remitance->update($request->all());
            return redirect()->route('remitance.show', $remitance->id)
                ->with('success', 'Remitance Successfully Updated');
        }
    }
    

    public function destroy(Remitance $remitance)
    {
        //
    }
}
