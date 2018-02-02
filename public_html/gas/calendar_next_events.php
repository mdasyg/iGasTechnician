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
	$result1 = $sql->fetchAll();
	foreach ($result1 as $row)
	{
		$user_id1=$row['user_id'];
	}
?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=$calendar_next_title?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/customers.css" />		
		<link rel="stylesheet" type="text/css" href="css/style.css" />  
	</head>	

	<body>
		<?php include('navbar.php');
		
			echo '<div class="header" style="margin-top:-50px;">
				<h1>'. $menu_header .'</h1> </br>
				<h4> '.$events_next_header.' | <a href="technician_profile.php?user_id=' .$user_id1. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>			
			</div> ';
		
		if ($type=="super"){
		?>
		
		<div class="header" style="margin-top:-10px;">
			<div id="lessonSelect">
				<p></br></br></br> Επέλεξε τεχνικό: </br></p>
			</div>
			
			<form method="post" enctype="multipart/form-data">
				<?php
					$sql = $dbh->prepare("SELECT * FROM usersili WHERE type='technician'");
					echo '<select name="lesson_name" onchange="showUser(this.value)">';
					echo '<option value="" selected="selected"></option>';
					echo '<option value="all">'.$events_next_all.'</option>';
					$sql->execute();
					$result = $sql->fetchAll();
						
					foreach ($result as $row)
					{
						echo "<option value='".$row['user_id']."'>".$row['surname']." ".$row['name']."</option>";
					}
					echo '</select>';
				?>
			</form>
		</div>
		</br></br></br>
		
		<div id="txtHint"><b></b></div>
		
		<?php }else{
			$count = 0;
			$today = time();
			$sql = $dbh->prepare("SELECT * FROM eventsili WHERE creator_id='$user_id1'");
			$sql->execute();
			$result2 = $sql->fetchAll();
					
			foreach ($result2 as $row)
			{
				$start = strtotime( $row['start'] );
				$diff = $start - $today;
				$diff = floor($diff/(60*60*24));
								
				if ($diff >= 0) 
				{
					$count++;
				}
			}
			if ($count != 0){				
				echo '<div class="sum_table" style="margin-top:50px;">
					<table><thead><tr>
						<th>'.$events_next_title.'</th>
						<th>'.$events_next_description.'</th>
						<th>'.$events_next_start.'</th>
						<th>'.$events_next_end.'</th>
						<th>'.$events_next_cust_name.'</th>
						<th>'.$events_next_cre_name.'</th>
					</tr>';
						
						echo '<tr>';
							foreach ($result2 as $row)
							{
								$start = strtotime( $row['start'] );
								$diff = $start - $today;
								$diff = floor($diff/(60*60*24));
								
								if ($diff >= 0) 
								{
									$cust_id = $row['cust_id'];
									$cre_id = $row['creator_id'];
								
									echo "<td>";
										echo $row['title'];
									echo "</td>";
									echo "<td>";
										echo $row['description'];
									echo "</td>";
									echo "<td>";
										echo date("d-m-Y H:i:s", strtotime($row['start']));
									echo "</td>";
									echo "<td>";
										echo date("d-m-Y H:i:s", strtotime($row['end']));
									echo "</td>";
									echo "<td>";
										$sql_cust = $dbh->prepare("SELECT name,surname FROM usersili WHERE user_id='$cust_id'");
										$sql_cust->execute();
										$result1 = $sql_cust->fetchAll();
										foreach ($result1 as $row)
										{
											echo $row['surname']." ".$row['name'];
										}
									echo "</td>";
									echo "<td>";
										$sql_cre = $dbh->prepare("SELECT name,surname FROM usersili WHERE user_id='$cre_id'");
										$sql_cre->execute();
										$result2 = $sql_cre->fetchAll();
										foreach ($result2 as $row)
										{
											echo $row['surname']." ".$row['name'];
										}
									echo "</td>";
									echo "</tr>";
								}
							}
					echo '</table>
				</div>';
			}else
			{
				echo '<h4 style="text-align:center;">'.$events_next_no.'</h4></br>';
			}
		}
		?>
				
		<div id="copyright">
			<?php copyright(); ?>	
		</div>
		
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
		<script>
			function showUser(str) 
			{
				if (str=="") 
				{
					document.getElementById("txtHint").innerHTML="";
					return;
				} 
				if (window.XMLHttpRequest) 
				{
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}else 
				{ 
					// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
						document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET","events_next.php?q="+str,true);
				xmlhttp.send();
			}
		</script>
	</body>
</html>
