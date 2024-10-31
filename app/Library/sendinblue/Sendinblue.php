<?php
namespace App\Library\sendinblue;

class Sendinblue {

    public function getSendinblueLists($integrationskey){
        $integrations_api_key = $integrationskey;; # put your credentials here
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.sendinblue.com/v3/contacts/lists?limit=10&offset=0&sort=desc',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'api-key: '.$integrations_api_key,
            'Cookie: __cf_bm=qUflVBVRgKwR5gKsInGYgY534d45Ehb5aVAwv0R7fyI-1678854454-0-AfzLUIFWK12cNAebqTQJf1srCct+e1GEIzexDhw4rIf4OLFjm7y8e8UeVdMl+erwnTa1ylDwgdAZgEasZCgqhqE='
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        return $response->lists;
    }

    // TO ADD THE SUBSCRIBER TO THE LIST.......
    public function AddContactInSendinblue($integrationskey,$data){
        $integrations_api_key = $integrationskey;  #"4a0c55786db0890"; # put your credentials here
        $data1 = '{
            "email": "'.$data['email'].'",
            "attributes": {
                "FNAME": "'.$data['first_name'].'",
                "LNAME": "'.$data['last_name'].'"
            },
            "emailBlacklisted": false,
            "smsBlacklisted": false,
            "listIds": ['.$data['list_id'].'],
            "updateEnabled": false
        }';

        // Create Contact
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.sendinblue.com/v3/contacts',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$data1,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'api-key: '.$integrations_api_key,
            'Cookie: __cf_bm=BB4BpL6rK7O6AH3IpIPJOVQs2tZPfz0sQfm2GEb4VQU-1678856454-0-AVSx7au+DhCKun57nW4+9vZqt66ZbUhzWhmUTCQOKTRQyy6GMVGTeKVPR4hpJpBtnZSwE8znG/tRBzoIlD58/5A='
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        // Add Contact to a List
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.sendinblue.com/v3/contacts/lists/'.$data['list_id'].'/contacts/add',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
                                  "ids": ['.$response->id.']
                                }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'api-key: '.$integrations_api_key,
            'Cookie: __cf_bm=BB4BpL6rK7O6AH3IpIPJOVQs2tZPfz0sQfm2GEb4VQU-1678856454-0-AVSx7au+DhCKun57nW4+9vZqt66ZbUhzWhmUTCQOKTRQyy6GMVGTeKVPR4hpJpBtnZSwE8znG/tRBzoIlD58/5A='
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}
?>