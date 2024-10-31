<?php

namespace RachidLaasri\LaravelInstaller\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display the purchase code verify page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getAdminPage()
    {
        return view('vendor.installer.admin');
    }

    /**
     * Verify purchase code and store info.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function saveAdminDetails(Request $request)
    {
        // validate request
        $validated = $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'last_name' => 'required|string|max:100',
            'password' => 'required'
        ]);

		/*$verifiedLogFile = storage_path('verified');
		$dateStamp = date('Y/m/d h:i:sa');
		$message = trans('installer_messages.purchase_code.verified_msg').$dateStamp."\n";
		File::put($verifiedLogFile, $message);*/
		//return view('vendor.installer.welcome');

        DB::table('users')->insert([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'role' => 'admin',
            'credit' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        return redirect()->route('LaravelInstaller::cron');
    }

}
