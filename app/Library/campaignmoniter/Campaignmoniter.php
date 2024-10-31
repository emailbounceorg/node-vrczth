<?php
namespace App\Library\campaignmoniter;

class Campaignmoniter {

	public function getCampaignmoniterLists($client_id,$api_key){
		$endpoint = "https://api.createsend.com/api/v3.3/clients/{$client_id}/lists.json";
		// Set the headers
		$headers = array(
		    'Authorization: Basic ' . base64_encode($api_key . ':x'),
		    'Content-Type: application/json'
		);
		// Send the request to the API
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);

		// Decode the response
		return json_decode($response);
	}

	public function addContactInCampaignmoniter( $client_id, $api_key, $data, $list_id )
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.createsend.com/api/v3.3/subscribers/{$list_id}.json",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>json_encode($data),
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Basic '.base64_encode($api_key.':x'),
		    'Content-Type: application/json',
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return json_decode($response);

	}

}
?>