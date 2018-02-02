<?php
	include('errors_warnings.php');
	include('lock.php');
	include('http_to_https.php');
	
	if($_POST)
	{
		$q1 = $_POST['search'];
		
		$q = trim($q1);
		$sql_res = $dbh->prepare("SELECT id,model,fuel,manufacturer FROM tanksili WHERE model like '%$q%' or fuel like '%$q%' or manufacturer like '%$q%'");
		$sql_res->bindValue(1, "%$q%", PDO::PARAM_STR);
		$sql_res->execute();
		
		// Execute the query
		$result = $sql_res or die(print_r($dbh->errorInfo()));
		$final_label = " ";
		
		foreach ($result as $row)	
		{
			if ((isset($row['model'])) || (isset($row['fuel'])) || (isset($row['manufacturer']))){
				$id=$row['id'];
				$model=$row['model'];
				$fuel=$row['fuel'];
				$manufacturer=$row['manufacturer'];
				$b_1='<strong>'.$q.'</strong>';
				$b_2='<strong>'.$q.'</strong>';
				$b_3='<strong>'.$q.'</strong>';
				$final_1 = str_ireplace($q, $b_1, $model);
				$final_2 = str_ireplace($q, $b_2, $fuel);
				$final_3 = str_ireplace($q, $b_3, $manufacturer);
			}
			
			echo '<a href="tank_moreinfo.php?id=' .$id. '" style="text-decoration:none; color:white;"><div class="show" align="left">
				<span class="name">'. $final_1 .'</span>&nbsp;<br/>'. $final_2. '&nbsp;<br/>'.$final_label.$final_3 .'&nbsp;<br/> ID: '. $id .'<br/><br/>
			</div>';
		}
	}
?>