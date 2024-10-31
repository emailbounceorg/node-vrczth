<?php

use App\Models\Settings;
use Illuminate\Support\Facades\Schema;

if (!function_exists('theme')) {
    function theme()
    {
        return app(App\Core\Theme::class);
    }
}

if (!function_exists('addHtmlAttribute')) {
    /**
     * Add HTML attributes by scope
     *
     * @param $scope
     * @param $name
     * @param $value
     *
     * @return void
     */
    function addHtmlAttribute($scope, $name, $value)
    {
        theme()->addHtmlAttribute($scope, $name, $value);
    }
}


if (!function_exists('addHtmlAttributes')) {
    /**
     * Add multiple HTML attributes by scope
     *
     * @param $scope
     * @param $attributes
     *
     * @return void
     */
    function addHtmlAttributes($scope, $attributes)
    {
        theme()->addHtmlAttributes($scope, $attributes);
    }
}


if (!function_exists('addHtmlClass')) {
    /**
     * Add HTML class by scope
     *
     * @param $scope
     * @param $value
     *
     * @return void
     */
    function addHtmlClass($scope, $value)
    {
        theme()->addHtmlClass($scope, $value);
    }
}


if (!function_exists('printHtmlAttributes')) {
    /**
     * Print HTML attributes for the HTML template
     *
     * @param $scope
     *
     * @return string
     */
    function printHtmlAttributes($scope)
    {
        return theme()->printHtmlAttributes($scope);
    }
}


if (!function_exists('printHtmlClasses')) {
    /**
     * Print HTML classes for the HTML template
     *
     * @param $scope
     * @param $full
     *
     * @return string
     */
    function printHtmlClasses($scope, $full = true)
    {
        return theme()->printHtmlClasses($scope, $full);
    }
}

if (!function_exists('getGlobalAssets')) {
    /**
     * Get the global assets
     *
     * @param $type
     *
     * @return array
     */
    function getGlobalAssets($type = 'js')
    {
        return theme()->getGlobalAssets($type);
    }
}


if (!function_exists('addVendors')) {
    /**
     * Add multiple vendors to the page by name. Refer to settings THEME_VENDORS
     *
     * @param $vendors
     *
     * @return void
     */
    function addVendors($vendors)
    {
        theme()->addVendors($vendors);
    }
}


if (!function_exists('includeFavicon')) {
    /**
     * Include favicon from settings
     *
     * @return string
     */
    function includeFavicon()
    {
        return theme()->includeFavicon();
    }
}

if (!function_exists('addVendor')) {
    /**
     * Add single vendor to the page by name. Refer to settings THEME_VENDORS
     *
     * @param $vendor
     *
     * @return void
     */
    function addVendor($vendor)
    {
        theme()->addVendor($vendor);
    }
}


if (!function_exists('addJavascriptFile')) {
    /**
     * Add custom javascript file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addJavascriptFile($file)
    {
        theme()->addJavascriptFile($file);
    }
}


if (!function_exists('addCssFile')) {
    /**
     * Add custom CSS file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addCssFile($file)
    {
        theme()->addCssFile($file);
    }
}


if (!function_exists('getVendors')) {
    /**
     * Get vendor files from settings. Refer to settings THEME_VENDORS
     *
     * @param $type
     *
     * @return array
     */
    function getVendors($type)
    {
        return theme()->getVendors($type);
    }
}


if (!function_exists('getCustomJs')) {
    /**
     * Get custom js files from the settings
     *
     * @return array
     */
    function getCustomJs()
    {
        return theme()->getCustomJs();
    }
}


if (!function_exists('getCustomCss')) {
    /**
     * Get custom css files from the settings
     *
     * @return array
     */
    function getCustomCss()
    {
        return theme()->getCustomCss();
    }
}


if (!function_exists('getHtmlAttribute')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param $scope
     * @param $attribute
     *
     * @return array
     */
    function getHtmlAttribute($scope, $attribute)
    {
        return theme()->getHtmlAttribute($scope, $attribute);
    }
}

if (!function_exists('isUrl')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param $url
     *
     * @return mixed
     */
    function isUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}

if (!function_exists('image')) {
    /**
     * Get image url by path
     *
     * @param $path
     *
     * @return string
     */
    function image($path)
    {
        return asset('admin/assets/images/' . $path);
    }
}

function globalDashboardAssets()
{
    return addVendors(['global-dashboard-assets']);
}

function authAssets()
{
    return addVendors(['auth']);
}

function pre($ar)
{
    echo "<pre>";
    print_r($ar);
}

function pageTitle()
{
    return explode('/', $_SERVER['REQUEST_URI']);
}

function pageTitle2($title)
{
    return explode('?', $title);
}

function noReplyArray($emails)
{
    return array_filter($emails, function ($email) {
        return (strpos($email, "noreply") !== false
            || strpos($email, "no-reply") !== false
            || strpos($email, "no_reply") !== false
            || strpos($email, "donotreply") !== false
            || strpos($email, "do-not-reply") !== false
            || strpos($email, "noreplymail") !== false
            || strpos($email, "noreplyaddress") !== false
            || strpos($email, "noreplymessage") !== false
            || strpos($email, "noreplyfeedback") !== false
            || strpos($email, "no-replymail") !== false
            || strpos($email, "no-replyaddress") !== false
            || strpos($email, "no-replymessage") !== false
            || strpos($email, "no-replyfeedback") !== false
            || strpos($email, "auto-reply") !== false
            || strpos($email, "automated-reply") !== false
            || strpos($email, "mailer-daemon") !== false
            || strpos($email, "no_reply_mail") !== false
            || strpos($email, "no_reply_address") !== false
            || strpos($email, "no_reply_message") !== false
            || strpos($email, "no_reply_feedback") !== false
        );
    });
}

function roleBaseArray($emails)
{
    $rolebase_emails = array_filter($emails, function ($email) {
        return (strpos($email, "mailer-daemon") !== false
            || strpos($email, "bounce") !== false
            || strpos($email, "support") !== false
            || strpos($email, "info") !== false
            || strpos($email, "sales") !== false
            || strpos($email, "contact") !== false
            || strpos($email, "marketing") !== false
            || strpos($email, "webmaster") !== false
            || strpos($email, "admin") !== false
            || strpos($email, "abuse") !== false
            || strpos($email, "security") !== false
            || strpos($email, "service") !== false
            || strpos($email, "helpdesk") !== false
            || strpos($email, "feedback") !== false
            || strpos($email, "newsletter") !== false
            || strpos($email, "billing") !== false
            || strpos($email, "customerservice") !== false
            || strpos($email, "memberservice") !== false
            || strpos($email, "unsubscribe") !== false
            || strpos($email, "register") !== false
            || strpos($email, "enquiry") !== false
            || strpos($email, "booking") !== false
            || strpos($email, "reservation") !== false
            || strpos($email, "confirmation") !== false
            || strpos($email, "notification") !== false
            || strpos($email, "alerts") !== false
            || strpos($email, "updates") !== false
            || strpos($email, "news") !== false
            || strpos($email, "media") !== false
            || strpos($email, "press") !== false
            || strpos($email, "career") !== false
            || strpos($email, "job") !== false
            || strpos($email, "hr") !== false
            || strpos($email, "recruitment") !== false
            || strpos($email, "apply") !== false
            || strpos($email, "resume") !== false
            || strpos($email, "cv") !== false
            || strpos($email, "recruiter") !== false
            || strpos($email, "employment") !== false
            || strpos($email, "hiring") !== false
            || strpos($email, "temp") !== false
            || strpos($email, "staffing") !== false
            || strpos($email, "tempagency") !== false
            || strpos($email, "contractor") !== false
            || strpos($email, "vendor") !== false
            || strpos($email, "partner") !== false
            || strpos($email, "affiliate") !== false
            || strpos($email, "support") !== false
        );
    });
    return array_values($rolebase_emails);
}

function DisposableArray($emails)
{
    $disposable_emails = array_filter($emails, function ($email) {
        return (strpos($email, "tempmail") !== false
            || strpos($email, "mailinator") !== false
            || strpos($email, "guerrillamail") !== false
            || strpos($email, "sharklasers") !== false
            || strpos($email, "discard") !== false
            || strpos($email, "fakeinbox") !== false
            || strpos($email, "mytemp") !== false
            || strpos($email, "temp-mail") !== false
            || strpos($email, "10minutemail") !== false
            || strpos($email, "anonbox") !== false
        );
    });
    return array_values($disposable_emails);
}


function validEmailArray($emails)
{
    return array_filter($emails, function ($email) {
        return (strpos($email, "noreply") === false
            && strpos($email, "no-reply") === false
            && strpos($email, "no_reply") === false
            && strpos($email, "donotreply") === false
            && strpos($email, "do-not-reply") === false
            && strpos($email, "noreplymail") === false
            && strpos($email, "noreplyaddress") === false
            && strpos($email, "noreplymessage") === false
            && strpos($email, "noreplyfeedback") === false
            && strpos($email, "no-replymail") === false
            && strpos($email, "no-replyaddress") === false
            && strpos($email, "no-replymessage") === false
            && strpos($email, "no-replyfeedback") === false
            && strpos($email, "auto-reply") === false
            && strpos($email, "automated-reply") === false
            && strpos($email, "mailer-daemon") === false
            && strpos($email, "no_reply_mail") === false
            && strpos($email, "no_reply_address") === false
            && strpos($email, "no_reply_message") === false
            && strpos($email, "no_reply_feedback") === false
        );
    });
}

function extractDomain($email)
{
    $parts = explode('@', $email); // Split email address by @ symbol
    return $parts[1]; // Return the domain part of the email address
}

function nestedLowercase($value)
{
    if (is_array($value)) {
        return array_map('nestedLowercase', $value);
    }
    return strtolower($value);
}

function versionSystem(){
    return '2.3.2';
}

if (!function_exists('getLogo')) {
    function getLogo()
    {
        if (Schema::hasTable('settings')) {
            $data = Settings::latest()->first();
            if (!empty($data->logo) && !empty($data->favicon)) {
                return  [
                    'logo' => asset('img/logo/' . $data->logo),
                    'favicon' => asset('img/logo/' . $data->favicon),
                    'version' => versionSystem(),
                    'themes_color' => $data->themes_color,
                ];
            } else {
                return  [
                    'logo' => asset('img/logo.png'),
                    'favicon' => asset('img/favicon.png'),
                    'version' => versionSystem(),
                    'themes_color' => '#FF564E',
                ];
            }
        } else {
            return  [
                'logo' => asset('img/logo.png'),
                'favicon' => asset('img/favicon.png'),
                'version' => versionSystem(),
                'themes_color' => '#FF564E',
            ];
        }
    }
}

function removeNullArray($array) {
    return !empty(array_filter($array, function($value) {
        return $value !== null;
    }));
}

function encode($id, $key = "")
{
    $len = 10;
    $md5_key = (!empty($key) ? md5($key) : md5('!7l@S*3h7_s54P-e543lp'));
    $len_jobid = 16;
    $sub_md5key1 = substr($md5_key, 0, $len);
    $sub_md5key2 = substr($md5_key, $len);
    return $sub_md5key1 . $id . $sub_md5key2;
}

function decode($encodeid, $vauletype = 'integer')
{
    $strRet = "";
    $len = 10;
    $sub_md5key1 = substr($encodeid, 0, $len);
    $sub_md5key2 = substr($encodeid, -1 * (32 - $len));
    $strRet = str_replace(array($sub_md5key1, $sub_md5key2), '', $encodeid);
    if ($vauletype == 'integer')
        $strRet = (int) $strRet;
    else
        $strRet = $strRet;

    return $strRet;
}
function sanitizeInput($input)
{
    return is_string($input) ? htmlentities(strip_tags(trim($input))) : $input;
}
