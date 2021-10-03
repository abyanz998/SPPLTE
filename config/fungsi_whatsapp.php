<?php
$phone = $_GET['phone'];
$message = $_GET['text'];

$key_demo = 'db63f52c1a00d33cf143524083dd3ffd025d672e255cc688';
$url = 'http://149.28.156.46:8000/demo/send_message';
$data = array(
	"phone_no" => '+62082194273124',
	"key"     => $key_demo,
	"message" => $message
);

$data_string = json_encode($data, 1);

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
$res = curl_exec($ch);
curl_close($ch);


function send($message)
{
	$key_demo = 'db63f52c1a00d33cf143524083dd3ffd025d672e255cc688';
	$url = 'http://149.28.156.46:8000/demo/send_message';
	$data = array(
		"phone_no" => '+62082194273124',
		"key"     => $key_demo,
		"message" => $message
	);

	$data_string = json_encode($data, 1);

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
	$res = curl_exec($ch);
	curl_close($ch);
	
}
