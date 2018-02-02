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
		$afm=$_POST['afm'];
		$email=$_POST['email'];
		$phone1=$_POST['phone1'];
		$phone2=$_POST['phone2'];
		$address=$_POST['address'];
		$number=$_POST['number'];
		$postcode=$_POST['postcode'];
		$city=$_POST['city'];
		
		//filter_var all variables
		$name = filter_var($name, FILTER_SANITIZE_STRING);
		$surname = filter_var($surname, FILTER_SANITIZE_STRING);
		$afm = filter_var($afm, FILTER_SANITIZE_NUMBER_INT);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$phone1 = filter_var($phone1, FILTER_SANITIZE_NUMBER_INT);
		$phone2 = filter_var($phone2, FILTER_SANITIZE_NUMBER_INT);
		$address = filter_var($address, FILTER_SANITIZE_STRING);
		$number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
		$postcode = filter_var($postcode, FILTER_SANITIZE_NUMBER_INT);
		$city = filter_var($city, FILTER_SANITIZE_STRING);	
			
		$stmt = $dbh->prepare("UPDATE usersili INNER JOIN phonesili INNER JOIN addressesili ON usersili.user_id=phonesili.usr_id AND usersili.user_id=addressesili.usr_id SET usersili.user_id = '$user_id', usersili.name = '$name', usersili.surname = '$surname', usersili.email='$email', usersili.afm='$afm', phonesili.number='$phone1', addressesili.address='$address', addressesili.num='$number', addressesili.postcode='$postcode', addressesili.city='$city' WHERE user_id='$user_id' AND phonesili.type='Σταθερό'"); 
		$stmt_phone2 = $dbh->prepare("UPDATE phonesili SET number = '$phone2' WHERE usr_id='$user_id' AND phonesili.type='Κινητό'");
		
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':surname', $surname);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':afm', $afm);	
		$stmt->bindParam(':number1', $phone1);
		$stmt->bindParam(':address', $address);
		$stmt->bindParam(':num', $number);
		$stmt->bindParam(':postcode', $postcode);
		$stmt->bindParam(':city', $city);
		$result = $stmt->execute();
		
		if (!empty($phone2))
		{		
			$stmt_phone2->bindParam(':number2', $phone2);
			$stmt_phone2->execute();
		}
		
		if ($result)
		{	
			$success = $edit_customer_success;
			echo '<meta http-equiv="refresh" content="2;URL=customers.php" />';
		}else
		{
			$error = $edit_customer_error;
			echo '<meta http-equiv="refresh" content="2;URL=customer_edit.php?user_id=' .$user_id. '" />';
		}
	}
?> 


<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<title><?=$edit_customer_title?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<?php include('navbar.php');
		
			$user_id=$_GET["user_id"];
			$sql_form = $dbh->prepare("SELECT * FROM usersili INNER JOIN phonesili INNER JOIN addressesili ON usersili.user_id=phonesili.usr_id AND usersili.user_id=addressesili.usr_id WHERE usersili.user_id='$user_id' AND phonesili.type='Σταθερό'");
			$sql_form->execute();
			$result1 = $sql_form->fetchAll();
			foreach ($result1 as $row)
			{
				$name=$row['name'];
				$surname=$row['surname'];
				$email=$row['email'];
				$afm=$row['afm'];
				$phone1=$row['number'];
				$address=$row['address'];
				$number=$row['num'];
				$postcode=$row['postcode'];
				$city=$row['city'];
			}
			$sql_form1 = $dbh->prepare("SELECT * FROM phonesili WHERE usr_id='$user_id' AND phonesili.type='Κινητό'");
			$sql_form1->execute();
			$result2 = $sql_form1->fetchAll();
			$count=0;
			foreach ($result2 as $row)
			{
				$count++;
				$phone2=$row['number'];
			}
			if (empty($count))
			{
				$phone2="";
			}	
			if (empty($number))
			{
				$number=NULL;
			}
			
			if ((!empty($name)) && (!empty($surname)) && (!empty($afm)))
			{
		?>
		
		<div class="header" style="margin-top:-50px;">
			<h4><?php echo '<a href="technician_profile.php?user_id=' .$user_id1. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>';?>			
		</div>
		
		<form method="post" action="" class="register" style="margin-top:50px;">
            <h2 class="signup_header" style="background-color:#660013;"><?php echo $edit_customer_header ?></h2></br>
			<h5 class="signup_message"> <?php echo $error; echo $success; ?> </h5></br>
			<h6 class="col-xs-offset-8 col-sm-offset-10 col-md-offset-10 obinfo" style="margin-top:0px;"><?php echo $signup_explain; ?></h6>
			<fieldset class="row2" style="margin-top:-20px;">
                <legend style="color:#660013;"><?php echo $signup_personal_details; ?></legend>
                <p>
                    <label><?php echo $signup_name; ?></label>
                    <input type="text" name="name" value="<?php echo $name; ?>" class="long" required/>
				</p>
				<p>
                    <label><?php echo $signup_surname; ?></label>
					<input type="text" name="surname" value="<?php echo $surname; ?>" class="long" required/>
				</p>
				<p>
					<label><?php echo $add_customer_afm; ?></label>
                    <input type="text" name="afm" value="<?php echo $afm; ?>" maxlength="9" required/>
                </p>
				<p>
                    <label class="optional"><?php echo $add_customer_email; ?></label>
                    <input type="text" name="email" value="<?php echo $email; ?>" class="long"/> 
				</p>
				<p>
					<label><?php echo $signup_phone1; ?></label>
                    <input type="text" name="phone1" value="<?php echo $phone1; ?>" maxlength="10" required/> 
				</p>
				<p>
					<label class="optional"><?php echo $signup_phone2; ?></label>
                    <input type="text" name="phone2" value="<?php echo $phone2; ?>" maxlength="10" />
                </p>
            </fieldset>
			
            <fieldset class="row3" style="margin-top:20px;">
                <legend style="color:#660013;"><?php echo $signup_address_details; ?></legend>
				<p>
                    <label><?php echo $signup_address; ?></label>
                    <input type="text" name="address" value="<?php echo $address; ?>" class="long" required/>
                </p>
				<p>
                    <label class="optional"><?php echo $signup_number; ?></label>
                    <input type="text" name="number" value="<?php echo $number; ?>" class="short" maxlength="4"/>
                    <label><?php echo $signup_postcode; ?></label>
                    <input type="text" name="postcode" value="<?php echo $postcode; ?>" class="short" maxlength="5" required/>
                </p>
                <p>
                    <label><?php echo $signup_city; ?></label>
                    <input type="text" name="city" value="<?php echo $city; ?>" required/>
                </p>
            </fieldset>
			
            <button type="submit" name="user_change" class="button" style="background-color:#660013; margin-left:74.5%; margin-top:10px;"><?php echo $edit_customer_submit_button; ?></button>
	   </form>
		
		<div id="copyright">
			<?php copyright(); ?>	
		</div>
		
		<?php
			}else{
				echo '<h4 style="text-align:center;">'.$profile_no_customer.'</h4></br>';
			}
		?>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	</body>
</html>	