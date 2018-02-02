<?php
	include('errors_warnings.php');
	include('lock.php');
	include('http_to_https.php');
	$dbh=connect_db();
	
	$user_check=$_SESSION['username'];
	$login_session=$_SESSION['username'];

	$hash=$_GET["hash"];
	$id=$_GET["id"];
	
	$hash = filter_var($hash, FILTER_SANITIZE_STRING);
	$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
	
	$sql_delete = "DELETE FROM photosili WHERE hash='$hash'";	
	$sql = $dbh->prepare($sql_delete);
	$sql->bindParam('hash', $hash); 
	$sql->execute();
	
	$directory = 'tanks_photos/'.$hash;
	unlink($directory);
	
	echo '<meta http-equiv="refresh" content="1;URL=tank_moreinfo.php?id=' .$id. '" />';	
?>	