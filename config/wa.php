<?php 

function send($no,$cn)
{
    $n = '62' . ltrim($no, '0');
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
    		CURLOPT_URL => 'https://whatsapp-apps.herokuapp.com/send-message',
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_ENCODING => '',
    		CURLOPT_MAXREDIRS => 10,
    		CURLOPT_TIMEOUT => 0,
    		CURLOPT_FOLLOWLOCATION => true,
    		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    		CURLOPT_POSTFIELDS => "number=$n&message=$cn",
    		CURLOPT_CUSTOMREQUEST => 'POST',
    	));
    
    $response = curl_exec($curl);
    curl_close($curl);
    // if (!empty($response)) {
    // 	echo $response;
    // }
}

?>