<?php

	include('errors_warnings.php');
	include('lock.php');
	include('copyright.php');
	include('strings.php');
	include('http_to_https.php');
	
	include "phpqrcode/qrlib.php";  
	$tank_id=$_GET["tank_id"];	
	$tank_id = filter_var($tank_id, FILTER_SANITIZE_NUMBER_INT);
	
	QRcode::png('https://zafora.icte.uowm.gr/~ictest00446/gas/tank_moreinfo.php?id='.$tank_id);
	
?>