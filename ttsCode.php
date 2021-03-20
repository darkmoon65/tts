#!/usr/bin/php
<?php

require_once ('phpagi.php');
$agi = new AGI();

$apiKey = "R_3F1fdc_XkJ9WX3VZ6S8y-L_q_wN_QOz1BGmGTJdVaH";
$apiUrl = "https://api.us-south.text-to-speech.watson.cloud.ibm.com/instances/7574d201-24f6-40ce-89c3-f4c816ba7edd/v1/synthesize?accept=audio%2Fwav&text=hola%20mundo&voice=es-ES_EnriqueV3Voice";

$curl = curl_init();

curl_setopt ( $curl, CURLOPT_URL, $apiUrl);
curl_setopt ( $curl, CURLOPT_GET, 1 );
curl_setopt( $curl, CURLOPT_USERPWD, 'apikey'.':'.$apiKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ( $curl, CURLOPT_HTTPHEADER, array('Accept: audio/wav','Content-Type: application/json'));
$result =  curl_exec( $curl);
$wr = fopen('audio.wav');
fwrite($wr, $result);

?>
