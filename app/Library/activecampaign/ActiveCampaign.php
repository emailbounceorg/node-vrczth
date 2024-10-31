<?php
namespace App\Library\activecampaign;
class ActiveCampaign {

	public function getActiveCampaignLists($api_url,$api_key)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $api_url.'/api/3/lists',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Accept: application/json',
		    'Api-Token: '.$api_key,
		    'Cookie: PHPSESSID=9a75afe720b916522be2d71373ed1a06; em_acp_globalauth_cookie=55c15a14-882c-4b3a-a414-be6fac8a61a2'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);
		return $response->lists;
	}

	public function getActiveCampaignCustomFields($api_url, $api_key)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $api_url.'/api/3/fields?limit=100',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Accept: application/json',
		    'Api-Token: '.$api_key,
		    'Cookie: PHPSESSID=57e9bb3fc0f91924c622840eaa67eae2; em_acp_globalauth_cookie=607a85c2-90b2-4092-a362-3d4707a7a50a'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);

	}

	public function addContactActiveCampaign( $api_url, $api_key, $data, $list_id )
	{
		// Add Contact
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $api_url.'/api/3/contacts',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>json_encode($data),
		CURLOPT_HTTPHEADER => array(
		    'Accept: application/json',
		    'Api-Token: '.$api_key,
		    'Content-Type: application/json',
		    'Cookie: PHPSESSID=9a75afe720b916522be2d71373ed1a06; em_acp_globalauth_cookie=9527d729-018f-458f-bd63-bf524889039e'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);

		// Link with the List
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://ommuneitsolutionsprivatelimited1678775154.api-us1.com/api/3/contactLists',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		    "contactList": {
		        "list": '.$list_id.',
		        "contact": '.$response->contact->id.',
		        "status": 1
		    }
		}',
		  CURLOPT_HTTPHEADER => array(
		    'Api-Token: '.$api_key,
		    'Content-Type: application/json',
		    'Cookie: PHPSESSID=9a75afe720b916522be2d71373ed1a06; em_acp_globalauth_cookie=e973118b-e4b6-420a-81f9-abd24cb43d57'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);
	}

}
