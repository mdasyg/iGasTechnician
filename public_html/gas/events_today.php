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
	
	$sql = $dbh->prepare("SELECT name,surname FROM usersili WHERE username='$username'");
	$sql->execute();
	$result = $sql->fetchAll();
	foreach ($result as $row)
	{
		$name=$row['name'];
		$surname=$row['surname'];
	}
	
	$creator = $dbh->prepare("SELECT user_id FROM usersili WHERE username='$username'");
	$creator->execute();
	$result1 = $creator->fetchAll();
	foreach ($result1 as $row)	
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
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  
		<link rel="stylesheet" type="text/css" href="css/style.css" />		
	</head>
	<body>
		<?php include('navbar.php');?> 
		
		<section>
			<form class="ac-custom ac-checkbox ac-checkmark" autocomplete="off">
				
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
							$count++;
							
							if (empty($row['num'])){
								$row['num'] = NULL;
							}
							
							$newDate = date("h:i", strtotime($row['start']));
							echo '<li><input id="cb'.$count.'" name="cb'.$count.'" type="checkbox"><label for="cb'.$count.'"> &#x1f552;&nbsp;'.$newDate.'
									<br>&#x1f4c6;&nbsp;'.$row['title'].' &emsp; &#x1f4c3;&nbsp;'.$row['description'].' 
									<br> &#x1f464;&nbsp;'.$row['name'].' '.$row['surname'].' &emsp; &#x1f4de;&nbsp;'.$row['number'].'
									 &emsp;&#x1f3e0;&nbsp;'.$row['address'].'&nbsp;'.$row['num'].', '.$row['postcode'].'&nbsp;'.$row['city'].'</label> </li>';
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