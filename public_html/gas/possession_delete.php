<?php
	include('errors_warnings.php');
	include('lock.php');
	include('strings.php');
	include('http_to_https.php');
	$dbh=connect_db();
	
	$user_check=$_SESSION['username'];
	$login_session=$_SESSION['username'];

	$pos_id=$_GET["pos_id"];
	$user_id=$_GET["user_id"];
	
	$pos_id = filter_var($pos_id, FILTER_SANITIZE_NUMBER_INT);
	$user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
	
	$sql_delete = "DELETE FROM possessionili WHERE pos_id='$pos_id'";	
	$sql = $dbh->prepare($sql_delete);
	$sql->bindParam('pos_id', $pos_id); 
	
	$result = $sql->execute();
	if ($result)
	{
		echo '<meta http-equiv="refresh" content="2;URL=customer_profile.php?user_id=' .$user_id.'" />';	
		echo '<h3 style="color:#013a89; margin-top:20px;">'.$delete_customer_success.'</h3></html>';
	}else
	{
		echo '<meta http-equiv="refresh" content="2;URL=customer_profile.php?user_id=' .$user_id.'" />';	
		echo '<h3 style="color:#013a89; margin-top:20px;">'.$delete_customer_error.'</h3></html>';
	} 
	
?>	

  