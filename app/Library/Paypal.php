<?php

namespace App\Library;
use App\Models\Settings;

class Paypal
{
    public $client_id = '';
    public $secret_key = '';
    public $access_token = '';
    public $URL = '';
    public $URL_V1 = '';
    public $URL_V2 = '';
    public $OAUTH2_URL = '';

    public function __construct($client_id = '', $secret_key = '', $paypal_mode = '')
    {
        $Settings = Settings::latest()->first()->toArray();
        $this->client_id    = $Settings['paypal_client_id'];
        $this->secret_key   = $Settings['paypal_client_secret'];
        $this->URL_V2       = $Settings['paypal_type'] == 'live' ? 'https://api-m.paypal.com/v2/' : 'https://api-m.sandbox.paypal.com/v2/';
        $this->URL_V1       = $Settings['paypal_type'] == 'live' ? 'https://api-m.paypal.com/v1/' : 'https://api-m.sandbox.paypal.com/v1/';
        $this->access_token = $this->Paypal_oauth2_token()->access_token;
    }

    public function Paypal_oauth2_token()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->URL_V1 . 'oauth2/token');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERPWD, $this->client_id . ":" . $this->secret_key);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $result = json_decode(curl_exec($curl));
        curl_close($curl);
        if (@$result->access_token) {
            return $result;
        }
        return false;
    }


    public function Paypal_Create_Order($post_feilds)
    {
        if (@$post_feilds && @$this->access_token) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->URL_V2 . 'checkout/orders');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_feilds));

            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: Bearer ' . $this->access_token;
            $headers[] = 'Paypal-Request-Id: ' . uniqid() . rand(100, 999);
            $headers[] = 'Prefer: return=representation';
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            return $result;
        }
        return false;
    }


    public function Paypal_Order_Details($order_id)
    {
        if (@$order_id && @$this->access_token) {
            $curl = curl_init($this->URL_V2 . 'checkout/orders/' . $order_id);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $this->access_token,
                'Accept: application/json'
            ));
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            return $result;
        }
        return false;
    }


    public function Paypal_Capture_Order_Payment($order_id)
    {
        if (@$order_id && @$this->access_token) {
            $return = [];
            $order = $this->Paypal_Order_Details($order_id);
            if (@$order->id) {
                $reference_id = $order->purchase_units[0]->reference_id;
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $this->URL_V2 ."checkout/orders/$order_id/capture");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_ENCODING, '');
                curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
                curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');

                $headers = array();
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Authorization: Bearer ' . $this->access_token;
                $headers[] = 'Paypal-Request-Id: ' . $reference_id;
                $headers[] = 'Prefer: return=representation';
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                $result = json_decode(curl_exec($curl));
                curl_close($curl);
                $return['order'] = $result;
                if (@$result->id) {
                    if (@$result->purchase_units[0]->payments->captures[0]->id) {
                        $capture_id = $result->purchase_units[0]->payments->captures[0]->id;
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $this->URL_V2 ."payments/captures/$capture_id");
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curl, CURLOPT_ENCODING, '');
                        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
                        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');

                        $headers = array();
                        $headers[] = 'Content-Type: application/json';
                        $headers[] = 'Authorization: Bearer ' . $this->access_token;
                        $headers[] = 'Paypal-Request-Id: ' . $reference_id;
                        $headers[] = 'Prefer: return=representation';
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                        $payments = json_decode(curl_exec($curl));
                        curl_close($curl);
                        $return['payment'] = $payments;
                    }
                }
            }
            return $return;
        }
        return false;
    }



    public function Paypal_Create_Product($post_feilds)
    {
        if (@$post_feilds && @$this->access_token) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->URL_V1 . 'catalogs/products');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_feilds));

            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: Bearer ' . $this->access_token;
            $headers[] = 'Paypal-Request-Id: ' . uniqid() . rand(100, 999);
            $headers[] = 'Prefer: return=representation';
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            if (@$result->id) {
                return $result->id;
            }
        }
        return false;
    }


    public function Paypal_Create_Plan($post_feilds)
    {
        if (@$post_feilds && @$this->access_token) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->URL_V1 . 'billing/plans');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_feilds));

            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: Bearer ' . $this->access_token;
            $headers[] = 'Paypal-Request-Id: ' . uniqid() . rand(100, 999);
            $headers[] = 'Prefer: return=representation';
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            if (@$result->id) {
                return $result->id;
            }
            // return array('error_msg' => $result->message);
        }
        return false;
    }


    public function Paypal_Create_Subscription($post_feilds)
    {
        if (@$post_feilds && @$this->access_token) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->URL_V1 . 'billing/subscriptions');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_feilds));

            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: Bearer ' . $this->access_token;
            $headers[] = 'Paypal-Request-Id: ' . uniqid() . rand(100, 999);
            $headers[] = 'Prefer: return=representation';
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            return $result;
        }
        return false;
    }


    public function Paypal_Subscription_Details($subscription_id)
    {
        if (@$subscription_id && @$this->access_token) {
            $curl = curl_init($this->URL_V1 . 'billing/subscriptions/' . $subscription_id);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $this->access_token,
                'Accept: application/json'
            ));
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            return $result;
        }
        return false;
    }


    public function Paypal_Subscription_Transactions($subscription_id, $end_time = NULL)
    {
        if (@$subscription_id && @$this->access_token) {

            $subscription = $this->Paypal_Subscription_Details($subscription_id);
            if ($end_time == NULL) {
                $end_time = date('Y-m-d', strtotime('+ 1 day')) . 'T00:00:00Z';
            }
            $curl = curl_init($this->URL_V1 . "billing/subscriptions/$subscription_id/transactions?start_time=$subscription->create_time&end_time=$end_time");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_ENCODING, '');
            curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
            curl_setopt($curl, CURLOPT_TIMEOUT, 0);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $this->access_token,
                'Accept: application/json'
            ));

            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            return $result;
        }

        return false;
    }


    public function Paypal_Get_Payment_Details($capture_id)
    {
        if (@$capture_id && @$this->access_token) {
            $curl = curl_init($this->URL_V2 . 'payments/captures/' . $capture_id);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $this->access_token,
                'Accept: application/json'
            ));

            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            return $result;
        }
        return false;
    }


    public function Paypal_Refund($payment_id)
    {
        if (@$payment_id && @$this->access_token) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->URL_V2 . "payments/captures/$payment_id/refund",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Prefer: return=representation',
                    'Authorization: Bearer ' . $this->access_token
                ),
            ));
            $result = json_decode(curl_exec($curl));
            curl_close($curl);
            return $result;
        }
        return false;
    }


    public function Paypal_Cancel_Subscription($subscription_id)
    {
        if (@$subscription_id && @$this->access_token) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->URL_V1 . "billing/subscriptions/$subscription_id/cancel",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                                        "reason": "Cancelled"
                                    }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $this->access_token
                ),
            ));
            $result = json_decode(curl_exec($curl));
            $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            if ($status_code == 204) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function Paypal_Payment_Capture($result)
    {
        $amount = $result->amount;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->URL_V2 . 'payments/' . $result->id . '/capture');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "amount=" . $amount);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->client_id . ":" . $this->secret_key);
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = json_decode(curl_exec($ch));
        if (@$result->status) {
            return $result->status;
        } elseif (@$result->error->description == 'This payment has already been captured') {
            return 'captured';
        } else {
            false;
        }
    }
}
