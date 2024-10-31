<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Settings;
use App\Models\User;
use App\Models\Defaultresponder;
use App\Models\Responders;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function __construct()
    {
        globalDashboardAssets();
    }

    public function index()
    {
        if (auth()->user()->role == 'user') {
            return redirect(route('home'));
        }

        addVendors(['settings']);
        return view('dashboard.settings', ['title' => 'Settings', 'arraySettings' => Settings::latest()->first()->toArray()]);
    }

    public function CreateUpdate(Request $request)
    {
        $validator = $request->validate([
            'emailCleaner'=>'required|email',
            'helpEmail' =>  $request->helpEmail != null ? 'email' : ''
        ],['helpEmail.email' => 'The Support Email have been a valid email address']);

        if (!empty($request->favicon)) {
            File::delete(public_path('img/logo/' . $request->faviconOLD));
            $filenameFavicon = time() . '.' . $request->favicon->extension();
            $request->favicon->move(public_path('img/logo'), $filenameFavicon);
        }

        if (!empty($request->logo)) {
            File::delete(public_path('img/logo/' . $request->logoOLD));
            $filenameLogo = time() . 'logo.' . $request->logo->extension();
            $request->logo->move(public_path('img/logo'), $filenameLogo);
        }

        Settings::updateOrCreate(


            [
                'id'   => $request->id ?? '',
            ],
            [
                'razorpay_on_off'     => $request->razorpay_on_off ?? '',
                'razorpay_key'     => $request->razorpay_key ?? '',
                'razorpay_secret'     => $request->razorpay_secret ?? '',

                'paypal_on_off'     => $request->paypal_on_off ?? '',
                'paypal_type'     => $request->paypal_type ?? '',
                'paypal_client_id'     => $request->paypal_client_id ?? '',
                'paypal_client_secret'     => $request->paypal_client_secret ?? '',

                'stripe_on_off'     => $request->stripe_on_off ?? '',
                'stripe_client_id'     => $request->stripe_client_id ?? '',
                'stripe_client_secret'     => $request->stripe_client_secret ?? '',
                'google_on_off'     => $request->google_on_off ?? '',
                'google_client_id'     => $request->google_client_id ?? '',
                'google_secret'     => $request->google_secret ?? '',
                'helpEmail'     => $request->helpEmail ?? '',
                'emailCleaner'     => $request->emailCleaner ?? '',
                'freeMail'     => $request->freeMail ?? '',
                'favicon'     => $filenameFavicon ?? $request->faviconOLD ?? '',
                'logo'     => $filenameLogo ?? $request->logoOLD ?? '',
                'themes_color'     => $request->themes_color ?? '',
                'timezones'     => $request->timezones ?? '',
                'default_credit_rate'     => $request->default_credit_rate ?? '',
            ],
        );

        return response()->json(['status' => 200, 'msg' => trans('site.msg.update'), 'url' => route('settings')]);
    }

    public function autoresponderSetting()
    {
        $user = User::where('role', 'admin')->get();
        $setting = Defaultresponder::first();
        if (!$setting) {
            $setting = new Defaultresponder();
        }

        $responders = Responders::where('userID', $setting->user_id)->get();

        addVendors(['responder-settings']);
        return view('dashboard.autoresponder', ['title' => 'Default Autoresponder Settings', 'users' => $user, 'setting' => $setting, 'responders' => $responders]);
    }

    public function autoresponderSettingSave(Request $request)
    {

        Defaultresponder::updateOrCreate(
            [
                'id'   => $request->id ?? '',
            ],
            [
                'user_id'       => $request->user_id,
                'responder_id'  => $request->Responder_name,
                'responder_list_id' => $request->responder_list
            ],
        );

        return response()->json(['status' => 200, 'msg' => trans('site.msg.update'), 'url' => route('autoresponder.setting')]);
    }

    public function TermsAndConditionsGet(Request $request)
    {
        $Settings = Settings::latest()->first();
        if ($request->name == 'terms') {
            echo $Settings->terms_and_conditions;
        } else {
            echo $Settings->privacy_policy;
        }
    }

    public function TermsAndConditions()
    {
        addVendors(['terms-conditions']);
        return view('dashboard.terms_and_conditions', ['title' => 'terms and conditions', 'settings' => Settings::latest()->first()]);
    }

    public function TermsAndConditionsUpdate(Request  $request)
    {
        Settings::updateOrCreate(
            [
                'id'   => $request->id ?? '',
            ],
            $request->all(),
        );

        return response()->json(['status' => 200, 'msg' => trans('site.msg.update'), 'url' => route('TermsAndConditions')]);
    }

    public function timezone()
    {
        addVendors(['Timezone']);
        return view('dashboard.timezone', ['title' => 'Timezone']);
    }

    public function updateTimezone(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'timezones' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        $user = User::find($request->id);
        $user->timezones = $request->timezones ?? '';
        $user->save();

        $response = array(
            'status' => 200,
            'msg' => trans('site.msg.update'),
            'url' => route('timezone'),
        );

        return response()->json($response);
    }


    public function invoiceSettings()
    {
        addVendors(['invoice']);
        return view('dashboard.invoice-settings', ['title' => 'Invoice Settings', 'settings' => Settings::latest()->first()]);
    }

    public function updateInvoiceSettings(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'address' => ['required'],
            'mobile' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        Settings::updateOrCreate(
            [
                'id'   => $request->id ?? '',
            ],
            $request->all(),
        );

        return response()->json(['status' => 200, 'msg' => trans('site.msg.update'), 'url' => route('invoiceSettings')]);
    }
}
