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
      $sale = $this->getPurchaseCode($request->purchaseCode);
      // Example: Check if the purchase is still supported
      $supportDate = strtotime($sale->supported_until);
      $supported = $supportDate > time() ? "Yes" : "No";
    } catch (Exception $ex) {
      // Print the error so the user knows what's wrong
      return $ex->getMessage();
    }
  }

  function getPurchaseCode($code)
  {
    $personalToken = "ZlkqLefBKVMnBSZM6FwgnvfHr2w6nWaJ";
    //KUdJmP1rtS87y3KWyKpaX6xyjy48Kcjk
    // Surrounding whitespace can cause a 404 error, so trim it first
    $code = trim($code);
    // Make sure the code looks valid before sending it to Envato
    // This step is important - requests with incorrect formats can be blocked!
    if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $code)) {
      throw new Exception("Invalid purchase code");
    }
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code}",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 20,
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer {$personalToken}",
        "User-Agent: Purchase code verification script"
      )
    ));
    $response = @curl_exec($ch);
    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_errno($ch) > 0) {
      throw new Exception("Failed to connect: " . curl_error($ch));
    }
    switch ($responseCode) {
      case 404:
        throw new Exception("Invalid purchase code");
      case 403:
        throw new Exception("The personal token is missing the required permission for this script");
      case 401:
        throw new Exception("The personal token is invalid or has been deleted");
    }
    if ($responseCode !== 200) {
      throw new Exception("Got status {$responseCode}, try again shortly");
    }
    $body = @json_decode($response);
    if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
      throw new Exception("Error parsing response, try again");
    }
    return $body;
  }
}
