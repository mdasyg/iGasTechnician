<?php 
	include('errors_warnings.php');
	include('lock.php');
	include('strings.php');
	include('http_to_https.php');
	$dbh=connect_db();
	
	$user_check=$_SESSION['username'];
	$login_session=$_SESSION['username'];

	$not_id=$_GET["not_id"];
	$not_id = filter_var($not_id, FILTER_SANITIZE_NUMBER_INT);
	
	$yes = 1;

	$sql_delete = "UPDATE eventsili SET reminder_seen = $yes WHERE id='$not_id'";	
	$sql = $dbh->prepare($sql_delete);
	$sql->bindParam(':reminder_seen', $yes); 
	
	$result = $sql->execute();
	if ($result)
	{
		echo '<meta http-equiv="refresh" content="0;URL=notifications.php" />';	
	}else
	{
		echo '<meta http-equiv="refresh" content="2;URL=notifications.php" />';	
		echo '<h3 style="color:#013a89; margin-top:20px;">'.$delete_notif_error.'</h3></html>';
	}
?>  