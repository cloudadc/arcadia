<?php

	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$domainName = $_SERVER['HTTP_HOST'];
	$backend = "app3";	
	
	if(empty($_GET['user_name']) || empty($_GET['email']) || empty($_GET['bank_id']))
	{
		header('HTTP/1.1 500 No Variables');
		exit();
	}
	
	$user_name = $_GET['user_name'];
	$bank_id = $_GET['bank_id'];
	$email = $_GET['email'];
	
	$query = '{"email":"'.$email.'","dir":"1","bank_id":"'.$bank_id.'","user_name":"'.$user_name.'"}';
	
	$url = $protocol.$backend.'/app3/record_request.php';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	if (isset($_SERVER['HTTP_X_MESH_REQUEST_ID'])) {
		$random_spanid = bin2hex( random_bytes(8) );
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"X-Mesh-Request-ID: " . $_SERVER['HTTP_X_MESH_REQUEST_ID'],
			"X-B3-TraceId: " . $_SERVER['HTTP_X_B3_TRACEID'],
			"X-B3-SpanId: " . $random_spanid,
			"X-B3-ParentSpanId: " . $_SERVER['HTTP_X_B3_SPANID'],
			"X-B3-Sampled: " . $_SERVER['HTTP_X_B3_SAMPLED'],
			'Content-Type: application/json'
		));
	} else {
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	}
	$result = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);
	
	
	if ($info["http_code"] == "200")
	{
		echo $result;
	}
	if ($info["http_code"] == "501")
	{
		header('HTTP/1.1 500 Wrong Format');
		exit();
	}	


?>
