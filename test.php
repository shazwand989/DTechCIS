<?php
require_once 'config/db.php';

function update_group()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/fetch-group',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Authorization:' . WHATSAPP_TOKEN
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
}

function list_group()
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/get-whatsapp-group',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Authorization:' . WHATSAPP_TOKEN
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;

    // reponse to array
    $data = json_decode($response, true);

    return $data;
}

$data = list_group();

echo '<pre>' . print_r($data, true) . '</pre>';
