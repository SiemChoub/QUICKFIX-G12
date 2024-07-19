<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payments;
use Illuminate\Http\Request;
use App\Models\User;
use Faker\Provider\ar_EG\Payment;
use App\Models\FixingProgress;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // ------- get payment in laravel ----------------------
    public function index()
    {
        $payments = Payments::all();
        $users = User::all();
        return view('payments.index', compact('payments', 'users'));
    }
    // ------- get payment in laravel ----------------------


    // ------- get payment API ----------------------
    public function getPay()
    {
        $payments = Payments::all();
        return response()->json($payments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return view('payments.new');
    }
    //  ----------------- test code ----------------
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $donefix = FixingProgress::all();
        // $fixer = $donefix->where('acion')
        // $fixers = User::where('role', 'fixer')->get();
        // foreach ($fixers as $fixer) {
        //     $payment = new Payments();
        //     $payment->fixer_id = $fixer->id;
        //     $payment->price = $request->price;
        //     $payment->deadline = $request->deadline;
        //     $payment->description = $request->description;
        //     $payment->save();
        // }
        // return redirect('admin/payments')->with('showAlertCreate', true);
        return $donefix;
    }
    //  ----------------- create pay for api ----------------

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */

     public function edit(Payments $payment){
         return view('payments.edit', ['payment'=>$payment]);
     }
    public function update(Request $request, Payments $payment){
    
        //
        // $payment = Payments::find($id);
        // $payment->price = $request->price;
        // $payment->deadline = $request->deadline;
        // $payment->description = $request->description;
        // $payment->save();
        $payment->update($request->all());
        return redirect('admin/payments')->with('showAlertEdit', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
