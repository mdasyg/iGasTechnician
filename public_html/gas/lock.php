<?php
	include('errors_warnings.php');
	include('connect.php');
	session_start();
	$dbh=connect_db();

	if(isset($_SESSION['username']) && isset($_SESSION['password']))
	{
		$user_check=$_SESSION['username'];
		$login_session=$_SESSION['username'];
	}else{
        header( 'Location: index.php' );
	}
?>
