<?php 
	include('errors_warnings.php');
	include('connect.php');
	include('strings.php');
	include('http_to_https.php');
	session_start();
	$dbh=connect_db();
	
	$match = 0;
	
	if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
		// Verify data
		$email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
		$hash = filter_var($_GET['hash'], FILTER_SANITIZE_STRING);
		
		$sql = $dbh->prepare("SELECT * FROM usersili WHERE email='$email' AND hash='$hash' AND active=0");
		$sql->execute();
		$result = $sql->fetchAll();
		foreach ($result as $row)
		{
			$match++;
		}

		if ($match > 0) 
		{
			// We have a match, activate the account
			$yes = 1;
			$stmt = $dbh->prepare("UPDATE usersili SET active='$yes' WHERE email='$email' AND hash='$hash' AND active=0");
			$stmt->bindParam(':active', $yes);
			$result = $stmt->execute();
			if ($result)
			{
				echo '<h3 style="color:#013a89; margin-top:20px;">'.$verify_success.'</h3></html>';
			}else 
			{
				echo '<html><head><META http-equiv="refresh" content="2;URL=index.php"></head>';
				echo '<h3 style="color:#013a89; margin-top:20px;">'.$verify_error.'</h3></html>';
			}
		}else
		{
			// No match -> invalid url or account has already been activated.
			echo '<h3 style="color:#013a89; margin-top:20px;">'.$verify_error1.'</h3></html>';
		}				 
	}else
	{
		// Invalid approach
		echo '<html><head><META http-equiv="refresh" content="4;URL=index.php"></head>';
		echo '<h3 style="color:#013a89; margin-top:20px;">'.$verify_error2.'</h3></html>';
	}	
?>