<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\EmailCleaner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Library\activecampaign\ActiveCampaign;
use App\Library\sendlane\Sendlane;
use App\Library\mailchimp\Mailchimp;
use App\Library\campaignmoniter\Campaignmoniter;
use App\Library\convertkit\ConvertKitApi;
use App\Library\icontact\iContactApi;
use App\Library\getdrip\GetDrip;
use App\Library\sendinblue\Sendinblue;
use App\Models\Defaultresponder;
use MailerLiteApi\MailerLite;
use MailWizzApi_Config;
use MailWizzApi_Base;
use MailWizzApi_Endpoint_Lists;
use MailWizzApi_Endpoint_ListSubscribers;

use Getresponse\Sdk\GetresponseClientFactory;
use Getresponse\Sdk\Operation\Campaigns\GetCampaigns\GetCampaigns;
use Getresponse\Sdk\Operation\Model\NewContact;
use Getresponse\Sdk\Operation\Model\CampaignReference;
use Getresponse\Sdk\Operation\Contacts\CreateContact\CreateContact;


use App\Models\Responders;
use App\Models\EmailFinishedList;

class RespondersController extends Controller
{
    public function __construct()
    {
        globalDashboardAssets();
    }

    public function nameTitileImg()
    {
        return array(
            array(
                'title'    => 'Active Campaign',
                'icon'    => asset('img/responders/activeCampaign.svg'),
                'key'    => 'activecampaign'
            ),
            array(
                'title'    => 'Sendlane',
                'icon'    => asset('img/responders/sendlane.svg'),
                'key'    =>  'sendlane'
            ),
            array(
                'title'    => 'MailChimp',
                'icon'    => asset('img/responders/mailchimp.svg'),
                'key'    => 'mailchimp'
            ),
            array(
                'title'    => 'GetResponse',
                'icon'    => asset('img/responders/getresponse.svg'),
                'key'    => 'getresponse'
            ),
            array(
                'title'    => 'Campaign Monitor',
                'icon'    => asset('img/responders/campaignmonitor.svg'),
                'key'    => 'campaignmonitor'
            ),
            array(
                'title'    => 'ConvertKit',
                'icon'    => asset('img/responders/convertkit.svg'),
                'key'    => 'convertkit'
            ),
            array(
                'title'    => 'ConstantContact',
                'icon'    => asset('img/responders/constant-contact.svg'),
                'key'    => 'constantcontact'
            ),
            array(
                'title'    => 'iContact',
                'icon'    => asset('img/responders/icontact.svg'),
                'key'    => 'icontact'
            ),
            array(
                'title'    => 'MailWizz EMA',
                'icon'    => asset('img/responders/mailwizz.svg'),
                'key'    => 'mailwizzema'
            ),
            // array(
            //     'title'    => 'Get Drip',
            //     'icon'    => asset('img/responders/getdrip.svg'),
            //     'key'    => 'getdrip'
            // ),
             array(
                 'title'    => 'Mailerlite',
                 'icon'    => asset('img/responders/mailerlite.svg'),
                 'key'    => 'mailerlite'
             ),
            // array(
            //     'title'    => 'Mautic',
            //     'icon'    => asset('img/responders/mautic.svg'),
            //     'key'    => 'mautic'
            // ),
            array(
                'title'    => 'SendinBlue',
                'icon'    => asset('img/responders/sendinblue.svg'),
                'key'    => 'sendinblue'
            ),
        );
    }

    public function InputFields()
    {
        return array(
            'activecampaign' => array(
                'api_access_url' => 'API Access URL',
                'api_access_key' => 'API Access Key'
            ),
            'sendlane' => array(
                'api_key' => 'API Key'
            ),
            'mailchimp' => array(
                'api_key' => 'API Key'
            ),
            'getresponse' => array(
                'api_key' => 'API Key'
            ),
            'campaignmonitor' => array(
                'api_key'         => 'API Key',
                'api_client_id' => 'API Client Id'
            ),
            'convertkit' => array(
                'api_key'         => 'API Key',
                'api_secret'     => 'API Secret'
            ),
            'constantcontact' => array(
                'api_key'         => 'API Key',
                'secret_key'     => 'Secret Key'
            ),
            'icontact' => array(
                'api_id'         => 'API Id',
                'user_name'     => 'User Name',
                'app_password'     => 'App Password'
            ),
            'mailwizzema' => array(
                'api_url'         => 'API URL',
                'public_key'     => 'Public Key'
            ),
            // 'getdrip' => array(
            //     'api_token'        => 'API Token',
            //     'account_id'    => 'Account Id'
            // ),
             'mailerlite' => array(
                 'api_key'    => 'API Key'
             ),
             //'mautic' => array(
            //     'base_url'        => 'Base URL',
            //     'public_key'    => 'Public Key',
            //     'secret_key'    => 'Secret Key'
            // ),
            'sendinblue' => array(
                'api_key'    => 'API Key'
            )
        );
    }


    public function index()
    {
        addVendors(['responders']);
        return view('dashboard.responders', ['title' => 'Auto Responders', 'nameTitileImg' => $this->nameTitileImg(), 'InputFields' => $this->inputFields()]);
    }

    public function respondersGetInput(Request $request)
    {
        $inputArray = $this->InputFields();
        foreach ($inputArray as $key => $value) {
            if ($key == $request->key) {
                $matches[] = $value;
            }
        }

        $Responders = Responders::where('userID', Auth::user()->id)->where('key', $request->key)->latest()->first();
        if (!empty($Responders)) {
            $data = array_values(json_decode($Responders->data, true));
            echo '<input type="hidden" name="id" id="id" value="' . $Responders->id . '">';
        }

        echo '<input type="hidden" name="title" value="' . $request->title . '">';
        echo '<input type="hidden" name="keyInput" value="' . $request->key . '">';

        $x = 0;
        foreach ($matches[0] as $key => $val) {
            if (empty($data)) {
                echo '<div class="col-md-3">
                                <label for="first-name-horizontal">' . $val . '</label>
                            </div>
                        <div class="col-md-9 form-group">
                            <input type="text" class="form-control" name="' . $key . '">
                        </div>';
            } else {
                echo '<div class="col-md-3">
                            <label for="first-name-horizontal">' . $val . '</label>
                        </div>
                    <div class="col-md-9 form-group">
                        <input type="text" class="form-control" value="' . $data[$x] . '" name="' . $key . '">
                    </div>';
            }
            $x++;
        }

        if( $request->key == 'constantcontact' ){
            echo '<div class="col-md-12 px-5">
                '.route('constantcontact.callback').'
                <p> Redirect URI that you should add in Constantcontact API Credential. </p>
            </div>';
        }
    }


    public function RespondersConfigSave(Request $request)
    {
        $input = $request->all();
        unset($input['id']);
        unset($input['_token']);
        unset($input['title']);
        unset($input['keyInput']);
        Responders::updateOrCreate(
            [
                'id'   => $request->id ?? '',
            ],
            [
                'userID'     => Auth::user()->id,
                'title'     => $request->title,
                'key'     => $request->keyInput,
                'data'     => json_encode($input),
            ]
        );

        if( $request->keyInput == 'constantcontact' ){
            $data = $this->constantcontactAuthenticationSetting( $request->api_key, $request->secret_key );
            return response()->json($data);
        }else{
            return response()->json(['status' => 200, 'msg' => trans('site.msg.create')]);
        }
    }


    public function getAutoResponders(Request $request)
    {
        $user_id = $request->user_id ? $request->user_id : Auth::user()->id;
        $Responders = Responders::where('userID', $user_id)->get();
        echo '<option value="" selected>--Select--</option>';
        foreach ($Responders as $Respond) {
            echo "<option value='$Respond->key' data-rowID='$request->rowID' data-url='" . route('DataResponder') . "'>$Respond->title</option>";
        }
    }

    public function apiGet($responder_key)
    {
        $Responders = Responders::where('userID', Auth::user()->id)->where('key', $responder_key)->first();
        return $api = json_decode($Responders->data, true);
    }

    private function toObject($Array) {
        $data = array();
        foreach ($Array as $key => $value) {
            $data[$key] = (object) $value;
        }
        return $data;
    }

    public function DataResponder(Request $request)
    {
        if (empty($request->responder_key)) {
            die('Empty Request');
        }

        $campaign_list = '';
        $responder = $request->responder_key;
        $api = $this->apiGet($responder);

        if ($responder == 'activecampaign') {
            $acobj = new ActiveCampaign();
            $campaign_list = $acobj->getActiveCampaignLists($api['api_access_url'], $api['api_access_key']);
        }

        if ($responder == 'sendlane') {
            $Sendlane = new Sendlane();
            $campaign_list = $Sendlane->getSendlaneLists($api['api_key']);
        }

        if ($responder == 'mailchimp') {
            $mailchimp = new Mailchimp($api['api_key']);
            $retval = $mailchimp->lists();
            $campaign_list = $retval['data'];
        }

        if( $responder == 'getresponse' ){
            $getresponse = GetresponseClientFactory::createWithApiKey($api["api_key"]);
            $campaignsOperation = new GetCampaigns();
            $getresponse_campaigns = $getresponse->call($campaignsOperation);
            $campaign_list = $this->toObject( $getresponse_campaigns->getData() );
        }

        if ($responder == 'campaignmonitor') {
            $campaignmoniter = new Campaignmoniter();
            $campaign_list = $campaignmoniter->getCampaignmoniterLists($api['api_client_id'], $api["api_key"]);
        }

        if ($responder == 'convertkit') {
            $convertkit = new ConvertKitApi();
            $campaign_list = $convertkit->getConvertKitForms($api['api_key']);
        }

        if( $responder == 'constantcontact' ){
            $client = new \PHPFUI\ConstantContact\Client($api['api_key'], $api['secret_key'], '');
            $client->accessToken = $api['access_token'];
            $client->refreshToken = $api['refresh_token'];
            $listEndPoint = new \PHPFUI\ConstantContact\V3\ContactLists($client);
            $autoresponder_lists = $listEndPoint->get();
            $campaign_list = $autoresponder_lists['lists'];
        }

        if ($responder == 'icontact') {
            iContactApi::getInstance()->setConfig(array(
                'appId' => $api['api_id'],
                'apiPassword' => $api['app_password'],
                'apiUsername' => $api['user_name'],
            ));
            $iContactApi = iContactApi::getInstance();
            $retval = $iContactApi->getLists();
            $campaign_list = $retval;
        }

        if($responder == 'mailwizzema'){
            $config = new MailWizzApi_Config(array(
                'apiUrl'        => $api['api_url'],
                'publicKey'     => $api['public_key'],
            ));
            MailWizzApi_Base::setConfig($config);
            $listsEndpoint = new MailWizzApi_Endpoint_Lists();
            $response = $listsEndpoint->getLists($pageNumber = 1, $perPage = 40);
            $campaign_list = $response->body['data']['records'];
        }

        if ($responder == 'getdrip') {
            $GetDrip = new GetDrip();
            $campaign_list = $GetDrip->getGetDripLists($api['api_token'], $api['account_id']);
        }

        if ($responder == 'sendinblue') {
            $sendinblue = new Sendinblue();
            $campaign_list = $sendinblue->getSendinblueLists($api["api_key"]);
        }
        if ($responder == 'mailerlite') {
            $mailerliteClient = new MailerLite($api["api_key"]);
            $groupsApi = $mailerliteClient->groups();
            $campaign_list = $groupsApi->get(); // returns array of groups
        }


        $html = '';
        if ($campaign_list) {
            if ($responder == 'activecampaign') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->id . '">' . $list->name . '</option>';
                endforeach;
            } elseif ($responder == 'sendlane') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->id . '">' . $list->name . '</option>';
                endforeach;
            } elseif ($responder == 'mailchimp') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list['id'] . '">' . $list['name'] . '</option>';
                endforeach;
            } elseif ($responder == 'getresponse') {
                foreach ($campaign_list as $key => $list) :
                    if (@$list->name) :
                        $html .= '<option value="' . $list->campaignId . '">' . $list->name . '</option>';
                    endif;
                endforeach;
            } elseif ($responder == 'campaignmonitor') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->ListID . '">' . $list->Name . '</option>';
                endforeach;
            } elseif ($responder == 'convertkit') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->id . '">' . $list->name . '</option>';
                endforeach;
            } elseif ($responder == 'constantcontact') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list['list_id'] . '">' . $list['name'] . '</option>';
                endforeach;
            } elseif ($responder == 'icontact') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->listId . '">' . $list->name . '</option>';
                endforeach;
            } elseif ($responder == 'mailwizzema') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list['general']['list_uid'] . '">' . $list['general']['name'] . '</option>';
                endforeach;
            } elseif ($responder == 'getdrip') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list . '">' . $list . '</option>';
                endforeach;
            } elseif ($responder == 'mailerlite') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->id . '">' . $list->name . '</option>';
                endforeach;
            } elseif ($responder == 'mautic') {
                foreach ($campaign_list as $id => $list) :
                    $html .= '<option value="' . $list['id'] . '">' . $list['name'] . '</option>';
                endforeach;
            } elseif ($responder == 'sendinblue') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->id . '">' . $list->name . '</option>';
                endforeach;
            }
        }else{
            $html .= '<option value="">No Data Available</option>';
        }

        return response()->json(['email_cleaner_id' => $request->email_cleaner_id, 'options' =>  $html]);
    }



    public function ResponderEmailSave(Request $request)
    {
        $api = $this->apiGet($request->Responder_name);
        $email_cleaner = EmailFinishedList::where('file_uploads_id', $request->email_cleaner_id)->where('status', 'Valid')->get();

        if ($request->Responder_name == 'activecampaign') {

            foreach ($email_cleaner as $key => $value) {
                if ($request->responder_list != "" && $value->email != "") {
                    $first_name = strstr($value->email, '@', true);
                    $last_name = '';

                    $data = array(
                        "contact" => array(
                            "email" => $value->email,
                            "firstName" => $first_name,
                            "lastName" => $last_name,
                            "phone" => "",
                        )
                    );

                    $activecampaign = new ActiveCampaign();
                    $activecampaign->addContactActiveCampaign($api['api_access_url'], $api['api_access_key'], $data, $request->responder_list);
                }
            }
            return response()->json(['status' => 200, 'msg' => trans('site.msg.push')]);
        } else if ($request->Responder_name == 'sendlane') {

            foreach ($email_cleaner as $key => $value) {
                if ($request->responder_list != "" && $value->email != "") {

                    $first_name = strstr($value->email, '@', true);
                    $last_name = '';

                    $Sendlane = new Sendlane();
                    $Sendlane->AddContactInSendlane($api["api_key"], $request->responder_list, $first_name, $last_name, $value->email);
                }
            }
            return response()->json(['status' => 200, 'msg' => trans('site.msg.push')]);

        } else if ($request->Responder_name == 'mailchimp') {

            foreach ($email_cleaner as $key => $value) {
                if ($request->responder_list != "" && $value->email != "") {

                    $first_name = strstr($value->email, '@', true);
                    $last_name = '';

                    $mailchimp = new Mailchimp($api['api_key']);


                    $mergeFields = array('FNAME' => $first_name, 'LNAME' => $last_name);
                    $mailchimp->MailChimpAddContact($value->email, 'subscribed', $request->responder_list, $api['api_key'], $mergeFields);
                }
            }
            return response()->json(['status' => 200, 'msg' => trans('site.msg.push')]);

        } else if ( $request->Responder_name == 'getresponse' ) {

            foreach ($email_cleaner as $key => $value) {
                if ($request->responder_list != "" && $value->email != "") {
                    $first_name = strstr($value->email, '@', true);
                    $last_name = '';

                    $api = GetresponseClientFactory::createWithApiKey($api["api_key"]);
                    $createContact = new NewContact(
                        new CampaignReference($request->responder_list),
                        $value->email
                    );
                    $createContact->setName($first_name . ' ' . $last_name);
                    $createContactOperation = new CreateContact($createContact);
                    $response = $api->call($createContactOperation);
                }
            }

            return response()->json(['status' => 200, 'msg' => trans('site.msg.push')]);

        } else if ($request->Responder_name == 'campaignmonitor') {

            foreach ($email_cleaner as $key => $value) {
                if ($request->responder_list != "" && $value->email != "") {

                    $first_name = strstr($value->email, '@', true);
                    $last_name = '';

                    $data = array(
                        'EmailAddress' => $value->email,
                        'Name' => $first_name . ' ' . $last_name,
                        'MobileNumber' => '',
                        'Resubscribe' => true,
                        'RestartSubscriptionBasedAutoresponders' => true,
                        'ConsentToTrack' => 'Yes'
                    );
                    $campaignmoniter = new Campaignmoniter();
                    $campaignmoniter->addContactInCampaignmoniter($api["api_client_id"], $api["api_key"], $data, $request->responder_list);
                }
            }
            return response()->json(['status' => 200, 'msg' => trans('site.msg.push')]);

        } else if ($request->Responder_name == 'convertkit') {

            foreach ($email_cleaner as $key => $value) {
                if ($request->responder_list != "" && $value->email != "") {

                    $first_name = strstr($value->email, '@', true);
                    $last_name = '';

                    $convertkit = new ConvertKitApi();

                    $data = array(
                        'api_secret' => $api['api_secret'],
                        'email' => $value->email,
                        'first_name' => $first_name
                    );
                   $convertkit->subscribeToAForm($api['api_key'], $data, $request->responder_list);
                }
            }
            return response()->json(['status' => 200, 'msg' => trans('site.msg.push')]);

        }else if ($request->Responder_name == 'constantcontact') {
            foreach ($email_cleaner as $key => $value) {
                if ($request->responder_list != "" && $value->email != "") {

                    $first_name = strstr($value->email, '@', true);
                    $last_name = '';

                    $this->ConstantContactInAddCampaign(
                        "",
                        $api["api_key"],
                        $api["access_token"],
                        $value->email,
                        $request->responder_list,
                        $first_name,
                        $last_name
                    );
                }
            }

            return response()->json(['status' => 200, 'msg' => trans('site.msg.push')]);

        } else if ($request->Responder_name == 'icontact') {

            foreach ($email_cleaner as $key => $value) {
                if ($request->responder_list != "" && $value->email != "") {

                    $first_name = strstr($value->email, '@', true);
                    $last_name = '';

                    iContactApi::getInstance()->setConfig(array(
                        'appId' => $api['api_id'],
                        'apiPassword' => $api['app_password'],
                        'apiUsername' => $api['user_name'],
                    ));

                    $iContactApi = iContactApi::getInstance();
                    $contactIds = $iContactApi->addContact($value->email, '', '', $first_name, $last_name);
                    $iContactApi->subscribeContactToList((int)$contactIds, $request->responder_list);
                }
            }
            return response()->json(['status' => 200, 'msg' => trans('site.msg.push')]);

        }else if ( $request->Responder_name == 'mailwizzema' ) {
        
        $config = new MailWizzApi_Config(array(
                'apiUrl'        => $api['api_url'],
                'publicKey'     => $api['public_key'],
            ));
            MailWizzApi_Base::setConfig($config);

            foreach ($email_cleaner as $key => $value) {
                if ($request->responder_list != "" && $value->email != "") {
                    $first_name = strstr($value->email, '@', true);
                    $last_name = '';
                    $subscribersEndpoint = new MailWizzApi_Endpoint_ListSubscribers();
                    $data = [
                        'EMAIL'    => $value->email,
                        'FNAME'    => $first_name,
                        'LNAME'    => $last_name
                    ];

                    $response = $subscribersEndpoint->create($request->responder_list, $data);
                }
            }
            return response()->json(['status' => 200, 'msg' => trans('site.msg.push')]);
        } else if ($request->Responder_name == 'getdrip') {

            foreach ($email_cleaner as $key => $value) {
                if ($request->responder_list != "" && $value->email != "") {

                    $first_name = strstr($value->email, '@', true);
                    $last_name = '';

                    $data = array(
                        "subscribers" => array(
                            array(
                                "email" => $value->email,
                                "first_name" => $first_name,
                                "last_name" => $last_name,
                                "tags" => array($request->responder_list),
                            )
                        )
                    );
                    $DripApi = new GetDrip();
                    $DripApi->AddContactInGetDrip($api["api_token"], $api["account_id"], $data);
                }
            }
            return response()->json(['status' => 200, 'msg' => trans('site.msg.push')]);

        } else if ($request->Responder_name == 'sendinblue') {

            foreach ($email_cleaner as $key => $value) {
                if ($request->responder_list != "" && $value->email != "") {

                    $first_name = strstr($value->email, '@', true);
                    $last_name = '';

                    $data = array(
                        "email" => $value->email,
                        "first_name" => $first_name,
                        "last_name" => $last_name,
                        "list_id" => $request->responder_list
                    );

                    $sendinblue = new Sendinblue();
                    $sendinblue->AddContactInSendinblue($api["api_key"], $data);
                }
            }

            return response()->json(['status' => 200, 'msg' => trans('site.msg.push')]);

        }

            else if ( $request->Responder_name == 'mailerlite' ){
                foreach ($email_cleaner as $key => $value) {
                    if ($request->responder_list != "" && $value->email != "") {
                        $first_name = strstr($value->email, '@', true);
                        $last_name = '';
                        $data = array(
                            "email" => $value->email,
                            "name" => $first_name.' '.$last_name
                        );
                        $mailerliteClient = (new \MailerLiteApi\MailerLite($api["api_key"]))->groups();
                        $subscriber = $data;
                        $mailerliteClient->addSubscriber($request->responder_list, $subscriber, 1);
                    }
                }
                return response()->json(['status' => 200, 'msg' => trans('site.msg.push')]);
            }
        return response()->json(['status' => 201, 'msg' => 'Server Error!']);
    }

    public function constantcontactAuthenticationSetting( $api_key, $secret_key ){
        if (session_status() === PHP_SESSION_NONE) {
            session_name('wplcar-constantcontact');
            session_start();
        }
        $redirectURI = route('constantcontact.callback');
        $client = new \PHPFUI\ConstantContact\Client($api_key, $secret_key, $redirectURI);
        $auth_url = $client->getAuthorizationURL();
        return ['status' => 200, 'msg' => 'Redirecting to the Constant Contact Portal', 'url'=> $auth_url];
    }

    public function constantcontactCallback(Request $request){
        if (session_status() === PHP_SESSION_NONE) {
            session_name('wplcar-constantcontact');
            session_start();
        }
        $credential = $this->apiGet('constantcontact');
        $apiKey = $credential['api_key'];
        $secret = $credential['secret_key'];

        $redirectURI = route('constantcontact.callback');
        $client = new \PHPFUI\ConstantContact\Client($apiKey, $secret, $redirectURI);

        $client->acquireAccessToken($_GET);
        $data = array(
            'api_key' => $apiKey,
            'secret_key' => $secret,
            'access_token' => $client->accessToken,
            'refresh_token' => $client->refreshToken
        );

        Responders::where('key', 'constantcontact')
            ->where('userID', Auth::user()->id)
            ->update(['data'=>$data]);

        return redirect()->route('responders')->with('success', trans('site.msg.create'));
    }

    protected function ConstantContactInAddCampaign( $apiKey,$userName,$accessToken,$email,$checkedCampaign,$userFirstName,$userLastName) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.cc.email/v3/contacts',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
                "email_address": {
                    "address": "'.$email.'",
                    "permission_to_send": "implicit"
                },
                "first_name": "'.$userFirstName.'",
                "last_name": "'.$userLastName.'",
                "create_source": "Contact",
                "list_memberships" : [ "'.$checkedCampaign.'" ]
            }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$accessToken
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return true;
    }

    public function pushEmail(Request $request)
    {
        $setting = Defaultresponder::first();
        $request['responder_list'] = $setting->responder_list_id;
        $api = $this->apiGet($setting->responder_id);
        if (!empty($setting) && !empty($request->email)) {
            if ($setting->responder_id == 'activecampaign') {
                if ($request->responder_list != "" && $request->email != "") {
                    $first_name = strstr($request->email, '@', true);
                    $last_name = '';
                    $data = array(
                        "contact" => array(
                            "email" => $request->email,
                            "firstName" => $first_name,
                            "lastName" => $last_name,
                            "phone" => "",
                        ),
                    );
                    $activecampaign = new ActiveCampaign();
                    $activecampaign->addContactActiveCampaign($api['api_access_url'], $api['api_access_key'], $data, $request->responder_list);
                }
            } else if ($request->Responder_name == 'sendlane') {
                if ($request->responder_list != "" && $request->email != "") {
                    $first_name = strstr($request->email, '@', true);
                    $last_name = '';
                    $Sendlane = new Sendlane();
                    $Sendlane->AddContactInSendlane($api["api_key"], $request->responder_list, $first_name, $last_name, $request->email);
                }
            } else if ($request->Responder_name == 'mailchimp') {
                if ($request->responder_list != "" && $request->email != "") {
                    $first_name = strstr($request->email, '@', true);
                    $last_name = '';
                    $mailchimp = new Mailchimp($api['api_key']);
                    $mergeFields = array('FNAME' => $first_name, 'LNAME' => $last_name);
                    $mailchimp->MailChimpAddContact($request->email, 'subscribed', $request->responder_list, $api['api_key'], $mergeFields);
                }
            } else if ($request->Responder_name == 'getresponse') {
                    if ($request->responder_list != "" && $request->email != "") {
                        $first_name = strstr($request->email, '@', true);
                        $last_name = '';
                        $api = GetresponseClientFactory::createWithApiKey($api["api_key"]);
                        $createContact = new NewContact(
                            new CampaignReference($request->responder_list),
                            $request->email
                        );
                        $createContact->setName($first_name . ' ' . $last_name);
                        $createContactOperation = new CreateContact($createContact);
                        $response = $api->call($createContactOperation);
                    }
            } else if ($request->Responder_name == 'campaignmonitor') {
                if ($request->responder_list != "" && $request->email != "") {
                    $first_name = strstr($request->email, '@', true);
                    $last_name = '';
                    $data = array(
                        'EmailAddress' => $request->email,
                        'Name' => $first_name . ' ' . $last_name,
                        'MobileNumber' => '',
                        'Resubscribe' => true,
                        'RestartSubscriptionBasedAutoresponders' => true,
                        'ConsentToTrack' => 'Yes',
                    );
                    $campaignmoniter = new Campaignmoniter();
                    $campaignmoniter->addContactInCampaignmoniter($api["api_client_id"], $api["api_key"], $data, $request->responder_list);
                }
            } else if ($request->Responder_name == 'convertkit') {
                if ($request->responder_list != "" && $request->email != "") {
                    $first_name = strstr($request->email, '@', true);
                    $last_name = '';
                    $convertkit = new ConvertKitApi();
                    $data = array(
                        'api_secret' => $api['api_secret'],
                        'email' => $request->email,
                        'first_name' => $first_name,
                    );
                    $convertkit->subscribeToAForm($api['api_key'], $data, $request->responder_list);
                }
            } else if ($request->Responder_name == 'constantcontact') {
                    if ($request->responder_list != "" && $request->email != "") {
                        $first_name = strstr($request->email, '@', true);
                        $last_name = '';
                        $this->ConstantContactInAddCampaign(
                            "",
                            $api["api_key"],
                            $api["access_token"],
                            $request->email,
                            $request->responder_list,
                            $first_name,
                            $last_name
                        );
                    }
            } else if ($request->Responder_name == 'icontact') {
                    if ($request->responder_list != "" && $request->email != "") {
                        $first_name = strstr($request->email, '@', true);
                        $last_name = '';
                        iContactApi::getInstance()->setConfig(array(
                            'appId' => $api['api_id'],
                            'apiPassword' => $api['app_password'],
                            'apiUsername' => $api['user_name'],
                        ));
                        $iContactApi = iContactApi::getInstance();
                        $contactIds = $iContactApi->addContact($request->email, '', '', $first_name, $last_name);
                        $iContactApi->subscribeContactToList((int) $contactIds, $request->responder_list);
                    }
            } else if ($request->Responder_name == 'getdrip') {
                    if ($request->responder_list != "" && $request->email != "") {
                        $first_name = strstr($request->email, '@', true);
                        $last_name = '';
                        $data = array(
                            "subscribers" => array(
                                array(
                                    "email" => $request->email,
                                    "first_name" => $first_name,
                                    "last_name" => $last_name,
                                    "tags" => array($request->responder_list),
                                ),
                            ),
                        );
                        $DripApi = new GetDrip();
                        $DripApi->AddContactInGetDrip($api["api_token"], $api["account_id"], $data);
                    }
            } else if ($request->Responder_name == 'sendinblue') {
                if ($request->responder_list != "" && $request->email != "") {
                    $first_name = strstr($request->email, '@', true);
                    $last_name = '';
                    $data = array(
                        "email" => $request->email,
                        "first_name" => $first_name,
                        "last_name" => $last_name,
                        "list_id" => $request->responder_list,
                    );
                    $sendinblue = new Sendinblue();
                    $sendinblue->AddContactInSendinblue($api["api_key"], $data);
                }
            } else if ($request->Responder_name == 'mailerlite') {
                if ($request->responder_list != "" && $request->email != "") {
                    $first_name = strstr($request->email, '@', true);
                    $last_name = '';
                    $data = array(
                        "email" => $request->email,
                        "name" => $first_name . ' ' . $last_name,
                    );
                    $mailerliteClient = (new \MailerLiteApi\MailerLite($api["api_key"]))->groups();
                    $subscriber = $data;
                    $mailerliteClient->addSubscriber($request->responder_list, $subscriber, 1);
                }
            }
        }
    }
}
