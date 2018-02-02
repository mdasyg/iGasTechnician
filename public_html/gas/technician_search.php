<?php
	include('errors_warnings.php');
	include('lock.php');
	include('http_to_https.php');

	if($_POST)
	{		
		$q1 = $_POST['search'];
		$q = trim($q1);
		$sql_res = $dbh->prepare("SELECT user_id,name,surname FROM usersili WHERE type='technician' AND (name like '%$q%' OR surname like '%$q%')");
		$sql_res->bindValue(1, "%$q%", PDO::PARAM_STR);
		$sql_res->execute();
		 // Execute the query
		 $result = $sql_res or die(print_r($dbh->errorInfo()));
		$final_label = " ";
		
		foreach ($result as $row)	
		{
			if ((isset($row['name'])) || (isset($row['surname']))){
				$id=$row['user_id'];
				$name=$row['name'];
				$surname=$row['surname'];
				$b_1='<strong>'.$q.'</strong>';
				$b_2='<strong>'.$q.'</strong>';
				$final_1 = str_ireplace($q, $b_1, $name);
				$final_2 = str_ireplace($q, $b_2, $surname);
			}
			
			echo '<a href="technician_profile.php?user_id=' .$id. '" style="text-decoration:none; color:white;"><div class="show" align="left">
				<span class="name">'. $final_1 .'</span>&nbsp;<br/>'. $final_2. '<br/> ID: '. $id .'<br/><br/>
			</div>';
		}
	}
?>