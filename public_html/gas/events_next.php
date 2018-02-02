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
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  
		<link rel="stylesheet" type="text/css" href="css/customers.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />      
	</head>

	<body>	
		<?php
			$today = time();
			$count = 0;
			$q = intval($_GET['q']);
				
			if ($q != 0)
			{
				$tech_id = $q;
				$sql = $dbh->prepare("SELECT * FROM eventsili WHERE creator_id='$tech_id'");
			}else
			{
				$sql = $dbh->prepare("SELECT * FROM eventsili");
			}
		
			$sql->execute();
			$result = $sql->fetchAll();
			
			foreach ($result as $row)
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
				echo '<div class="sum_table" >
					<table><thead><tr>
						<th>'.$events_next_title.'</th>
						<th>'.$events_next_description.'</th>
						<th>'.$events_next_start.'</th>
						<th>'.$events_next_end.'</th>
						<th>'.$events_next_cust_name.'</th>
						<th>'.$events_next_cre_name.'</th>
					</tr>';
					
					echo '<tr>';
						foreach ($result as $row)
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
									echo $row['start'];
								echo "</td>";
								echo "<td>";
									echo $row['end'];
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
				</div>	';
			}else
			{
				echo '<h4 style="text-align:center;">'.$events_next_no.'</h4></br>';
			}
			?>
	</body>
</html>
