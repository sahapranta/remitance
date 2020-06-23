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

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('remitance.entry');
    }

    public function prefilled_remitance(Request $request)
    {
        $id = $request->input('customer');
        return redirect("/remitance/create?customer={$id}")->withInput($request->all());
    }

    public function data_entry()
    {
        $customer = Customer::query()
            ->where('nid', '==', request('data->nid'))
            ->orWhere('account_id', '==', request('data->nid'))
            ->orWhere('passport_id', '==', request('data->nid'))
            ->first();
        if (!$customer == null) {
            return response()->json($customer, 200);
        }
        return response()->json('error', 404);
    }

    public function remitance_voucher($type, $date)
    {
        $query = Remitance::query()
            ->where('payment_date', date('Y-m-d', strtotime($date)));

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

    public function create_voucher($type, $date)
    {
        $query = Remitance::query()
            ->where('incentive_date', date('Y-m-d', strtotime($date)));
        if ($type === 'cash') {
            $rem = $query->where('payment_type', $type)
                ->get();
            $inc = count($rem) + 1;
            $number = str_pad($inc, 4, '0', STR_PAD_LEFT);
        } else {
            $rem = $query->where('payment_type', $type)
                ->get();
            $inc = count($rem) + 1;
            $number = '1' . str_pad($inc, 3, '0', STR_PAD_LEFT);
        }

        return (string) 'IN-' . date('Ymd', strtotime($date)) . '-' . $number;
    }

    public function pay_all_incentive(Customer $customer)
    {
        if (count($customer->unpaid_remitances) > 0) {
            return view('customer.pay_all', compact('customer'));
        } else {
            return redirect()->back()->with('danger', 'No Incentive Left for Paying');
        }
    }

    public function pay_multiple_incentive(Request $request, Customer $customer)
    {
        if (count($request->data) > 0) {
            $r = [];
            $remitance = Remitance::where('id', $request->data[0]['id'])->first();
            $voucher_number = $this->create_voucher($remitance->payment_type, $request->data[0]['incentive_date']);

            foreach ($request->data as $val) {
                $r[] = Remitance::where('id', $val['id'])->update([
                    'incentive_amount' => $val['incentive_amount'],
                    'incentive_date' => date('Y-m-d', strtotime($val['incentive_date'])),
                    'incentive_voucher' => $voucher_number,
                ]);
            }

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json($voucher_number, 201);
            } else {
                return redirect()->route('report.incentive', [$customer->id, 'data' => $voucher_number]);
            }
        } else {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json('404', 500);
            } else {
                return redirect()->back()->with('danger', 'No Item is Selected');
            }
        }
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

        $validator = Validator::make($request->all(), [
            'incentive_date' => Rule::requiredIf($incentive_amount > 0),
            'remit_type' => 'required|string',
            'exchange_house' => 'required|string',
            'reference' => 'required|unique:remitances',
            'payment_date' => 'required|date',
            'sending_country' => 'required|string',
            'sender' => 'required|string',
            'payment_by' => 'required|string',
            'payment_type' => 'required|string',
            'note' => 'nullable|string|max:250',
        ]);
        $validator->validate();

        $remit_type = $request->input('remit_type');
        $payment_type = $request->input('payment_type');
                   
        if ($remit_type == 'qremit' || $remit_type == 'online' && $payment_type == 'cash') {
            return redirect()
            ->back()
            ->withInput($request->all())
            ->with('danger', 'Payment Type Should Be Transfer');
        }     

        

        if ($request->input('payment_type') === 'cash') {
            $remitance_voucher = $this->remitance_voucher('cash', $request->input('payment_date'));
        } else {
            $remitance_voucher = $this->remitance_voucher('transfer', $request->input('payment_date'));
        }

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
                "customer_id" => $customer_id,
                "user_id" => \Auth::id(),
                'amount' => floatval($request->input('amount')),
                'incentive_amount' => $incentive_amount,
                'voucher_reference' => $remitance_voucher,
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
            $voucher_number = $this->create_voucher(strtolower($remitance->payment_type), $request->input('incentive_date'));
            $remitance->update($request->only('incentive_amount', 'incentive_date') + ['incentive_voucher' => $voucher_number]);
            $customer_id = $remitance->Customer->id;
            return redirect("/customer/$customer_id")->with('success', 'Incentive Successfully Paid');
        } else {
            $remitance->update($request->all());
            return redirect()->route('remitance.show', $remitance->id)
                ->with('success', 'Remitance Successfully Updated');
        }
    }

    public function print_count(Request $request)
    {
        if ($request->input('incentive')) {
            Remitance::where('incentive_voucher', $request->input('incentive'))->increment('incentive_voucher_print');
            return "true";
        } else {
            Remitance::find($request->input('remitance'))->increment('voucher_print');
            return "true";
        }
        return "false";
    }

    public function remove_duplicate(Remitance $remitance)
    {
        $remitance->voucher_print = 0;
        $remitance->save();
        return redirect()->back()->with('success', 'Voucher Print Count Reset to 0');
    }

    public function remove_duplicate_incentive(Request $request)
    {
        $rems = Remitance::where('incentive_voucher', '=', $request->input('voucher'));

        if ($rems->exists()) {
            $remitances = $rems->get();
            if ($remitances[0]->incentive_voucher_print > 0) {
                foreach ($remitances as $rem) {
                    if ($rem->incentive_voucher_print > 0) {
                        $rem->incentive_voucher_print = 0;
                        $rem->save();
                    }
                }
                return redirect('/settings')->with('success', 'Voucher Print Count Reset to 0');
            } else {
                return redirect('/settings')->with('danger', 'Voucher Print Count is Already 0');
            }
        } else {
            return redirect('/settings')->with('danger', 'Voucher ID not Found');
        }
    }

    public function destroy(Remitance $remitance)
    {
        $customer = $remitance->customer_id;
        $remitance->delete();
        return redirect("/customer/$customer")->with('success', 'Remitance Successfully Deleted');
    }
}
