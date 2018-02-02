<?php 
	include('errors_warnings.php');
	include('connect.php');
	include('strings.php');
	include('http_to_https.php');
	session_start();
	$dbh=connect_db();
	
	$error="";
	$success="";
	
	if (isset($_POST['singup'])) {
		$username=$_POST['username'];
		$email=$_POST['email'];
		$password=$_POST['password'];
		$repeat_password=$_POST['repeat_password'];
		$name=$_POST['name'];
		$surname=$_POST['surname'];
		$phone1=$_POST['phone1'];
		$phone2=$_POST['phone2'];
		$hash = md5( rand(0,10000) );
		
		//filter_var all variables
		$username = filter_var($username, FILTER_SANITIZE_STRING);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$password = filter_var($password, FILTER_SANITIZE_STRING);
		$repeat_password = filter_var($repeat_password, FILTER_SANITIZE_STRING);
		$name = filter_var($name, FILTER_SANITIZE_STRING);
		$surname = filter_var($surname, FILTER_SANITIZE_STRING);
		$phone1 = filter_var($phone1, FILTER_SANITIZE_NUMBER_INT);
		$phone2 = filter_var($phone2, FILTER_SANITIZE_NUMBER_INT);
		$hash = filter_var($hash, FILTER_SANITIZE_STRING);
		
	    $stmt = $dbh->prepare("INSERT INTO usersili(user_id,name,surname,type,username,password,email,afm,hash,active) VALUES (:id,:name,:surname,:type,:username,:password,:email,:afm,:hash,:active)");
		$stmt_phone1 = $dbh->prepare("INSERT INTO phonesili(phone_id,number,usr_id,type) VALUES (:phone_id1,:number1,:usr_id1,:type1)");
		$stmt_phone2 = $dbh->prepare("INSERT INTO phonesili(phone_id,number,usr_id,type) VALUES (:phone_id2,:number2,:usr_id2,:type2)");
		$id=''; 
		$type="technician";
		$afm=null; 
		$active=0;
		
		if ($password == $repeat_password)
		{
			$pass_hash = password_hash($password, PASSWORD_BCRYPT);
				
			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':surname', $surname);
			$stmt->bindParam(':type', $type);
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':password', $pass_hash);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':afm', $afm);
			$stmt->bindParam(':hash', $hash);
			$stmt->bindParam(':active', $active);
			$result = $stmt->execute();
			if ($result)
			{
				$type_phone1 = $signup_phone;
				$phone_id = "";
					
				$sql=$dbh->prepare("SELECT user_id FROM usersili WHERE username='$username'");
				$sql->execute();
				$result1 = $sql->fetchAll();
				foreach ($result1 as $row)
				{
					$usr_id=$row['user_id'];
				}
					
				$stmt_phone1->bindParam(':phone_id1', $phone_id);
				$stmt_phone1->bindParam(':number1', $phone1);
				$stmt_phone1->bindParam(':usr_id1', $usr_id);
				$stmt_phone1->bindParam(':type1', $type_phone1);
				$stmt_phone1->execute();
					
				if (!empty($phone2))
				{
					$type_phone2 = $signup_cellphone;
					$phone_id = "";
						
					$stmt_phone2->bindParam(':phone_id2', $phone_id);
					$stmt_phone2->bindParam(':number2', $phone2);
					$stmt_phone2->bindParam(':usr_id2', $usr_id);
					$stmt_phone2->bindParam(':type2', $type_phone2);
					$stmt_phone2->execute();
				}
								
				$success=$signup_success;
				
				//send verification mail
				// the message
				$msg = $signup_msg1.$email.$signup_msg2.$hash.$signup_msg3.$username.$signup_msg4.$password; 
				$msg = wordwrap($msg,1000);

				$headers = 'From: noreply@spam.vlsi.gr'."\r\n".'Reply-To: noreply@spam.vlsi.gr'."\r\n".'Content-type: text; charset=UTF-8;' . "\r\n".'X-Mailer: PHP/'.phpversion();

				$subject=$signup_subject;
				// send email
				mail($email,$subject,$msg,$headers);
				
			}else
			{
				$error=$signup_error;
			}	
		}else{
			$error=$signup_error_pass;
		}
	}
?> 

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<title><?=$signup_submit_button?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<div class="header_login">
			<p> <?php echo $menu_header; ?> </p> </br>
		</div>
		
		<form method="post" action="signup.php" class="register">
            <h2 class="signup_header"><?php echo $signup_header; ?></h2></br>
			<h5 class="signup_message"> <?php echo $error; echo $success; ?> </h5></br>
			<h6 class="col-xs-offset-8 col-sm-offset-10 col-md-offset-10 obinfo" style="margin-top:-32px;"><?php echo $signup_explain; ?></h6> 
            <fieldset class="row2">
                <legend><?php echo $signup_account_details; ?></legend>
				<p>
                    <label><?php echo $signup_username; ?></label>
                    <input type="text" name="username" required/>
				</p>
                <p>
					<label><?php echo $signup_password; ?></label>
                    <input type="password" name = "password" id = "password" required/>
					<span id="passstrength"></span>
                </p>
				<p class="psmall">
					<label><?php echo $signup_repeat_password; ?></label>
					<input type="password" name = "repeat_password" required/>	
				</p>
				<p class="psmall1">
					<label><?php echo $signup_email; ?></label>
					<input type="text" name="email" class="long" required/>					
				</p>
            </fieldset>
            <fieldset class="row3">
                <legend><?php echo $signup_personal_details; ?></legend>
                <p>
                    <label><?php echo $signup_name; ?></label>
                    <input type="text" name="name" class="long" required/>
                </p>
				<p>
                    <label><?php echo $signup_surname; ?></label>
					<input type="text" name="surname" class="long" required/>
				</p>
                <p>
                    <label><?php echo $signup_phone1; ?></label>
                    <input type="text" name="phone1" maxlength="10" required/> 
                </p>
				<p>
                    <label class="optional"><?php echo $signup_phone2; ?></label>
                    <input type="text" name="phone2" maxlength="10" />
                </p>
            </fieldset>
            <button type="submit" name="singup" class="button"><?php echo $signup_submit_button; ?></button>
			<p class="signup_to_index"><?php echo $signup_question; ?> &nbsp;<a href="index.php"><?php echo $signup_index_link; ?></a></p>
        </form>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="js/index.js"></script>
		<script type="text/javascript">
			$('#password').keyup(function(e) {
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
