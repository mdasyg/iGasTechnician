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
	$result = $sql->fetchAll();
	foreach ($result as $row)
	{
		$user_id=$row['user_id'];
	}
	
	$creator = $dbh->prepare("SELECT user_id FROM usersili WHERE username='$username'");
	$creator->execute();
	$result = $creator->fetchAll();
	foreach ($result as $row)	
	{
		$creator_id = $row['user_id'];
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=$calendar_checklists_title?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  
		<link rel="stylesheet" type="text/css" href="css/style.css" />		
	</head>
	<body>
		<?php include('navbar.php');?> 
		
		<section>
			<form class="ac-custom ac-checkbox ac-checkmark" autocomplete="off">
				<?php 
					$day = date("D");
					if ($day == "Mon"){ $daygr = $calendar_checklists_day1; }
					else if ($day == "Tue"){ $daygr = $calendar_checklists_day2; }
					else if ($day == "Wed"){ $daygr = $calendar_checklists_day3; }
					else if ($day == "Thu"){ $daygr = $calendar_checklists_day4; }
					else if ($day == "Fri"){ $daygr = $calendar_checklists_day5; }
					else if ($day == "Sat"){ $daygr = $calendar_checklists_day6; }
					else if ($day == "Sun"){ $daygr = $calendar_checklists_day7; }
				
					echo '<div class="header no-print" style="margin-top:-50px;">
						<h4><a href="technician_profile.php?user_id=' .$user_id. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>
					</div> ';
				?>
				
				<h2> <?php echo $calendar_checklists . $daygr ." ". date("d-m-Y"); ?> 
				<button class="printbutton no-print" onclick="myFunction()"><span class="glyphicon glyphicon-file" aria-hidden="true"></span><p><?php echo $calendar_print; ?></p></button></h2>
				<ul>
					<?php
						$count = 0;
						$today = date("Y-m-d");
						
						if ($type == "technician"){
							$sql_today = $dbh->prepare("SELECT * FROM eventsili INNER JOIN usersili INNER JOIN phonesili INNER JOIN addressesili ON eventsili.cust_id=usersili.user_id AND phonesili.usr_id=usersili.user_id AND addressesili.usr_id=usersili.user_id WHERE eventsili.start LIKE '$today%' AND phonesili.type='Σταθερό' AND eventsili.creator_id='$creator_id' ORDER BY start");
						}else if ($type == "super")
						{
							$sql_today = $dbh->prepare("SELECT * FROM eventsili INNER JOIN usersili INNER JOIN phonesili INNER JOIN addressesili ON eventsili.cust_id=usersili.user_id AND phonesili.usr_id=usersili.user_id AND addressesili.usr_id=usersili.user_id WHERE start LIKE '$today%' AND phonesili.type='Σταθερό' ORDER BY start");
						}
						$sql_today->execute();
						$result1 = $sql_today->fetchAll();
						
						foreach ($result1 as $row)	
						{
							$cre_id = $row['creator_id'];
							
							$sql_cre = $dbh->prepare("SELECT * FROM usersili WHERE user_id='$cre_id'");
							$sql_cre->execute();
							$result2 = $sql_cre->fetchAll();
							foreach ($result2 as $row)	
							{
								$cre_name[] = $row['name'];
								$cre_surname[] = $row['surname'];
							}
						}
						
						foreach ($result1 as $row)	
						{
							$count++;
							
							if (empty($row['num'])){
								$row['num'] = NULL;
							}
							
							$newDate = date("h:i", strtotime($row['start']));
							echo '<li><input id="cb'.$count.'" name="cb'.$count.'" type="checkbox"><label for="cb'.$count.'"> <h4><span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;'.$newDate.' &emsp; Τεχνικός: &nbsp;'.$cre_name[$count-1]." ".$cre_surname[$count-1].'</h4>
									<h4><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;'.$row['title'].' &emsp; <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;'.$row['description'].' </h4>
									<h4><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;'.$row['name'].' '.$row['surname'].' &emsp; <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>&nbsp;'.$row['number'].'</h4>
									<h4><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;'.$row['address'].'&nbsp;'.$row['num'].', '.$row['postcode'].'&nbsp;'.$row['city'].'</h4></label> </li>';
						}
						
						if ($count == 0){
							echo '<h3 class="notstyle"> '.$calendar_noevents.' </h3>';
						}
					?> 
				</ul>
			</form>
		</section>
		
		<script src="js/svgcheckbx.js"></script>
		<script>
			function myFunction() {
				window.print();
			}
		</script>
		
	</body>
</html>