<?php
	include('errors_warnings.php');
	include('lock.php');
	include('copyright.php');
	include('strings.php'); 
	include('http_to_https.php');
	echo '<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"><link rel="stylesheet" type="text/css" href="css/style.css" /> '; 
	include('navbar.php');
	$dbh=connect_db();
	
	$pos_id=$_GET["pos_id"];
	$tank_id=$_GET["tank_id"];
	$tech_id=$_GET["tech_id"];
	
	$pos_id = filter_var($pos_id, FILTER_SANITIZE_NUMBER_INT);
	$tank_id = filter_var($tank_id, FILTER_SANITIZE_NUMBER_INT);
	$tech_id = filter_var($tech_id, FILTER_SANITIZE_NUMBER_INT);
	
	if (!empty($tech_id))
	{
		$sql_show_tech = $dbh->prepare("SELECT * FROM usersili INNER JOIN phonesili ON usersili.user_id=phonesili.usr_id WHERE usersili.user_id='$tech_id' AND phonesili.type='Σταθερό'");
		$sql_show_tech->execute();
		$result1 = $sql_show_tech->fetchAll();
		foreach ($result1 as $row)
		{
			$name=$row['name'];
			$surname=$row['surname'];
			$phone1=$row['number'];
		}
	}
	
	if (!empty($tank_id))
	{
		$sql_tank_model = $dbh->prepare("SELECT model FROM tanksili WHERE id='$tank_id'");
		$sql_tank_model->execute();
		$result4 = $sql_tank_model->fetchAll();	
		foreach ($result4 as $row)
		{
			$model = $row['model'];
		}
	}
	
	echo '<div style="text-align:center;"><br><br><img src="qr_generate.php?tank_id='.$tank_id.'" height="200" width="200">';
	echo '<div>
			<h5> <b>'.$possession_qr_tech.'</b>'.$surname." ".$name.' </h5>
			<h5> <b>'.$possession_qr_phone.'</b>'.$phone1.' </h5>
			<h5> <b>'.$possession_qr_model.'</b>'.$model.' </h5>
		  </div></div>';
	echo '<div style="text-align:right; margin-right:30px;"><button class="printbutton no-print" onclick="myFunction()">&#128438;<h5>'. $calendar_print.'</h5></button></div>';
?>

<script>
	function myFunction() {
		window.print();
	}
</script>