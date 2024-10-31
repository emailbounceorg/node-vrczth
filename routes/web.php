<?php

use App\Http\Controllers\InstallHelperController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\WebGuard;

Route::get('/', [AuthController::class, 'index'])->name('login');

if (file_exists(storage_path('installed'))) {
    Route::get('/', [AuthController::class, 'index'])->name('login')->middleware('prevent-back-button');
} else {
    Route::get('/', function () {
        return redirect('/install');
    });
}

Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [AuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');

// forgotPassword
Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('login.forgotPassword');
Route::post('send-link', [AuthController::class, 'forgotPasswordSendLink'])->name('SendLink')->middleware('MailGuard');
Route::get('password-reset/{id}', [AuthController::class, 'passwordReset'])->name('passwordReset');
Route::post('password-change-save', [AuthController::class, 'passwordResetSave'])->name('passwordResetSave');


Route::get('signout', [AuthController::class, 'signOut'])->name('signout');

Route::post('/purchasecodeverify', [App\Http\Controllers\GoogleController::class, 'verifyPurchaseCode'])->name('purchasecodeverify');

// VerifyEmailAddress demo
Route::post('verify-email-address', [App\Http\Controllers\VerifyEmailAddress::class, 'VerifyEmail'])->name('VerifyEmailAddress');

// Google URL
Route::prefix('google')->name('google.')->group(function () {
    Route::get('login', [App\Http\Controllers\GoogleController::class, 'loginWithGoogle'])->name('loginWithGoogle')->middleware('socialsetting');
    Route::any('callback', [App\Http\Controllers\GoogleController::class, 'callbackFromGoogle'])->name('callback')->middleware('socialsetting');
});

Route::get('lang/{lang}', [\App\Http\Controllers\Admin\HomeController::class, 'switchLang'])->name('lang.switch');

Route::prefix('admin')->middleware([WebGuard::class,'prevent-back-button'])->group(function () {
    // EmailController
    Route::get('/dashboard', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
    Route::post('/payment-analysis', [\App\Http\Controllers\Admin\HomeController::class, 'paymentAnalysis'])->name('paymentAnalysis');
    Route::get('/upload', [\App\Http\Controllers\Admin\EmailController::class, 'index'])->name('upload');
    Route::get('/createUpdate', [\App\Http\Controllers\Admin\EmailController::class, 'createUpdate'])->name('createUpdate');
    Route::post('/upload-save', [\App\Http\Controllers\Admin\EmailController::class, 'upload'])->name('email-upload');
    Route::post('/email-mapping', [\App\Http\Controllers\Admin\EmailController::class, 'emailMapping'])->name('email-mapping');
    Route::get('/restart-queue/{id}', [\App\Http\Controllers\Admin\EmailController::class, 'restartQueue'])->name('restart-queue');

    // VerifyEmailAddress text box
    Route::post('/email-cleaner', [\App\Http\Controllers\VerifyEmailAddress::class, 'index'])->name('email-cleaner');
    Route::post('/email-cleaner-check', [\App\Http\Controllers\VerifyEmailAddress::class, 'checkEmail'])->name('email-cleaner-check');

    Route::get('/processed-list', [\App\Http\Controllers\Admin\EmailController::class, 'FinishedView'])->name('FinishedView');
    Route::any('/check-queue-progress', [\App\Http\Controllers\Admin\EmailController::class, 'checkQueueProgress'])->name('checkQueueProgress');
    Route::any('/finished-datatable', [\App\Http\Controllers\Admin\EmailController::class, 'FinishedDtatable'])->name('FinishedDtatable');

    Route::any('finished/clean-details/{id}', [\App\Http\Controllers\Admin\EmailController::class, 'CleanDetails'])->name('CleanDetails');
    Route::any('downloadCsv', [\App\Http\Controllers\Admin\EmailController::class, 'downloadCsv'])->name('downloadCsv');

    Route::post('finished-list-delete', [\App\Http\Controllers\Admin\EmailController::class, 'Delete']);
    Route::post('chart', [\App\Http\Controllers\Admin\EmailController::class, 'chart']);
    Route::any('checkQueueStatus', [\App\Http\Controllers\Admin\EmailController::class, 'checkQueueStatus']);


    // PricingControllers
    Route::get('pricing', [\App\Http\Controllers\Admin\PricingControllers::class, 'index'])->name('pricing');
    Route::get('pricing-details', [\App\Http\Controllers\Admin\PricingControllers::class, 'PricingDetails'])->name('PricingDetails');
    Route::post('pricing-create-update', [\App\Http\Controllers\Admin\PricingControllers::class, 'PricingCreateUpdate'])->name('PricingCreateUpdate');
    Route::post('pricing-list-delete', [\App\Http\Controllers\Admin\PricingControllers::class, 'Delete']);
    Route::any('pricing-datatable', [\App\Http\Controllers\Admin\PricingControllers::class, 'PricingDatatable'])->name('PricingDatatable');

    // PaymentController
    Route::any('payment-save', [\App\Http\Controllers\Admin\PaymentController::class, 'RazorpaySave'])->name('RazorpaySave');

    Route::post('stripe-payment', [\App\Http\Controllers\Admin\PaymentController::class, 'stripePayment'])->name('stripePayment');
    Route::any('/stripe-success', [\App\Http\Controllers\Admin\PaymentController::class, 'stripeSuccess'])->name('stripeSuccess');

    Route::any('/process-paypal', [\App\Http\Controllers\Admin\PaymentController::class, 'processPayPal'])->name('processPayPal');
    Route::any('/success-paypal', [\App\Http\Controllers\Admin\PaymentController::class, 'successPaypal'])->name('successPaypal');
    Route::any('/cancel-paypal', [\App\Http\Controllers\Admin\PaymentController::class, 'cancelPaypal'])->name('cancelPaypal');

    Route::any('/payment-history', [\App\Http\Controllers\Admin\PaymentController::class, 'paymentHistory'])->name('paymentHistory');
    Route::any('/payment-datatable', [\App\Http\Controllers\Admin\PaymentController::class, 'paymentDatatable'])->name('paymentDatatable');
    Route::any('/invoice/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'invoice'])->name('invoice');
    Route::any('/invoice/download/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'download'])->name('invoiceDownload');

    // UsersControllers
    Route::get('users', [\App\Http\Controllers\Admin\UsersControllers::class, 'index'])->name('users');
    Route::post('user-update', [\App\Http\Controllers\Admin\UsersControllers::class, 'UserUpdate'])->name('UserUpdate');
    Route::any('users-datatable', [\App\Http\Controllers\Admin\UsersControllers::class, 'UsersDatatable'])->name('UsersDatatable');
    Route::post('user-list-delete', [\App\Http\Controllers\Admin\UsersControllers::class, 'Delete']);

    // RespondersController
    Route::get('responders', [\App\Http\Controllers\Admin\RespondersController::class, 'index'])->name('responders');
    Route::post('responders-get-input', [\App\Http\Controllers\Admin\RespondersController::class, 'respondersGetInput'])->name('respondersGetInput');
    Route::post('responders-config-save', [\App\Http\Controllers\Admin\RespondersController::class, 'RespondersConfigSave'])->name('RespondersConfigSave');

    Route::post('get-responders', [\App\Http\Controllers\Admin\RespondersController::class, 'getAutoResponders'])->name('getAutoResponders');
    Route::post('responder-data', [\App\Http\Controllers\Admin\RespondersController::class, 'DataResponder'])->name('DataResponder');
    Route::post('responder-email-save', [\App\Http\Controllers\Admin\RespondersController::class, 'ResponderEmailSave'])->name('ResponderEmailSave');

    //one email send by admin user register
    Route::post('responder-push-email', [\App\Http\Controllers\Admin\RespondersController::class, 'pushEmail'])->name('responder.pushEmail');

    // SettingController
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings');
    Route::post('create-update', [\App\Http\Controllers\Admin\SettingController::class, 'CreateUpdate'])->name('CreateUpdate');


    // SMTPSettingsController
    Route::get('smtp-settings', [\App\Http\Controllers\Admin\SMTPSettingsController::class, 'index'])->name('SMTPSettings');
    Route::post('smtp-update', [\App\Http\Controllers\Admin\SMTPSettingsController::class, 'UpdateSMTP'])->name('UpdateSMTP');
    Route::post('aws-update', [\App\Http\Controllers\Admin\SMTPSettingsController::class, 'UpdateAWS'])->name('UpdateAWS');
    Route::post('email-send-test', [\App\Http\Controllers\Admin\SMTPSettingsController::class, 'testEmail'])->name('testEmail')->middleware('MailGuard');

    Route::get('autoresponder-settings', [\App\Http\Controllers\Admin\SettingController::class, 'autoresponderSetting'])->name('autoresponder.setting');
    Route::post('autoresponder-setting-save', [\App\Http\Controllers\Admin\SettingController::class, 'autoresponderSettingSave'])->name('autoresponder.setting.save');

    Route::get('terms-&-privacy-policy', [\App\Http\Controllers\Admin\SettingController::class, 'TermsAndConditions'])->name('TermsAndConditions');
    Route::post('terms-and-conditions-update', [\App\Http\Controllers\Admin\SettingController::class, 'TermsAndConditionsUpdate'])->name('TermsAndConditionsUpdate');

    // timezone
    Route::get('timezone', [\App\Http\Controllers\Admin\SettingController::class, 'timezone'])->name('timezone');
    Route::post('timezone-update', [\App\Http\Controllers\Admin\SettingController::class, 'updateTimezone'])->name('updateTimezone');

    // invoiceSettings
    Route::get('invoice-settings', [\App\Http\Controllers\Admin\SettingController::class, 'invoiceSettings'])->name('invoiceSettings');
    Route::post('invoice-settings-update', [\App\Http\Controllers\Admin\SettingController::class, 'updateInvoiceSettings'])->name('updateInvoiceSettings');

});
Route::post('terms-and-privacy-policy-get', [\App\Http\Controllers\Admin\SettingController::class, 'TermsAndConditionsGet'])->name('TermsAndConditionsGet');
Route::any('constantcontact-callback', [\App\Http\Controllers\Admin\RespondersController::class, 'constantcontactCallback'])->name('constantcontact.callback');
