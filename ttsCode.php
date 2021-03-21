#!/usr/bin/php
<?php

require_once ('phpagi.php');
$agi = new AGI();


function consultaIbm($qr){
        $apiKey = 'R_3F1fdc_XkJ9WX3VZ6S8y-L_q_wN_QOz1BGmGTJdVaH';
        $apiUrl = 'https://api.us-south.text-to-speech.watson.cloud.ibm.com/instances/7574d201-24f6-40ce-89c3-f4c816ba7edd/v1/synthesize?accept=audio%2Fwav&text='.$qr.'&voice=es-ES_EnriqueV3Voice';
    
        $curl = curl_init();
        curl_setopt ( $curl, CURLOPT_URL, $apiUrl);
        curl_setopt ( $curl, CURLOPT_HTTPGET, 1 );
        curl_setopt( $curl, CURLOPT_USERPWD, 'apikey'.':'.$apiKey);
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
        $result =  curl_exec( $curl);

        return $result;
}

// LLamada a la api de consultas
if (isset($argv[1])){
    $head = array();
    $head[] = 'Content-type: application/json';
    //$head[] = 'Authorization: ApiUser Aitue-web1q2w3e4r.,';
    $username = 'ApiUser';
    $password = 'Aitue-web1q2w3e4r.,';
    $query = $argv[1];
    $urlConsulta = 'https://projects.sofgem.cl/consulta/atencion/?rut='.$query;
    
    $ch = curl_init();
    curl_setopt ( $ch , CURLOPT_URL, $urlConsulta);
    curl_setopt ( $ch , CURLOPT_HTTPGET, 1 );
    curl_setopt( $ch , CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt ( $ch , CURLOPT_HTTPHEADER, $head);
    curl_setopt( $ch , CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch );
    curl_close($ch );
    $newData = json_decode($data, true);
    
    if( $newData['estado'] == true){
        $fecha = $newData['datos']['fecha'];
        $hora = $newData['datos']['Hora'];
        $medico = $newData['datos']['medico'];
        $especialidad = $newData['datos']['especialidad'];
        $paciente = $newData['datos']['paciente'];
        $correo_paciente = $newData['datos']['correo_paciente'];
        $mesage = 'medico, '.$medico. ', especialidad, '.$especialidad.', paciente, '.$paciente.', correo del paciente, '.$correo_paciente;
        $encodeMesage = urlencode($mesage);
        
        $result = consultaIbm($encodeMesage);
        echo("listo");
        $wr = fopen('audio2.wav',"w");
        fwrite($wr, $result);
    }else{
        echo $newData['mensaje'];
        $message = $newData['mensaje'];
        $encodeMesage = urlencode($message);
        $result = consultaIbm($encodeMesage);
        echo("listo 2");
        $wr = fopen('audio3.wav',"w");
        fwrite($wr, $result);
    }
}else{
    echo "Ingrese rut";
    $message = "Ingrese rut";
    $encodeMesage = urlencode($message);
    $result = consultaIbm($encodeMesage);
    echo("listo 2");
    $wr = fopen('audio3.wav',"w");
    fwrite($wr, $result);
    $agi->answer();
    $agi->stream_file($work_dir."/audio3");
}

?>