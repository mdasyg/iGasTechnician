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
	
	if (isset($_POST['add_tank'])) {
		$model=$_POST['model'];
		$fuel=$_POST['fuel'];
		$placement=$_POST['placement'];
		$manufacturer=$_POST['manufacturer'];
		$heating=$_POST['heating'];
		$hotwater=$_POST['hotwater'];
		$maximum_input=$_POST['maximum_input'];
		$power_supply=$_POST['power_supply'];
		$dimensions=$_POST['dimensions'];
		$weight=$_POST['weight'];
		$chimney_in=$_POST['chimney_in'];
		$chimney_out=$_POST['chimney_out'];
		
		//filter_var all variables
		$model = filter_var($model, FILTER_SANITIZE_STRING);
		$fuel = filter_var($fuel, FILTER_SANITIZE_STRING);
		$placement = filter_var($placement, FILTER_SANITIZE_STRING);
		$manufacturer = filter_var($manufacturer, FILTER_SANITIZE_STRING);
		$heating = filter_var($heating, FILTER_SANITIZE_NUMBER_FLOAT);
		$hotwater = filter_var($hotwater, FILTER_SANITIZE_NUMBER_FLOAT);
		$maximum_input = filter_var($maximum_input, FILTER_SANITIZE_STRING);
		$power_supply = filter_var($power_supply, FILTER_SANITIZE_STRING);
		$dimensions = filter_var($dimensions, FILTER_SANITIZE_STRING);
		$weight = filter_var($weight, FILTER_SANITIZE_NUMBER_INT);
		$chimney_in = filter_var($chimney_in, FILTER_SANITIZE_NUMBER_INT);
		$chimney_out = filter_var($chimney_out, FILTER_SANITIZE_NUMBER_INT);	
		
		
		$id="";
	    $stmt = $dbh->prepare("INSERT INTO tanksili(id,model,fuel,placement,manufacturer,heating,hotwater,maximum_input,power_supply,dimensions,weight,chimney_in,chimney_out) VALUES (:id,:model,:fuel,:placement,:manufacturer,:heating,:hotwater,:maximum_input,:power_supply,:dimensions,:weight,:chimney_in,:chimney_out)");
			
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':model', $model);
		$stmt->bindParam(':fuel', $fuel);
		$stmt->bindParam(':placement', $placement);
		$stmt->bindParam(':manufacturer', $manufacturer);
		$stmt->bindParam(':heating', $heating);
		$stmt->bindParam(':hotwater', $hotwater);
		$stmt->bindParam(':maximum_input', $maximum_input);
		$stmt->bindParam(':power_supply', $power_supply);
		$stmt->bindParam(':dimensions', $dimensions);
		$stmt->bindParam(':weight', $weight);
		$stmt->bindParam(':chimney_in', $chimney_in);
		$stmt->bindParam(':chimney_out', $chimney_out);
		
		$result = $stmt->execute();
		if ($result)
		{
			$success=$add_tank_success;
		}else
		{
			$error=$add_tank_error;
		}	
	}
?> 

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<title><?=$add_tank_title?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<?php include('navbar.php');?>
		
		<div class="header" style="margin-top:-50px;">
			<h4><?php echo '<a href="technician_profile.php?user_id=' .$user_id1. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>';?>			
		</div>
		
		<form method="post" action="tank_add.php" class="register" style="margin-top:25px;">
            <h2 class="signup_header" style="background-color:#1497b8;"><?php echo $add_tank_header ?></h2></br>
			<h5 class="signup_message"> <?php echo $error; echo $success; ?> </h5></br>
			<fieldset class="row1" style="margin-top:-20px;">
                <legend style="color:#1497b8;"><?php echo $add_tank_general; ?></legend>
				<h6 class="col-xs-offset-8 col-sm-offset-10 col-md-offset-10 obinfo"><?php echo $signup_explain; ?></h6>
                <p>
                    <label><?php echo $add_tank_model; ?></label>
                    <input type="text" name="model" required/>
                </p>
				<p>
                    <label><?php echo $add_tank_fuel; ?></label>
					<input type="text" name="fuel" required/>
				</p>
				<div class="row"><div class="col-sm-offset-5 col-sm-8 col-md-offset-5 col-md-8">
					<p class="psmall">
						<label><?php echo $add_tank_placement; ?></label>
						<select name="placement">
							<option></option>
							<option value="επιτοίχιος"><?php echo $add_tank_wall; ?>
							<option value="επιδαπέδιος"><?php echo $add_tank_ground; ?>
							</option>
						</select>
					</p>
				</div>
				</div>
				<div class="row"><div class="col-sm-offset-5 col-sm-8 col-md-offset-5 col-md-8">
					<p class="psmall1">
						<label><?php echo $add_tank_manufacturer; ?></label>
						<input type="text" name="manufacturer" required/>			
					</p>			
					</p>
				</div>
				</div>
            </fieldset>			
            <fieldset class="row2" style="margin-bottom:30px;">
                <legend style="color:#1497b8;"><?php echo $add_tank_tech; ?></legend>
				<p>
                    <label><?php echo $add_tank_heating; ?></label>
                    <input type="text" name="heating" required/> kW
                </p>
				<p>
                    <label class="optional"><?php echo $add_tank_hotwater; ?></label>
                    <input type="text" name="hotwater"/> kW
                </p>
                <p>
                    <label class="optional"><?php echo $add_tank_maximum_input; ?></label>
                    <input type="text" name="maximum_input" class="long"/>
                </p>
                <p>
                    <label class="optional"><?php echo $add_tank_power_supply; ?></label>
                    <input type="text" name="power_supply"/>
                </p>
            </fieldset>
			<fieldset class="row3">
                <legend style="color:#1497b8;"><?php echo $add_tank_dw; ?></legend>
                <p>
                    <label class="optional"><?php echo $add_tank_dimensions; ?></label>
                    <input type="text" name="dimensions" /> mm
                </p>
				<p>
                    <label class="optional"><?php echo $add_tank_weight; ?></label>
					<input type="text" name="weight" /> kg
				</p>
				<p class="optional">
					<?php echo $add_tank_chimney; ?>
				</p>
				<p>
                    <label class="optional"><?php echo $add_tank_chimney_in; ?></label>
                    <input type="text" name="chimney_in" class="short"/>
                    <label class="optional"><?php echo $add_tank_chimney_out; ?></label>
                    <input type="text" name="chimney_out" class="short"/>
                </p>
            </fieldset>
            <button type="submit" name="add_tank" class="button" style="background-color:#1497b8; margin-left:74.5%; margin-top:-15px;"><?php echo $add_customer_submit_button; ?></button>
	   </form>
		
		<div id="copyright">
			<?php copyright(); ?>	
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	</body>
</html>