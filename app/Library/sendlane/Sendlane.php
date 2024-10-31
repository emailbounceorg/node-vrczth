<?php
namespace App\Library\sendlane;
class Sendlane {

	public function getSendlaneLists($integrationskey){
		$integrations_api_key = $integrationskey;; # put your credentials here
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.sendlane.com/v2/lists',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Bearer '.$integrations_api_key
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);
		return $response->data;
	}

	// TO ADD THE SUBSCRIBER TO THE LIST.......
	public function AddContactInSendlane($integrationskey,$listId,$firstname,$lastname,$emailid){
		$integrations_api_key = $integrationskey;  #"4a0c55786db0890"; # put your credentials here
		$list_id = $listId;
		$collect_leads_fname = $firstname; // andy
		$collect_leads_lname = $lastname; // ideologi
		$collect_leads_email = $emailid;  // email to be inserted to list
		$data = '{
			"contacts": [
			    {
			      "email": "'.$collect_leads_email.'",
			      "first_name": "'.$collect_leads_fname.'",
			      "last_name": "'.$collect_leads_lname.'"
			    }
			]
		}';
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.sendlane.com/v2/lists/{$list_id}/contacts",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>$data,
		  CURLOPT_HTTPHEADER => array(
		  	'Content-Type: application/json',
		    'Authorization: Bearer '.$integrations_api_key
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
	}
}
