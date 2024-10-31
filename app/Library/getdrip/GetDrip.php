<?php
namespace App\Library\getdrip;

class GetDrip {

	public function getGetDripLists($apikey,$account_id){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.getdrip.com/v2/{$account_id}/tags",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/vnd.api+json',
		    'Accept: application/vnd.api+json',
		    'Authorization: Basic '.base64_encode($apikey)
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response);
		return @$response->tags;
	}

	// TO ADD THE SUBSCRIBER TO THE LIST.......
	public function AddContactInGetDrip($integrationskey,$account_id,$data){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.getdrip.com/v2/{$account_id}/subscribers",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>json_encode($data),
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Authorization: Basic '.base64_encode($integrationskey)
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);
	}
}
?>