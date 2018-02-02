<?php 
	include('errors_warnings.php');
	include('lock.php');
	include('copyright.php');
	include('strings.php');
	include('http_to_https.php');
	$dbh=connect_db();
	
	if(isset($_SESSION['username']))
	{
		$user_check=$_SESSION['username'];
		$login_session=$_SESSION['username'];
		$username=$_SESSION['username'];
		$type=$_SESSION['type'];
		
		if ($type == "super")
		{
			$type1 = $menu_super;
		}else
		{
			$type1 = $menu_technician;
		}
			
		$sql = $dbh->prepare("SELECT user_id FROM usersili WHERE username='$username'");
		$sql->execute();
		$result1 = $sql->fetchAll();
		foreach ($result1 as $row)
		{
			$user_id=$row['user_id'];
		}
	}
	
	$error="";
	$success="";
	
	$user_id=$_GET["user_id"];
	$user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
	
	if (isset($_POST['pass_change'])) {
		$pass_new1=$_POST['pass_new1'];
		$pass_new2=$_POST['pass_new2'];
		
		//filter_var all variables
		$pass_new1 = filter_var($pass_new1, FILTER_SANITIZE_STRING);
		$pass_new2 = filter_var($pass_new2, FILTER_SANITIZE_STRING);
		
			
		$sql = $dbh->prepare("SELECT * FROM usersili WHERE user_id='$user_id'");
		$sql->execute();
		$result = $sql->fetchAll();
		foreach ($result as $row)
		{
			$password=$row['password'];
			$email=$row['email'];
		}
		
		if ($pass_new1 == $pass_new2)
		{
			$pass_hash = password_hash($pass_new1, PASSWORD_BCRYPT);
				
			$stmt = $dbh->prepare("UPDATE usersili SET password = '$pass_hash' WHERE user_id='$user_id'"); 			
			$stmt->bindParam(':password', $pass_hash);
			$result1 = $stmt->execute();
			
			if ($result1)
			{	
				$success = $change_password_success;
				
				// the message
				$msg = $change_password_msg1.$pass_new1.$change_password_msg2; 
				$msg = wordwrap($msg,1000);

				$headers = 'From: noreply@spam.vlsi.gr'."\r\n".'Reply-To: noreply@spam.vlsi.gr'."\r\n".'Content-type: text; charset=UTF-8;' . "\r\n".'X-Mailer: PHP/'.phpversion();

				$subject=$change_password_subject;
				// send email
				mail($email,$subject,$msg,$headers);
				
				echo '<meta http-equiv="refresh" content="2;URL=technicians.php" />';
			}else
			{
				$error = $change_password_error;
			}
		}else
		{
			$error = $change_password_error_diff;
		}
	}
?> 


<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<title><?=$change_password_header?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<?php include('navbar.php');
		
			$user_id=$_GET["user_id"];
			$user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
			
			$sql_show_customer = $dbh->prepare("SELECT * FROM usersili WHERE user_id='$user_id' AND type='technician'");
			$sql_show_customer->execute();
			$result1 = $sql_show_customer->fetchAll();
			foreach ($result1 as $row)
			{
				$user_id_val=$row['user_id'];
			}
			
			if (!empty($user_id_val))
			{
		?>
		
		<div class="header" style="margin-top:-50px;">
			<h4><?php echo '<a href="technician_profile.php?user_id=' .$user_id. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>';?>			
		</div>
		
		<form method="post" action="" class="register" style="margin-top:50px;">
            <h2 class="signup_header" style="background-color:#997a00;"><?php echo $change_password_header ?></h2></br>
			<h5 class="signup_message"> <?php echo $error; echo $success; ?> </h5></br>
			<h6 class="col-xs-offset-8 col-sm-offset-10 col-md-offset-10 obinfo" style="margin-top:-32px;"><?php echo $signup_explain; ?></h6>
			<fieldset class="row1">
				<p>
                    <label><?php echo $change_password_new1; ?></label>
					<input type="password" name="pass_new1" id = "pass_new1" class="long" required/>
					<span id="passstrength" style="color:#997a00;"></span>
				</p>
				<p>
                    <label><?php echo $change_password_new2; ?></label>
                    <input type="password" name="pass_new2" class="long" required/>
                </p>
            </fieldset>
            <button type="submit" name="pass_change" class="button" style="background-color:#997a00; margin-left:74.5%;"><?php echo $change_password_submit_button; ?></button>
	   </form>
		
		<div id="copyright">
			<?php copyright(); ?>	
		</div>
		
		<?php
			}else{
				echo '<h4 style="text-align:center;">'.$profile_no_technician.'</h4></br>';
			}
		?>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$('#pass_new1').keyup(function(e) {
				 var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
				 var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
				 var enoughRegex = new RegExp("(?=.{6,}).*", "g");
				 if (false == enoughRegex.test($(this).val())) {
						 $('#passstrength').html('Περισσότεροι <br> Χαρακτήρες');
				 } else if (strongRegex.test($(this).val())) {
						 $('#passstrength').className = 'ok';
						 $('#passstrength').html('Δυνατός!');
				 } else if (mediumRegex.test($(this).val())) {
						 $('#passstrength').className = 'alert';
						 $('#passstrength').html('Μέτριος');
				 } else {
						 $('#passstrength').className = 'error';
						 $('#passstrength').html('Αδύναμος...');
				 }
				 return true;
			});
		</script>

	</body>
</html>	 