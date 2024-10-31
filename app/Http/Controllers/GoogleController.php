<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackFromGoogle()
    {
        try {
            $user = Socialite::driver('google')->user();
            // Check Users Email If Already There
            $users = User::where('email', $user->getEmail())->first();
            if (empty($users->email) && empty($users->id)) {
                return redirect('/')->with('error', trans('site.msg.not-found'));
            } else {
                Auth::loginUsingId($users->id);
            }
            return redirect('/admin/dashboard');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function verifyPurchaseCode(Request $request)
    {
        try {
            // Pass in the purchase code from the user
            $sale = 'xxxxxxx';
            // Example: Check if the purchase is still supported
            $supportDate = '2008548977';
            $supported = $supportDate > time() ? "Yes" : "No";
          }
          catch (Exception $ex) {
            // Print the error so the user knows what's wrong
              return $ex->getMessage();
          }
    }

    function getPurchaseCode($code) {
         //CODEGOOD.NET
      }
}
