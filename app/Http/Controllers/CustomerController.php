<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\Remitance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomerCreated;

class CustomerController extends Controller
{
    public function check(Request $request)
    {
        $search = $request->input('identification') ?? '';
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
        $customers = Customer::latest()->paginate(15);
        return view('customer.all', compact('customers'));
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
            'nid' => 'required_without_all:passport_id,account_id|unique:customers',
            'passport_id' => 'required_without_all:nid,account_id|unique:customers',
            'account_id' => 'required_without_all:nid,passport_id|unique:customers',
        ]) + ['user_id' => \Auth::id()]);

        $customer_id = $new_customer->id;
        $users = User::where('role', 1)->get();
        foreach ($users as $user) {
            $user->notify(new CustomerCreated("/customer/$customer_id", "New Customer Created", \Auth::user()->name));
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($new_customer, 200);
        } else {
            return redirect("/customer/$customer_id")->with('success', 'New Customer Created');
        }
    }


    public function show(Customer $customer)
    {
        $remitances = Remitance::where('customer_id', $customer->id)->latest()->paginate(10);
        return view('customer.show', compact('customer', 'remitances'));
    }


    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }


    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->only('name', 'mobile', 'address', 'passport_id', 'account_id'));
        return redirect("/customer/$customer->id")->with('success', 'Customer successfully updated');
    }


    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect('/customer')->with('success', "$customer->name Successfully Deleted");
    }
}
