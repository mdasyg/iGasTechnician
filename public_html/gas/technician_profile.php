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
	
	$user_id=$_GET["user_id"];
	$user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
	
	$count=0;
	$sql_show_customer = $dbh->prepare("SELECT * FROM usersili INNER JOIN phonesili ON usersili.user_id=phonesili.usr_id WHERE usersili.user_id='$user_id' AND usersili.type='technician' OR usersili.type='super' AND phonesili.type='Σταθερό'");
	$sql_phone2 = $dbh->prepare("SELECT * FROM phonesili WHERE usr_id='$user_id' AND phonesili.type='Κινητό'");
	
	$sql_show_customer->execute();
	$result = $sql_show_customer->fetchAll();
	foreach ($result as $row)
	{
		$name=$row['name'];
		$surname=$row['surname'];
		$email=$row['email'];
		$phone1=$row['number'];
	}
	
	$sql_phone2->execute();
	$result1 = $sql_phone2->fetchAll();
	foreach ($result1 as $row)
	{
		$count++;
		$phone2=$row['number'];
	}
	if(empty($count))
	{
		$phone2="";
	}
	
	$user_id1=0;
	if(isset($username))
	{
		$sql = $dbh->prepare("SELECT user_id FROM usersili WHERE username='$username'");
		$sql->execute();
		$result2 = $sql->fetchAll();
		foreach ($result2 as $row)
		{
			$user_id1=$row['user_id'];
		}
	}
?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=$profile_technician_header?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  
		<link rel="stylesheet" type="text/css" href="css/style.css" />  
	</head>	

	<body> 
		<?php 
			include('navbar.php');
			$icon_pass = '<img src="images/pass_change.png" width="30" height="30"/>';
			$icon_edit = '<img src="images/edit.png" width="30" height="30"/> ';
		?>
		
		<div class="header" style="margin-top:-45px;">
			<h1> <?php echo $menu_header; ?> </h1> </br>
			<h4><?php if ($user_id1 == $user_id){ echo $profile_technician_my.' | <a href="technician_profile.php?user_id=' .$user_id1. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>'; } else{ echo $profile_technician_header.' | <a href="technician_profile?user_id=' .$user_id1. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>';}?>						
		</div>
			
		<div id="w">
			<?php 
				if ($user_id1 == $user_id){ 
					echo '<div class="icons" style="text-align: right;">';
						echo '<a href="technician_change_password.php?user_id=' .$user_id. '">'.$icon_pass.'<span>'.$profile_technician_change_pass.'</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<a href="technician_edit.php?user_id=' .$user_id. '">'.$icon_edit.'<span>'.$customers_edit.'</span></a>';
					echo '</div>';
				}
			?>
				
			<div id="content">
				<?php
					if ((!empty($surname)) && (!empty($name)))
					{
						echo '<nav id="profiletabs_tech">
							<ul>
								<li><a href="#personal" class="sel1">'.$profile_customer_personal.'</a></li>
								<li><a href="#communication" class="sel2">'.$profile_customer_communication.'</a></li>
								<li><a href="#logfile" class="sel3">'.$profile_customer_logfile.'</a></li>
							</ul>
						</nav>
						
						<section id="personal" class="personal">
							<h5><label>'.$profile_label_surname.'</label> '. $surname.'</h5>
							<h5><label>'.$profile_label_name.'</label> '. $name.'</h5>
						</section>
					  
						<section id="communication" class="hidden personal">
							<h5><label>'. $profile_label_phone1.'</label> '. $phone1.'</h5>';
							 
							if (!empty($phone2)){
								echo'<h5><label>'.$profile_label_phone2.'</label> '. $phone2 .'</h5>';
							}
							if (!empty($email)){
								echo'<h5><label>'. $profile_label_email.'</label> '. $email .'</h5>';
							}
						echo'</section>
					  
						<section id="logfile" class="hidden personal">';
		
								$sql_logfile = $dbh->prepare("SELECT * FROM eventsili WHERE creator_id='$user_id'");
								$sql_logfile->execute();
								$result3 = $sql_logfile->fetchAll();
								foreach ($result3 as $row)
								{
									$title = $row['title'];
									$start = $row['start'];
									$description = $row['description'];
									$creator_id = $row['creator_id'];
									echo '<h5 class="logfile">'. $start .' - '. $title .' </h5>';
								}
							
						echo '</section>';
					}else{
						echo '<h4 style="text-align:center;">'.$profile_no_technician.'</h4></br>';
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
				$('#profiletabs_tech ul li a').on('click', function(e){
					e.preventDefault();
					var newcontent = $(this).attr('href');
				
					$('#profiletabs_tech ul li a').removeClass('sel1');
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