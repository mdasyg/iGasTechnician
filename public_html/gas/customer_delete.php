<?php
	include('errors_warnings.php');
	include('lock.php');
	include('strings.php');
	include('http_to_https.php');
	$dbh=connect_db();
	
	$user_check=$_SESSION['username'];
	$login_session=$_SESSION['username'];

	$user_id=$_GET["user_id"];
	$user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
	
	$sql_delete = "DELETE FROM usersili WHERE user_id='$user_id'";	
	$sql = $dbh->prepare($sql_delete);
	$sql->bindParam('user_id', $user_id); 
	
	$result = $sql->execute();
	if ($result)
	{
		echo '<meta http-equiv="refresh" content="2;URL=customers.php" />';	
		echo '<h3 style="color:#013a89; margin-top:20px;">'.$delete_customer_success.'</h3></html>';
	}else
	{
		echo '<meta http-equiv="refresh" content="2;URL=customers.php" />';	
		echo '<h3 style="color:#013a89; margin-top:20px;">'.$delete_customer_error.'</h3></html>';
	} 
	
?>	

