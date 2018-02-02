<?php
	include('errors_warnings.php');
	include('lock.php');
	include('copyright.php');
	include('strings.php');
	include('http_to_https.php');
	$dbh=connect_db();
	
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
	
	if(isset($_SESSION['username']))
	{
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
			$user_id1=$row['user_id'];
		}
	}
	
	$id=$_GET["id"];
	$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

	$sql_show_tank = $dbh->prepare("SELECT * FROM tanksili WHERE id='$id'");
	$sql_show_tank->execute();
	$result = $sql_show_tank->fetchAll();
	foreach ($result as $row)
	{
		$model=$row['model'];
		$fuel=$row['fuel'];
		$placement=$row['placement'];
		$manufacturer=$row['manufacturer'];
		$heating=$row['heating'];
		$hotwater=$row['hotwater'];
		$maximum_input=$row['maximum_input'];
		$power_supply=$row['power_supply'];
		$dimensions=$row['dimensions'];
		$weight=$row['weight'];
		$chimney_in=$row['chimney_in'];
		$chimney_out=$row['chimney_out'];
	}	
	
	if (isset($_POST['file_download'])) {
		$hash=$_POST['hash'];
		$name=$_POST['name'];
		
		$hash = filter_var($hash, FILTER_SANITIZE_STRING);
		$name = filter_var($name, FILTER_SANITIZE_STRING);

		$size = filesize("tanks_photos/".$hash);
		$quoted = sprintf('"%s"', addcslashes(basename("tanks_photos/".$name), '"\\'));
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $quoted);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Length: ' . $size);
		header('Pragma: public');
		readfile("tanks_photos/".$hash);
	}
?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=$moreinfo_tank_header?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  
		<link rel="stylesheet" type="text/css" href="css/style.css" />  
	</head>	

	<body> 
		<?php include('navbar.php');?>
		
		<div class="header" style="margin-top:-45px;">
			<h1> <?php echo $menu_header; ?> </h1> </br>
			<h4><?php echo $moreinfo_tank_header.' | <a href="technician_profile.php?user_id=' .$user_id1. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>';?>			
		</div>
		
		<div id="w">
			<div id="content">
				<?php
					if ((!empty($model)) && (!empty($fuel)) && (!empty($placement)) && (!empty($manufacturer)) && (!empty($heating)))
					{	
						echo '<nav id="profiletabs_tank">
							<ul>
								<li><a href="#personal" class="sel1">'.$add_tank_general.'</a></li>
								<li><a href="#communication" class="sel2">'.$add_tank_tech.'</a></li>
								<li><a href="#logfile" class="sel3">'.$add_tank_dw.'</a></li>
								<li><a href="#files" class="sel4">'.$moreinfo_files_tab.'</a></li>
							</ul>
						</nav>
					  
						<section id="personal" class="personal">
							<h5><label>'.$moreinfo_label_model.'</label> '.$model.'</h5>
							<h5><label>'.$moreinfo_label_fuel.'</label>'.$fuel.'</h5>
							<h5><label>'.$moreinfo_label_placement.'</label>'.$placement.'</h5>
							<h5><label>'.$moreinfo_label_manufacturer.'</label>'.$manufacturer.'</h5>
						</section>
					  
						<section id="communication" class="hidden personal">
							<h5><label>'.$moreinfo_label_heating.'</label> '.$heating.' kW</h5>';
								if (!empty($hotwater)){
									echo'<h5><label>'.$moreinfo_label_hotwater.'</label> '. $hotwater .' kW</h5>';
								}
								if (!empty($maximum_input)){
									echo'<h5><label>'.$moreinfo_label_maximum_input.'</label> '. $maximum_input .' </h5>';
								}
								if (!empty($power_supply)){
									echo'<h5><label>'.$moreinfo_label_power_supply.'</label> '. $power_supply .' </h5>';
								}
						echo '</section>
					  
						<section id="logfile" class="hidden personal">';
								if (!empty($dimensions)){
									echo'<h5><label>'.$moreinfo_label_dimensions.'</label> '. $dimensions .' mm</h5>';
								}
								if (!empty($weight)){
									echo'<h5><label>'.$moreinfo_label_weight.'</label> '. $weight .' Kg</h5>';
								}
								if (!empty($chimney_in)){
									echo'<h5><label>'.$moreinfo_label_chimney_in.'</label> '. $chimney_in .' mm</h5>';
								}
								if (!empty($chimney_out)){
									echo'<h5><label>'.$moreinfo_label_chimney_out.'</label> '. $chimney_out .' mm</h5>';
								}
						echo '</section>
						
						<section id="files" class="hidden personal">';
								$sql_photos = $dbh->prepare("SELECT * FROM photosili WHERE tnk_id='$id'");
								$sql_photos->execute();
								$result1 = $sql_photos->fetchAll();
								foreach ($result1 as $row)
								{
									$hash = $row['hash'];
									$name = $row['name'];
									
									list($width, $height) = getimagesize('tanks_photos/'.$hash);
									
									if ($width < 700) {
										$width = $width*0.6;
										$height = $height*0.6;
									}else if (($width > 700) && ($width < 1200))
									{
										$width = $width*0.4;
										$height = $height*0.4;
									}else
									{
										$width = $width*0.2;
										$height = $height*0.2;
									}
									
									if (isset($hash))	{
										echo '<img src="tanks_photos/'.$hash.'" alt="'.$name.'" height="'.$height.'" width="'.$width.'"/>';
										echo '<p> '.$name.' </p>';
									}
									echo '<form method="post" action="" class="register" style="margin-top:-5px; width:auto;">';
										echo '<input type="text" name="hash" value="'.$hash.'" style="display: none;"/>';
										echo '<input type="text" name="name" value="'.$name.'" style="display: none;"/>';
										echo '<button type="submit" name="file_download"> '.$moreinfo_tank_download.' </button>';
									echo '</form>';
									echo '<a onclick="return confirm(\'Είστε σίγουρος για τη διαγραφή;\')" href="tank_file_delete.php?hash='.$hash.'&id='.$id.'" class="file_delete"><button name="file_delete"> '.$moreinfo_tank_delete.' </button></a><br><br>';
								} 
						echo '</section>';		
					}else{
						echo '<h4 style="text-align:center;">'.$moreinfo_no_tank.'</h4></br>';
					}
				?>
			</div>
		</div>
		
		<div id="copyright">
			<?php copyright(); ?>	
		</div>
		  
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('#profiletabs_tank ul li a').on('click', function(e){
					e.preventDefault();
					var newcontent = $(this).attr('href');
				
					$('#profiletabs_tank ul li a').removeClass('sel1');
					$(this).addClass('sel1');
				
					$('#content section').each(function(){
					if(!$(this).hasClass('hidden')) { $(this).addClass('hidden'); }
					});
				
					$(newcontent).removeClass('hidden');
				});
			});
		</script>
	</body>
</html>