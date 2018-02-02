<?php	
	include('errors_warnings.php');
	include('connect.php');
	include('strings.php');
	include('http_to_https.php');
	session_start();
	
	$dbh=connect_db();
	$error="";
	
	if(isset($_SESSION['url'])) 
	{
		$url = $_SESSION['url']; // holds url for last page visited.
	}else 
	{
		$url = "menu.php"; // default page for 
	}
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// username and password sent from Form 
		$myusername=addslashes($_POST['username']);  // addslashes gia asfaleia
		$mypassword=addslashes($_POST['password']); 
		
		//filter_var all variables
		$myusername = filter_var($myusername, FILTER_SANITIZE_STRING);
		$mypassword = filter_var($mypassword, FILTER_SANITIZE_STRING);
	
		$sql = $dbh->prepare("SELECT username,password,type,active FROM usersili WHERE username='$myusername'");
		$sql->execute();
		$result = $sql->fetchAll();
		foreach ($result as $row)
		{
			$password = $row['password'];
			$type = $row['type'];
			$active = $row['active'];
		}
		
		if((isset($password)) && (isset($active)) && (password_verify($mypassword, $password)) && ($active==1))
		{
			$_SESSION['username'] = $myusername;
			$_SESSION['password'] = $password;
			$_SESSION['type'] = $type;				
				
			sleep(1);
			header("Location:$url");
		}
		else if((empty($myusername)) || (empty($mypassword))){
			sleep(1);
			$error = $login_error_empty;
			
		} 
		else if ((isset($active)) && ($active==0))
		{
			sleep(1);
			$error = $login_error_active;
		}
		else{
			sleep(1);
			$error = $lorin_error_wrong;
		}
	}
?>