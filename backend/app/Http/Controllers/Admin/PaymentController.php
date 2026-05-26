<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payments;
use App\Models\User;
use Illuminate\Http\Request;
use Faker\Provider\ar_EG\Payment;
use App\Models\FixingProgress;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // ------- get payment in laravel ----------------------
    public function index()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $perPage = (int) request('per_page', 20);
        $perPage = in_array($perPage, [5, 10, 20, 50, 100], true) ? $perPage : 20;

        $status = request('status');            // 'done' | 'no' | null (all)
        $month  = request('month');             // 'Y-M'  | null (all)
        $search = trim((string) request('q', ''));

        // Server-side filtering so each "group" paginates correctly
        $query = Payments::query();

        if ($status === 'no') {                 // Incomplete
            $query->where('status', 'no');
        } elseif ($status === 'done') {         // Succeeded = anything that isn't 'no' (incl. null)
            $query->where(fn ($q) => $q->whereNull('status')->orWhere('status', '!=', 'no'));
        }

        if ($month) {                           // matches the 'Y-M' label in the dropdown
            $query->whereRaw("DATE_FORMAT(datepay, '%Y-%b') = ?", [$month]);
        }

        if ($search !== '') {                   // by customer (fixer) name or total
            $matchIds = User::where('name', 'like', "%{$search}%")->pluck('id');
            $query->where(function ($q) use ($matchIds, $search) {
                $q->whereIn('fixer_id', $matchIds)->orWhere('total', 'like', "%{$search}%");
            });
        }

        $payments = $query->orderByDesc('id')->paginate($perPage)->withQueryString();

        // Totals across the whole table (independent of filters) for the summary chips & month list
        $allCount  = Payments::count();
        $noCount   = Payments::where('status', 'no')->count();
        $doneCount = $allCount - $noCount;
        $months    = Payments::whereNotNull('datepay')->pluck('datepay')
            ->map(fn ($d) => \Carbon\Carbon::parse($d)->format('Y-M'))->unique()->values();

        return view('payments.index', [
            'payments'     => $payments,
            'allCount'     => $allCount,
            'noCount'      => $noCount,
            'doneCount'    => $doneCount,
            'months'       => $months,
            'activeStatus' => $status,
            'activeMonth'  => $month,
            'searchQ'      => $search,
        ]);
    }
    // ------- get payment in laravel ----------------------

    // ------- get payment API ----------------------
    public function store(Request $request)
    {
        $fixdone = FixingProgress::all();
        $fixing = FixingProgress::where('action', 'done')
        ->get(['fixer_id']);
        $m1 = date('m', strtotime($request->datepay));
        $y1 = date('Y', strtotime($request->datepay));
        $fit =[];
        $numberfix = 0;
        foreach ($fixing as $fixer) {
            if(!in_array($fixer->fixer_id, $fit)){
                $fit[] = $fixer->fixer_id;
                $getfixer = $fixdone->where('fixer_id',$fixer->fixer_id);
                foreach ($getfixer as $fix){
                    $m2 = date('m', strtotime($fix->created_at));
                    $y2 = date('Y', strtotime($fix->created_at));
                    if ($m1 == $m2 && $y1 == $y2) {
                        $numberfix++;
                    }
                }
            }
            if($numberfix !=0){
                $payment = new Payments();
                $payment->fixer_id = $fixer->fixer_id;
                $payment->number_fixed = $numberfix;
                $payment->amount = $request->amount;
                $payment->total = $request->amount * $numberfix;
                $payment->datepay = $request->datepay;
                $payment->dateline = $request->dateline;
                $payment->description = $request->description;
                $payment->save();
                return redirect('admin/payments')
                ->with('showAlertCreate', true);            }
        }
        return redirect('admin/payments')
        ->with('showAlertNo', true);
    }


    // public function getPay(Request $request)
    // {
    //  // Set your secret key
    //  Stripe::setApiKey(env('STRIPE_SECRET'));

    //  // dd($request->amount);
    //  try {
    //      // Create a PaymentIntent to charge a customer
    //      $paymentIntent = PaymentIntent::create([
    //          'amount' => $request->amount, // Example amount in cents
    //          'currency' => 'usd',
    //          'payment_method_types' => ['card'],
    //          'description' => 'Example Payment',
    //      ]);

    //      // Return client secret to frontend
    //      return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    //  } catch (ApiErrorException $e) {
    //      // Handle error
    //      return response()->json(['error' => $e->getMessage()], 500);
    //  }
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return view('payments.new');
    }

 
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
        $data = $request->only(['amount', 'datepay', 'dateline', 'description']);

        // Keep the total in sync with the (possibly changed) rate.
        if (array_key_exists('amount', $data)) {
            $data['total'] = (float) $data['amount'] * (int) $payment->number_fixed;
        }

        $payment->update($data);
        return redirect('admin/payments')->with('showAlertEdit', true);
    }

    public function makePayment(Request $request)
    {
        // Set your secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // dd($request->amount);
        try {
            // Create a PaymentIntent to charge a customer
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount, // Example amount in cents
                'currency' => 'usd',
                'payment_method_types' => ['card'],
                'description' => 'Example Payment',
            ]);

            // Return client secret to frontend
            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        } catch (ApiErrorException $e) {
            // Handle error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
