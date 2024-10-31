<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use App\Notifications\ForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        authAssets();
    }

    public function index()
    {
        if (!empty(auth()->user()->id)) {
            return redirect(route('home'));
        }
        $social = Settings::latest()->first();
       

        addVendors(['login-register']);
        return view('auth.login', ['social' => $social]);
    }

    public function customLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => [
                'required',
                'string',
                'min:6',
            ],
            'terms_and_conditions_privacy_policy' => ['required'],
        ]);

        $customMessages = [
            'terms_and_conditions_privacy_policy.required' => 'You must agree with the terms and conditions.',
        ];

        $validator->setCustomMessages($customMessages);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::getProvider()->retrieveByCredentials($credentials);
            Auth::login($user, $request->remember_me);
            return response()->json(['status' => 200, 'msg' => trans('site.msg.login'), 'url' => route('home')]);
        } else {
            return response()->json(['status' => 201, 'msg' => trans('site.msg.loginInvalid')]);
        }
    }

    public function registration()
    {
        if (!empty(auth()->user()->id)) {
            return redirect(route('home'));
        }

        addVendors(['login-register']);
        return view('auth.registration');
    }

    public function customRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:6',
            ],
            'terms_and_conditions_privacy_policy' => ['required'],
        ]);

        $customMessages = [
            'terms_and_conditions_privacy_policy.required' => 'You must agree with the terms and conditions.',
        ];

        $validator->setCustomMessages($customMessages);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        $data = $request->all();
        $this->create($data);
        $credentials = $request->only('email', 'password');

        Auth::attempt($credentials);
        $response = array('status' => 200,
            'msg' => trans('site.msg.register'),
            'url' => route('home'),
            'arPushEmailUrl' => route('responder.pushEmail'),
            'email' => $request->email,
        );
        return response()->json($response);
    }

    public function create(array $data)
    {
        $ar = Settings::latest()->first()->toArray();
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'credit' => $ar['freeMail'] ?? '',
        ]);
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect(route('login'));
    }

    public function forgotPassword(Request $request)
    {
        if (!empty(auth()->user()->id)) {
            return redirect(route('home'));
        }

        addVendors(['login-register']);
        return view('auth.forgot-password', ['title' => 'Forgot password']);
    }

    public function forgotPasswordSendLink(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (empty($user) || empty($user->email)) {
            return response()->json(['status' => 201, 'errors' => ['email' => ['Please enter a valid email address']]]);
        } else {
            $user->notify(new ForgotPassword(route('passwordReset', encode($user->id))));
            return response()->json(['status' => 200, 'msg' => 'Please check your email for further instructions...', 'url' => route('login')]);
        }
    }

    public function passwordReset(Request $request)
    {
        if (!empty(auth()->user()->id)) {
            return redirect(route('home'));
        }

        if (empty(decode($request->id))) {
            Session::flash('error', 'Please try again!');
            return redirect('/');
        }
        addVendors(['login-register']);
        return view('auth.password-reset', ['title' => 'Password Reset', 'id' => $request->id]);
    }

    public function passwordResetSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'min:6',
            'NewPassword' => 'required_with:password|same:password|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 201, 'errors' => $validator->errors(), 'msg' => $validator->errors()->first()]);
        }

        $id = decode($request->id);
        $user = User::find($id);

        if (empty($user->email) && empty($user->id)) {
            return response()->json(['status' => 201, 'errors' => ['password' => ['Account Not found']], 'msg' => 'Account Not found']);
        } else {
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['status' => 200, 'msg' => 'Your password has been reset successfully', 'url' => route('login')]);
        }
    }

}
