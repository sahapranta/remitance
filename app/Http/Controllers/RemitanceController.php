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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
        $customer = Customer::find($request->input('customer_id'));        
        $sa = Remitance::create(
            $request->only('remit_type', 'exchange_house', 'reference', 'payment_date', 'sending_country', 'sender', 'incentive_date', 'payment_type', 'payment_by', 'note') + 
            [
                "customer_id"=>$customer->id ,
                "user_id"=>$id = \Auth::user()->id ,
                'amount' =>floatval($request->input('amount')) ,
                'incentive_amount' => floatval($request->input('incentive_amount'))
             ]
        );
        return compact('sa');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Remitance  $remitance
     * @return \Illuminate\Http\Response
     */
    public function show(Remitance $remitance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Remitance  $remitance
     * @return \Illuminate\Http\Response
     */
    public function edit(Remitance $remitance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Remitance  $remitance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Remitance $remitance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Remitance  $remitance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Remitance $remitance)
    {
        //
    }
}
