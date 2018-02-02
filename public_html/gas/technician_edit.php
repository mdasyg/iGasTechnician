<?php 
	include('errors_warnings.php');
	include('lock.php');
	include('copyright.php');
	include('strings.php');
	include('http_to_https.php');
	$dbh=connect_db();
	
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
		$user_id1=$row['user_id'];
	} 
	
	$error="";
	$success="";
	
	$user_id=$_GET["user_id"];
	$user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
	
	if (isset($_POST['user_change'])) {
		$name=$_POST['name'];
		$surname=$_POST['surname'];
		$email=$_POST['email'];
		$phone1=$_POST['phone1'];
		$username=$_POST['username'];
		$type=$_POST['type'];
		
		//filter_var all variables
		$name = filter_var($name, FILTER_SANITIZE_STRING);
		$surname = filter_var($surname, FILTER_SANITIZE_STRING);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$phone1 = filter_var($phone1, FILTER_SANITIZE_NUMBER_INT);
		$username = filter_var($username, FILTER_SANITIZE_STRING);
		$type = filter_var($type, FILTER_SANITIZE_STRING);
			
		$stmt = $dbh->prepare("UPDATE usersili INNER JOIN phonesili ON usersili.user_id=phonesili.usr_id SET usersili.user_id = '$user_id', usersili.name = '$name', usersili.surname = '$surname', usersili.type = '$type', usersili.username = '$username', usersili.email='$email', phonesili.number='$phone1' WHERE user_id='$user_id' AND phonesili.type='Σταθερό'"); 

		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':surname', $surname);
		$stmt->bindParam(':type', $type);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':number1', $phone1);
		$result = $stmt->execute();
		
		if ($result)
		{	
			$success = $edit_customer_success;
			if ($user_id1 == $user_id)
			{
				echo '<meta http-equiv="refresh" content="2;URL=technician_profile.php?user_id=' .$user_id. '" />';
			}else{
				
				echo '<meta http-equiv="refresh" content="2;URL=technicians.php" />';
			}
		}else
		{
			$error = $edit_customer_error;
			echo '<meta http-equiv="refresh" content="2;URL=technician_edit.php?user_id=' .$user_id. '" />';
		}
	}
?> 


<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<title><?=$edit_technician_title?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<?php include('navbar.php');
		
			$user_id=$_GET["user_id"];
			$user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
			
			$sql_form = $dbh->prepare("SELECT * FROM usersili INNER JOIN phonesili ON usersili.user_id=phonesili.usr_id WHERE usersili.user_id='$user_id' AND (usersili.type='technician' OR usersili.type='super') AND phonesili.type='Σταθερό'");
			$sql_form->execute();
			$result2 = $sql_form->fetchAll();
			foreach ($result2 as $row)
			{
				$name=$row['name'];
				$surname=$row['surname'];
				$email=$row['email'];
				$phone1=$row['number'];
				$username1=$row['username'];
			}
			$sql_form1 = $dbh->prepare("SELECT type FROM usersili WHERE user_id='$user_id' AND (type='technician' OR type='super')");
			$sql_form1->execute();
			$result3 = $sql_form1->fetchAll();
			foreach ($result3 as $row)
			{
				$type=$row['type'];
			}
			if ((!empty($name)) && (!empty($surname)))
			{
		?>
		
		<div class="header" style="margin-top:-50px;">
			<h4><?php echo '<a href="technician_profile.php?user_id=' .$user_id1. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>';?>			
		</div>
		
		<form method="post" action="" class="register" style="margin-top:30px;">
            <h2 class="signup_header" style="background-color:#997a00;"><?php if ($user_id1 == $user_id){ echo $edit_technician_my; } else{ echo $edit_technician_header; } ?></h2></br>
			<h5 class="signup_message"> <?php echo $error; echo $success; ?> </h5></br>
			<h6 class="col-xs-offset-8 col-sm-offset-10 col-md-offset-10 obinfo" style="margin-top:-32px;"><?php echo $signup_explain; ?></h6> 
			<fieldset class="row2" style="margin-top:-10px;">
                <legend style="color:#997a00;"><?php echo $signup_personal_details; ?></legend>
                <p>
                    <label><?php echo $signup_name; ?></label>
                    <input type="text" name="name" value="<?php echo $name; ?>" class="long" required/>
                </p>
				<p>
                    <label><?php echo $signup_surname; ?></label>
					<input type="text" name="surname" value="<?php echo $surname; ?>" class="long" required/>
				</p>
				 <p>
                    <label class="optional"><?php echo $add_customer_email; ?></label>
                    <input type="text" name="email" value="<?php echo $email; ?>" class="long"/> 
                </p>
                <p>
                    <label><?php echo $signup_phone1; ?></label>
                    <input type="text" name="phone1" value="<?php echo $phone1; ?>" maxlength="10" required/> 
                </p>
            </fieldset>
			<fieldset class="row3" style="margin-top:-10px;">
                <legend style="color:#997a00;"><?php echo $edit_technician_root; ?></legend>
                <p>
                    <label><?php echo $signup_username; ?></label>
                    <input type="text" name="username" value="<?php echo $username1; ?>" class="long" required/>
                </p>
				<?php
					if ($type=="super")
					{?>
						<p>
							<label><?php echo $edit_technician_type; ?></label>
							<select name="type" required>
									<option></option>
									<?php 	if ($type=="technician"){
												echo'<option value="technician" selected>'. $edit_technician_technician .' </option>
													<option value="super">'. $edit_technician_admin .'</option>';
											}else{
												echo'<option value="technician">'. $edit_technician_technician .' </option>
													<option value="super" selected>'. $edit_technician_admin .' </option>';
											}
									?>
								</select>
						</p>
					<?php } 
				?>
            </fieldset>
            <button type="submit" name="user_change" class="button" style="background-color:#997a00; margin-left:74.5%; margin-top:-30px;"><?php echo $edit_customer_submit_button; ?></button>
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
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	</body>
</html>	