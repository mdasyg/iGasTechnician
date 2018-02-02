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
	
	$error="";
	$success="";
	
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
	
	$event_id=$_GET["event_id"];
	$event_id = filter_var($event_id, FILTER_SANITIZE_NUMBER_INT);
	
	if (isset($_POST['event_change'])) {
		$title=$_POST['title'];
		$start=$_POST['start'];
		$end=$_POST['end'];
		$description=$_POST['description'];
		$cust_id=$_POST['cust_id'];
		$yesno=$_POST['yesno'];
		
		//filter_var all variables
		$title = filter_var($title, FILTER_SANITIZE_STRING);
		$start = filter_var($start, FILTER_SANITIZE_STRING);
		$end = filter_var($end, FILTER_SANITIZE_STRING);
		$description = filter_var($description, FILTER_SANITIZE_STRING);
		$cust_id = filter_var($cust_id, FILTER_SANITIZE_NUMBER_INT);	
		
		if ($type == "super")
		{
			$creator_id=$_POST['creator_id'];
			$creator_id = filter_var($creator_id, FILTER_SANITIZE_NUMBER_INT);
		}else
		{
			$sql_creator = $dbh->prepare("SELECT user_id FROM usersili WHERE username='$username'");
			$sql_creator->execute();
			$result = $sql_creator->fetchAll();
			foreach ($result as $row)
			{
				$creator_id = $row['user_id'];
			}
		}
		
		if($yesno == 0)
		{
			$stmt = $dbh->prepare("UPDATE eventsili SET title = '$title', start = '$start', end = '$end', description='$description', creator_id='$creator_id', cust_id='$cust_id', reminder=null WHERE id='$event_id'"); 
		
		}else
		{
			$reminder=$_POST['reminder'];
			$reminder = filter_var($reminder, FILTER_SANITIZE_STRING);
			
			$stmt = $dbh->prepare("UPDATE eventsili SET title = '$title', start = '$start', end = '$end', description='$description', creator_id='$creator_id', cust_id='$cust_id', reminder='$reminder' WHERE id='$event_id'"); 
		
		}
			
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':start', $start);
		$stmt->bindParam(':end', $end);
		$stmt->bindParam(':description', $description);	
		$stmt->bindParam(':creator_id', $creator_id);
		$stmt->bindParam(':cust_id', $cust_id);
		$stmt->bindParam(':reminder', $reminder);
		$result = $stmt->execute();
		if ($result)
		{	
			$success = $edit_customer_success;
			echo '<meta http-equiv="refresh" content="2;URL=calendar.php" />';
		}else
		{
			$error = $edit_customer_error;
			echo '<meta http-equiv="refresh" content="2;URL=event_edit.php?event_id=' .$event_id. '" />';
		}
	}
?> 


<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<title><?=$edit_event_header?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<?php include('navbar.php');
		
			$event_id=$_GET["event_id"];
			$event_id = filter_var($event_id, FILTER_SANITIZE_NUMBER_INT);
			
			$sql_form = $dbh->prepare("SELECT * FROM eventsili WHERE id='$event_id'");
			$sql_form->execute();
			$result1 = $sql_form->fetchAll();
			foreach ($result1 as $row)
			{
				$title=$row['title'];
				$start=$row['start'];
				$end=$row['end'];
				$description=$row['description'];
				$creator_id=$row['creator_id'];
				$cust_id=$row['cust_id'];
				$reminder=$row['reminder'];
			}	
			
			if ((!empty($title)) && (!empty($start)) && (!empty($end)))
			{
		?>
		
		<div class="header" style="margin-top:-50px;">
			<h4><?php echo '<a href="technician_profile.php?user_id=' .$user_id1. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>';?>			
		</div>
		
		<form method="post" action="" class="register" style="margin-top:20px;">
            <h2 class="signup_header" style="background-color:#1497b8;"><?php echo $edit_event_header ?></h2></br>
			<h5 class="signup_message"> <?php echo $error; echo $success; ?> </h5></br>
			<fieldset class="row1">
                <legend style="color:#1497b8;"><?php echo $edit_event_general; ?></legend>
				<h6 class="col-xs-offset-8 col-sm-offset-10 col-md-offset-10 obinfo"><?php echo $signup_explain; ?></h6>
                <p>
                    <label><?php echo $edit_event_title; ?></label>
                    <input type="text" name="title" value="<?php echo $title; ?>" required/>
                </p>
				<p>
                    <label><?php echo $edit_event_start; ?></label>
					<input type="datetime" name="start" value="<?php echo $start; ?>" required/>
				</p>
				<p>
                    <label><?php echo $edit_event_end; ?></label>
					<input type="datetime" name="end" value="<?php echo $end; ?>" required/>
				</p>
				<p>
					<label class="optional"><?php echo $edit_event_description; ?></label>
					<textarea rows="3" cols="30" name="description"> <?php echo $description; ?> </textarea>			
				</p>
				<p>
					<?php if ($type == "super"){?>
						<label><?php echo $edit_event_creator_id; ?></label>
						<select name="creator_id" required>
							<option></option>
							<?php 	
								$sql_cre = $dbh->prepare("SELECT user_id,name,surname FROM usersili WHERE type='technician' OR type='super'");
								$sql_cre->execute();
								$result2 = $sql_cre->fetchAll();
								foreach ($result2 as $row)
								{?>
									<option <?php if ($row['user_id']==$creator_id) { ?>selected="selected"<?php } ?> value="<?php echo $row['user_id']; ?>" > <?php echo $row['name']." ".$row['surname']; 
								}
							?>
						</select>
					<?php }else{ } ?>		
				</p>
				<p>
					<label><?php echo $edit_event_cust_id; ?></label>
					<select name="cust_id" required>
						<option></option>
						<?php 	
							$sql_cust = $dbh->prepare("SELECT user_id,name,surname FROM usersili WHERE type='customer'");
							$sql_cust->execute();
							$result3 = $sql_cust->fetchAll();
							foreach ($result3 as $row)
							{?>
								<option <?php if ($row['user_id']==$cust_id) { ?>selected="selected"<?php } ?> value="<?php echo $row['user_id']; ?>" > <?php echo $row['name']." ".$row['surname']; 
							}
						?>
					</select>			
				</p>
				<p>
					<label class="optional"><?php echo $edit_event_reminder; ?></label>
					
					<?php if ($reminder == NULL){?>
						<p> Ναι <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="yesCheck" value="1"/></p>
						<p> Όχι <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="noCheck" value="0" checked/></p>
					<?php }else{?>
						<p> Ναι <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="yesCheck" value="1" checked/></p>
						<p> Όχι <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="noCheck" value="0" /></p>
						<div id="ifYes" style="margin-left:50px;">
							<input type="date" name="reminder" value="<?php echo $reminder; ?>"/> 
						</div>
					<?php }?>
					
					<div id="ifYes" style="display:none; margin-left:50px;">
						<input type="date" name="reminder" value="<?php echo $reminder; ?>"/> 
					</div>
				</p>
            </fieldset>			
            <button type="submit" name="event_change" class="button" style="background-color:#1497b8; margin-left:74.5%; margin-top:-30px;"><?php echo $edit_customer_submit_button; ?></button>
	   </form>
	   
	   <div id="copyright">
			<?php copyright(); ?>	
		</div>
		
	   <?php
			}else{
				echo '<h4 style="text-align:center;">'.$edit_no_event.'</h4></br>';
			}
		?>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		<script type="text/javascript">
			function yesnoCheck() {
				if (document.getElementById('yesCheck').checked) {
					document.getElementById('ifYes').style.display = 'block';
				} else {
					document.getElementById('ifYes').style.display = 'none';
				}
			}
		</script>
	</body>
</html>	