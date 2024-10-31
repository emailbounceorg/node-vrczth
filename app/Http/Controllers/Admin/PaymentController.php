<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;

use App\Library\Paypal;
use App\Models\Settings;
use App\Models\User;
use App\Models\Payments;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;


class PaymentController extends Controller
{

    // Razorpay
    public function RazorpaySave(Request $request)
    {
        $this->Save(Auth::user()->id,  $request->type, $request->payment_id, $request->popCredit, $request->totalAmount);
        $this->CreditUpdate(Auth::user()->id, $request->popCredit);
        return response()->json(['status' => 200, 'msg' => trans('site.msg.payment'), 'url' => route('paymentHistory')]);
    }

    // stripe
    public function stripePayment(Request $request)
    {
        $Settings = Settings::latest()->first()->toArray();
        $stripe = new \Stripe\StripeClient($Settings['stripe_client_secret']);
        $stripe_metadata    = array(
            'address'       => '',
            'product_id'    => $request->popPrice,
            'sale_price'    => $request->popCredit,
            'email'         => $request->email,
            'currency' => 'USD',
        );

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'USD',
                    'product_data' => [
                        'name' => Auth::user()->name,
                    ],
                    'unit_amount' => $request->popPrice * 100,
                ],
                'quantity' => 1,
            ]],
            "metadata"    => $stripe_metadata,
            'mode'        => 'payment',
            'customer_email' => $request->email,
            'success_url' => route('stripeSuccess') . '?session_id={CHECKOUT_SESSION_ID}&UserID=' . Auth::user()->id . '&popCredit=' . $request->popCredit . '&popPrice=' . $request->popPrice,
            'cancel_url'  => route('PricingDetails'),
            'billing_address_collection' => 'auto',
        ]);

        return response()->json(['status' => 200, 'url' => $checkout_session->url]);
    }


    public function stripeSuccess(Request $request)
    {
        $this->Save($request->UserID,  'stripe', $request->session_id, $request->popCredit, $request->popPrice);
        $this->CreditUpdate($request->UserID, $request->popCredit);
        return redirect()->route('paymentHistory')->with('success', trans('site.msg.payment'));
    }

    // PayPal

    public function processPayPal(Request $request)
    {
        $checkout = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "reference_id" => uniqid() . rand(100, 999),
                    "amount" => [
                        "currency_code" => 'USD',
                        "value" => $request->popPrice,
                    ]
                ]
            ],
            "transaction_object " => 'payment on credit point',
            "payment_source" => [
                "paypal" => [
                    "experience_context" => [
                        "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
                        "payment_method_selected" => "PAYPAL",
                        "brand_name" => $request->APP_NAME,
                        "locale" => "en-US",
                        "landing_page" => "LOGIN",
                        'auto_bill_outstanding' => true,
                        "user_action" => "PAY_NOW",
                        'return_url' => route('successPaypal') . '?&UserID=' . Auth::user()->id . '&popCredit=' . $request->popCredit . '&popPrice=' . $request->popPrice,
                        "cancel_url" => route('PricingDetails'),
                    ]
                ]
            ]
        ];


        $listener = new Paypal();
        $result = $listener->Paypal_Create_Order($checkout);

        if (@$result->error_description) {
            return response()->json(['status' => 201, 'msg' => 'Server Error']);
        }
        if (@$result->links) {
            foreach ($result->links as $key => $value) {
                if ($value->rel == 'payer-action') {
                    return response()->json(['status' => 200, 'url' => $value->href]);
                }
            }
        }
    }


    public function successPaypal(Request $request)
    {
        $Settings = Settings::latest()->first()->toArray();
        $listener = new Paypal();
        $listener =  new Paypal($Settings['paypal_client_id'], $Settings['paypal_client_secret'], $Settings['paypal_type']);
        $result = $listener->Paypal_Capture_Order_Payment(@$_GET['token']);
        if (@$result['payment']->id) {
            $pay_id = $result['payment']->id;
            $this->Save($request->UserID,  'paypal', $pay_id, $request->popCredit, $request->popPrice);
            $this->CreditUpdate($request->UserID, $request->popCredit);
            return redirect()->route('paymentHistory')->with('success', trans('site.msg.payment'));
        }
    }


    public function Save($UserID,  $type, $pay_id, $credit, $amt)
    {
        Payments::create([
            'userID' => $UserID,
            'type' => $type,
            'pay_id' => $pay_id,
            'credit' => $credit,
            'amt' => $amt,
        ]);
    }

    public function CreditUpdate($UserID, $newCredit)
    {
        $user = User::where('id', $UserID)->first();
        $currentCredit = $user->credit;
        $newCredit = intval($currentCredit) + intval($newCredit);
        $user->update(['credit' => $newCredit]);
    }


    public function paymentHistory()
    {
        globalDashboardAssets();
        addVendors(['datatables', 'payment-history']);
        return view('dashboard.payment-history', ['title' => 'Payment History']);
    }

    public function paymentDatatable(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->role == 'user') {
                $data = Payments::latest()->where('userID', auth()->user()->id)->get();
            } else {
                $data = Payments::latest()->get();
            }
            return Datatables::of($data)->addIndexColumn()

                ->editColumn('userID', function ($row) {
                    $user =  User::where('id', $row->userID)->first();
                    return $user->name ?? '';
                })

                ->editColumn('credit', function ($row) {
                    return '<span class="badge lh-sm bg-primary">' . $row->credit . '</span>';
                })

                ->editColumn('amt', function ($row) {
                    return '<span class="badge lh-sm bg-success">' . $row->amt . '</span>';
                })

                ->editColumn('created_at', function ($row) {
                    return  $row->created_at->format('Y-m-d H:i:s');
                })

                ->addColumn('action', function ($row) {

                    return '<div class="btn-group btn-group-sm">
                                    <a href="' . URL::to('/admin/invoice/download/' . $row->id) . '" class="btn rounded lh-sm btn-success">
                                    <i class="bi bi-arrow-down-circle"></i>
                                    </a>
                                    <a href="' . URL::to('/admin/invoice/' . $row->id) . '" class="btn ms-2 rounded lh-sm btn-primary">
                                        <i class="bi bi-receipt-cutoff text-white"></i>
                                    </a>
                            </div>';
                })
                ->rawColumns(['userID', 'type', 'pay_id', 'credit', 'amt', 'created_at', 'action'])
                ->make(true);
        }
    }


    public function invoice($id)
    {
        $data = Payments::find($id);
        $user = User::find($data->userID);
        return view('dashboard.invoice', ['title' => 'invoice', 'data' => $data, 'user' => $user]);
    }

    public function download($id)
    {
        $data = Payments::find($id);
        $user = User::find($data->userID);
        $settings = Settings::latest()->first();
        $ar = ['title' => 'invoice', 'data' => $data, 'user' => $user, 'settings'=> $settings];

        $html = View::make('dashboard.invoice', $ar)->render();

        // Create a new instance of Dompdf
        $pdf = new Dompdf();

        // Load HTML into Dompdf
        $pdf->loadHtml($html);

        // Set paper size and orientation
        $pdf->setPaper('A4', 'landscape');

        // Render PDF
        $pdf->render();

        // Set the response headers to download the PDF file
        return $pdf->stream('invoice_'.time().'.pdf');
    }
}
