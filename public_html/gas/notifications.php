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
	}
	
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
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title><?=$notifications_header?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css"/>  
	</head>

	<body>	
		<?php include('navbar.php');
		
			echo '<div class="header" style="margin-top:-45px;">
				<h1> '. $menu_header .' </h1> </br>
				<h4>'. $notifications_header .' | <a href="technician_profile.php?user_id=' .$user_id. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>			
			</div>';
		
			$today = time();

			echo '<div class="tableNot">';
			$counter=0;
			
			$sql_show_tanks = $dbh->prepare("SELECT * FROM tanksili INNER JOIN possessionili INNER JOIN usersili ON tanksili.id=possessionili.tank_id AND usersili.user_id=possessionili.cust_id WHERE possessionili.notification_seen=0");
			$sql_show_tanks->execute();
			$result = $sql_show_tanks->fetchAll();
			foreach ($result as $row)	
			{		
				$id = $row['id'];
				$pos_id = $row['pos_id'];
				$user_id = $row['user_id'];
				$model = $row['model'];
				$name = $row['name'];
				$surname = $row['surname'];
				$certificate_expire_date = $row['certificate_expire_date'];
				
				if (!empty($certificate_expire_date)){
					$certificate_expire1 = strtotime( $certificate_expire_date );
					$diff = $certificate_expire1 - $today;
					$diff = floor($diff/(60*60*24));
				
					if ($diff < 0) {
						echo '<div class="alert-box error">
								<h4><span> '.$notifications_error .'</span> &nbsp; '.$notifications_error_msg1.'<a href="tank_moreinfo.php?id='.$id.'"> '. $model .'</a> '.$notifications_error_msg2.' <a href="customer_profile.php?user_id=' .$user_id. '"> '. $name .' '.$surname .'</a> '.$notifications_error_msg3.' </h4></br>
								<form action="calendar.php" style="display:inline;">
									<button class="notbutton berror"> '.$notifications_button.' </button>
								</form>
								<a class="notbutton berror" onclick="return confirm(\'Αν επιλέξετε ΟΚ η ειδοποίηση δε θα εμφανιστεί ξανά. Θέλετε να συνεχίσετε;\')" href="notification_delete.php?not_id=' .$pos_id. '" style="display:inline; text-decoration:none;"> '.$notifications_seen.' </a>
							  </div>';
							  $counter = $counter + 1;
					}
					else if (($diff < 30) && $diff >0){
						echo '<div class="alert-box warning">
							    <h4><span> '.$notifications_warning.' </span> '.$notifications_error_msg1.' <a href="tank_moreinfo.php?id='.$id.'"> '. $model .'</a> '.$notifications_error_msg2.' <a href="customer_profile.php?user_id=' .$user_id. '"> '. $name .' '.$surname .'</a> '.$notifications_warning_msg1 . $diff . $notifications_warning_msg2.'</h4> </br>
								<form action="calendar.php" style="display:inline;">
									<button class="notbutton bwarning"> '.$notifications_button.'	</button>
							    </form>
								<a class="notbutton bwarning" onclick="return confirm(\'Αν επιλέξετε ΟΚ η ειδοποίηση δε θα εμφανιστεί ξανά. Θέλετε να συνεχίσετε;\')" href="notification_delete.php?not_id=' .$pos_id. '" style="display:inline; text-decoration:none;"> '.$notifications_seen.' </a>
							  </div>';
						
						$counter = $counter + 1;
					}
				}
			}
			
			$sql_show_reminder = $dbh->prepare("SELECT * FROM eventsili WHERE reminder IS NOT NULL AND reminder_seen=0");
			$sql_show_reminder->execute();
			$result1 = $sql_show_reminder->fetchAll();
			foreach ($result1 as $row)	
			{		
				$id = $row['id'];
				$title = $row['title'];
				$start1 = $row['start'];
				$reminder = $row['reminder'];
				
				$start = date("d-m-Y H:i:s", strtotime($start1));
				
				$reminder1 = strtotime( $reminder );
				$diff1 = $reminder1 - $today;
				$diff1 = floor($diff1/(60*60*24));
				
				if (($diff1 <= 0) && ($diff1 > -10)) {
					echo '<div class="alert-box notice">
							<h4><span> '.$notifications_reminder .'</span> &nbsp; '.$notifications_reminder_msg1.'<a href="event_edit.php?event_id='.$id.'"> '. $title .'</a> '.$notifications_reminder_msg2. $start .'. </h4></br>
							<a class="notbutton bnotice" onclick="return confirm(\'Αν επιλέξετε ΟΚ η ειδοποίηση δε θα εμφανιστεί ξανά. Θέλετε να συνεχίσετε;\')" href="notification_delete1.php?not_id=' .$id. '" style="display:inline; text-decoration:none;"> Το είδα! </a>
						 </div>';
						 $counter = $counter + 1;
				}
			}
			
			if (empty($counter)){
				echo '<h3 class="notstyle"> '.$notifications_no.' </h3>';
			}
		?>
		</div>	

		<div id="copyright" style="position:absolute;">
			<?php copyright(); ?>	
		</div> 
	</body>
</html>