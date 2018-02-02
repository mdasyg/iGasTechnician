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
	
	if (isset($_POST['add_customer'])) {
		$name=$_POST['name'];
		$surname=$_POST['surname'];
		$email=$_POST['email'];
		$afm=$_POST['afm'];
		$phone1=$_POST['phone1'];
		$phone2=$_POST['phone2'];
		$address=$_POST['address'];
		$number=$_POST['number'];
		$postcode=$_POST['postcode'];
		$city=$_POST['city'];
		$tank_id=$_POST['tank_id'];
		$installation_date=$_POST['installation_date'];
		$certificate_expire_date=$_POST['certificate_expire_date'];
		
		//filter_var all variables
		$name = filter_var($name, FILTER_SANITIZE_STRING);
		$surname = filter_var($surname, FILTER_SANITIZE_STRING);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$afm = filter_var($afm, FILTER_SANITIZE_NUMBER_INT);
		$phone1 = filter_var($phone1, FILTER_SANITIZE_NUMBER_INT);
		$phone2 = filter_var($phone2, FILTER_SANITIZE_NUMBER_INT);
		$address = filter_var($address, FILTER_SANITIZE_STRING);
		$number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
		$postcode = filter_var($postcode, FILTER_SANITIZE_NUMBER_INT);
		$city = filter_var($city, FILTER_SANITIZE_STRING);
		$tank_id = filter_var($tank_id, FILTER_SANITIZE_NUMBER_INT);		
		$installation_date = filter_var($installation_date, FILTER_SANITIZE_STRING);
		$certificate_expire_date = filter_var($certificate_expire_date, FILTER_SANITIZE_STRING);
		
	    $stmt = $dbh->prepare("INSERT INTO usersili(user_id,name,surname,type,username,password,email,afm) VALUES (:id,:name,:surname,:type,:username,:password,:email,:afm)");
		$stmt_phone1 = $dbh->prepare("INSERT INTO phonesili(phone_id,number,usr_id,type) VALUES (:phone_id1,:number1,:usr_id1,:type1)");
		$stmt_phone2 = $dbh->prepare("INSERT INTO phonesili(phone_id,number,usr_id,type) VALUES (:phone_id2,:number2,:usr_id2,:type2)");
		$stmt_address = $dbh->prepare("INSERT INTO addressesili(address_id,usr_id,address,num,postcode,city,country) VALUES (:address_id,:usr_id,:address,:num,:postcode,:city,:country)");
		$stmt_possesion = $dbh->prepare("INSERT INTO possessionili(pos_id,tank_id,cust_id,installation_date,certificate_expire_date) VALUES (:pos_id,:tank_id,:cust_id,:installation_date,:certificate_expire_date)");
		$id=''; 
		$customer_username=""; 
		$password=""; 
		$customer_type="customer";
		$country=null;
			
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':surname', $surname);
		$stmt->bindParam(':type', $customer_type);
		$stmt->bindParam(':username', $customer_username);
		$stmt->bindParam(':password', $password);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':afm', $afm);
		
		$result = $stmt->execute();
		if ($result)
		{
			$type_phone1 = $signup_phone;
			$phone_id = "";
				
			$sql=$dbh->prepare("SELECT user_id FROM usersili WHERE afm='$afm'");
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
				
			$address_id="";
	
			$stmt_address->bindParam(':address_id', $address_id);
			$stmt_address->bindParam(':usr_id', $usr_id);
			$stmt_address->bindParam(':address', $address);
			$stmt_address->bindParam(':num', $number);
			$stmt_address->bindParam(':postcode', $postcode);
			$stmt_address->bindParam(':city', $city);
			$stmt_address->bindParam(':country', $country);
			$stmt_address->execute();
			
			$pos_id=''; 
			$cust_id=$usr_id;
			
			$stmt_possesion->bindParam(':pos_id', $pos_id);
			$stmt_possesion->bindParam(':tank_id', $tank_id);
			$stmt_possesion->bindParam(':cust_id', $cust_id);
			$stmt_possesion->bindParam(':installation_date', $installation_date);
			$stmt_possesion->bindParam(':certificate_expire_date', $certificate_expire_date);
			$stmt_possesion->execute();
				
			$success=$add_customer_success;
		}else
		{
			$error=$add_customer_error;
		}	
	}
?> 

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<title><?=$add_customer_title?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<?php include('navbar.php');?>
		
		<div class="header" style="margin-top:-50px;">
			<h4><?php echo '<a href="technician_profile.php?user_id=' .$user_id1. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>';?>			
		</div>
		
		<form method="post" action="customer_add.php" class="register" style="margin-top:30px;">
            <h2 class="signup_header" style="background-color:#660013;"><?php echo $add_customer_header; ?></h2></br>
			<h5 class="signup_message"> <?php echo $error; echo $success; ?> </h5></br>
			<fieldset class="row1" style="margin-top:-20px;">
                <legend style="color:#660013;"><?php echo $signup_personal_details; ?></legend>
				<h6 class="col-xs-offset-8 col-sm-offset-10 col-md-offset-10 obinfo"><?php echo $signup_explain; ?></h6>
                <p>
                    <label><?php echo $signup_name; ?></label>
                    <input type="text" name="name" class="long" required/>
					<label><?php echo $signup_afm; ?></label>
                    <input type="text" name="afm" maxlength="9" required/>
                </p>
				<p>
                    <label><?php echo $signup_surname; ?></label>
					<input type="text" name="surname" class="long" required/>
					<label><?php echo $signup_phone1; ?></label>
                    <input type="text" name="phone1" maxlength="10" required/> 
				</p>
				 <p>
                    <label class="optional"><?php echo $add_customer_email; ?></label>
                    <input type="text" name="email" class="long"/> 
					<label class="optional"><?php echo $signup_phone2; ?></label>
                    <input type="text" name="phone2" maxlength="10" />
                </p>
            </fieldset>
            <fieldset class="row2" >
                <legend style="color:#660013;"><?php echo $signup_address_details; ?></legend>
				<p>
                    <label><?php echo $signup_address."* "; ?></label>
                    <input type="text" name="address" class="long" required/>
                </p>
				<p>
                    <label class="optional"><?php echo $signup_number; ?></label>
                    <input type="text" name="number" class="short" maxlength="4"/>
                    <label><?php echo $signup_postcode."* "; ?></label>
                    <input type="text" name="postcode" class="short" maxlength="5" required/>
                </p>
                <p>
                    <label><?php echo $signup_city."* "; ?></label>
                    <input type="text" name="city" required/>
                </p>
            </fieldset>
			<fieldset class="row3">
                <legend style="color:#660013;"><?php echo $add_customer_tank_details; ?></legend>
                <p>
                    <label><?php echo $add_customer_tank; ?></label>
                    <select name="tank_id" required>
                        <option></option>
						<?php
							$sql_tank=$dbh->prepare("SELECT * FROM tanksili");
							$sql_tank->execute();
							$result2 = $sql_tank->fetchAll();
							foreach ($result2 as $row)
							{
								echo '<option value="'.$row['id'].'">'.$row['model'];
							}
						?>
                        </option>
                    </select>
                </p>
				<p>
                    <label class="optional"><?php echo $add_customer_installation_date; ?></label>
					<input type="date" name="installation_date" value="<?php echo date('Y-m-d'); ?>"/> 
				</p>
				<p>
                    <label class="optional"><?php echo $add_customer_certificate_expire; ?></label>
					<input type="date" name="certificate_expire_date" value="<?php echo date('Y-m-d'); ?>"/> 
				</p>
            </fieldset>
            <button type="submit" name="add_customer" class="button" style="background-color:#660013; margin-left:74.5%; margin-top:-40px;"><?php echo $add_customer_submit_button; ?></button>		
	   </form>
		
		<div id="copyright">
			<?php copyright(); ?>	
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	</body>
</html>