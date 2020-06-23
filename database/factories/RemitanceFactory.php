<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Remitance;
use Faker\Generator as Faker;

function remitance_voucher($type, $date)
    {
        $query = Remitance::query()
            ->where('payment_date', $date);

        if ($type === 'cash') {
            $rem = $query
                ->where('payment_type', $type)
                ->get();
            $inc = count($rem) + 1;
            $number = str_pad($inc, 4, '0', STR_PAD_LEFT);
        } else {
            $rem = $query
                ->where('payment_type', $type)
                ->get();
            $inc = count($rem) + 1;
            $number = '1' . str_pad($inc, 3, '0', STR_PAD_LEFT);
        }

        return (string) 'RM-' . date('Ymd', strtotime($date)) . '-' . $number;
    }

$factory->define(Remitance::class, function (Faker $faker) {
    $remits = ['online', 'qremit', 'spotcash', 'coc', 'spotcash', 'coc'];
    $spot = config('global.spot_cash');
    $coc = config('global.coc');
    $payments_by = ['cash', 'transfer'];
    $remit_type = $remits[rand(0, count($remits) -1)];
    if ($remit_type == 'spotcash') {
        $exchange_house = $spot[rand(0, count($spot)-1)];
        $payment_by = $payments_by[rand(0,1)];
    } elseif ($remit_type == 'coc') {
        $exchange_house = $coc[rand(0, count($coc)-1)];
        $payment_by = $payments_by[rand(0,1)];
    } elseif ($remit_type == 'qremit') {        
        $exchange_house = 'qremit';
        $payment_by = $payments_by[rand(0,1)];
    } else {
        $exchange_house = 'online';
        $payment_by = $payments_by[1];
    }

    $amount = $faker->randomFloat(2, 500, 50000);
    // $date  = $faker->unique()->dateBetween('now', '+15 days');
    $date  = $faker->dateTimeBetween('- 10 days', '+ 10 days')->format('Y-m-d');
    

    return [
        'remit_type'=> $remit_type,
        'exchange_house'=> $exchange_house,
        'reference'=> $faker->bankAccountNumber,
        'payment_date'=>$date,
        'sending_country'=>$faker->country,
        'sender'=>$faker->name('male'),
        'amount'=>$amount,
        'incentive_amount'=>0,
        'payment_type'=>'branch',
        'payment_by'=>$payment_by,        
        'customer_id'=>App\Customer::all()->random()->id,
        'user_id'=>App\User::all()->random()->id,
        'voucher_reference'=>remitance_voucher($payment_by, $date),        
        ];
});
