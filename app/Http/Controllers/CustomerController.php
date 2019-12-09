<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{    
    public function check(Request $request)
    {
        $search = $request->input('identification');
        $customers = Customer::query()
                    ->where('nid', 'LIKE', "%{$search}%")
                    ->orWhere('passport_id', 'LIKE', "%{$search}%")
                    ->orWhere('account_id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('mobile', 'LIKE', "%{$search}%")
                    ->get();
        // return compact('customer');
        return view('customer.index', compact('customers'));
    }

    public function index()
    {
        $customers = Customer::latest()->get();
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'nullable|string|max:255',
            'birthdate'=>'required|date_format:Y-m-d|before:18 years ago',
            'mobile' =>'required|regex:/(01)[0-9]{9}/',          
            'address' =>'nullable|string',
            'nid' =>'nullable|numeric',            
            'passport_id' =>'nullable|numeric',            
            'account_id' =>'nullable|numeric',            
        ]);

        $id = \Auth::user()->id;
        $new_customer = Customer::create([$request->all() + "user_id" => $id]);
        
        return compact('new_customer');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
