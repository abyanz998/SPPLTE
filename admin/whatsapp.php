<?php
	session_start();
	error_reporting(0);
	$phone = $_GET['phone'];
	$message = $_GET['text'];

	$key='d33118fee8ea054dc0390c387bdb91839f7b9d04d2bd34bf'; //this is demo key please change with your own key
	$url='http://116.203.191.58/api/send_message';
	$data = array(
		"phone_no"=> $phone,
		"key"     => $key,
		"message" => $message,
		"skip_link"	=>True // This optional for skip snapshot of link in message
	);
	
	$data_string = json_encode($data,1);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_VERBOSE, 0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
	curl_setopt($ch, CURLOPT_TIMEOUT, 360);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data_string),
		'Authorization: Basic dXNtYW5ydWJpYW50b3JvcW9kcnFvZHJiZWV3b293YToyNjM3NmVkeXV3OWUwcmkzNDl1ZA=='
	));
	$res=curl_exec($ch);
	curl_close($ch);
	
	if ($res == 'Success'){
		$_SESSION['notif'] = 'wa_sukses';
		if (!empty($_GET[thn_ajar]) && !empty($_GET[nis])){
			echo "<script>document.location.href='../index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]'</script>";	
		}elseif ((!empty($_GET[thn_ajar])) && (!empty($_GET[unit])) && (!empty($_GET[kelas]))){
			echo "<script>document.location.href='../index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&unit=$_GET[unit]&kelas=$_GET[kelas]'</script>";	
		}
		
		
			
	}else{
		$_SESSION['notif'] = 'wa_gagal';
		if (!empty($_GET[thn_ajar]) && !empty($_GET[nis])){
			echo "<script>document.location.href='../index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]'</script>";	
		}elseif ((!empty($_GET[thn_ajar])) && (!empty($_GET[unit])) && (!empty($_GET[kelas]))){
			echo "<script>document.location.href='../index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&unit=$_GET[unit]&kelas=$_GET[kelas]'</script>";	
		}
	}
?>
