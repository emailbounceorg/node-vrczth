<?php
namespace App\Library\convertkit;

class ConvertKitApi
{

    // here we create convert kit tags
    public function getConvertKitForms($api_key){

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.convertkit.com/v3/tags?api_key='.$api_key,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Cookie: XSRF-TOKEN=RW53gZNo%2BSYTrDQOg0x9dxtwmFN4fx0M3mFGi6xuIjmO1C%2F8zwrRHwSrr0u4IEQYDSTiRh71IDt1XHb9Ufdx3g%3D%3D; _mailapp_session=K0JKRnVVa1JEbmppclQrdUpVRDRwSWdCNC8wdTk1Q2NMcG03S3VJaTJzei9GaVczckwzdXdJUmFFSmNkVUVoSllJTTJJd2RwaDBGaXRjN0dTOE91dEJZNzFXSmNSaXM3MUZVL2UxR3BpOVV4cStGZHpEQTJuWHo4N3FHM1F4WHNVVHNkMmh5cnlJWEFCNUFxek94a0ZSSE1hL04rQUtiMTAvYW5OMFdpUnNNamZzVjRRU1MyVnYzQ0I1cWUrUkNDLS1yUVk4YTNYWFRNWjZGVUV5RE1EbWxBPT0%3D--8712d5c69fc2277f93b587097191b460a9d028f8'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        return @$response->tags;
    }


    // Add subscriber to convert in tag
    public function subscribeToAForm($api_key, $data, $list)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.convertkit.com/v3/tags/{$list}/subscribe",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $data,
          CURLOPT_HTTPHEADER => array(
            'Cookie: XSRF-TOKEN=xXsDiTnyMJ5RkHj8hp8E965C5HQorkqrTVLqUFVJhjAOwVv0ZZAYp0aX47m98z2YuBaeYU4kd5zmb9omqNDV1w%3D%3D; _mailapp_session=SHJaZ0tvVmtwR2k2WlJiUEhPR3JYRU9pK1BnSE0xSUNhcGJkbVNpeUZGNVRXTitiN2VxeFhuaVBvM1FaTFNwcHpiL1p5TCtBZWhjbW1Iczc4YzhpdEVyM0tDZDVpMnNIMkVvVkJtNkVabGlsTXoySjJnODBqVGtMRVVTM0R3cWJhd2RrMDk5ZnNOZU9sRTZzTU5jU1lBbmtZcGVhZVlDNVd5blpVNmljVm1jUHYrRDREMTd0SzhEa3o5ZEdicit2LS01cW1aVmJpYm9Tci9RVjBjTXRaN1B3PT0%3D--7ae709f6d2e842d42ffd8c1f39713bd07e8f44d9'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}