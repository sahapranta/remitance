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

    
    
    public function create()
    {
        return view('customer.create');
    }

    
    public function store(Request $request)
    {
        $new_customer = Customer::create($request->validate([
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date_format:Y-m-d|before:18 years ago',
            'mobile' => 'required|regex:/(01)[0-9]{9}/',
            'address' => 'nullable|string',
            'nid' => 'nullable|string',
            'passport_id' => 'nullable|string',
            'account_id' => 'nullable|string',
        ]) + ['user_id' => \Auth::id()]);

        $customer_id = $new_customer->id;
        return redirect("/customer/$customer_id")->with('success', 'New Customer Created');
    }

    
    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

   
    public function edit(Customer $customer)
    {
        //
    }

    
    public function update(Request $request, Customer $customer)
    {
        //
    }

  
    public function destroy(Customer $customer)
    {
        //
    }
}
