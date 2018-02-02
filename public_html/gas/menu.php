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
			$user_id=$row['user_id'];
		}
	}
	else{
		$username = "";
		$type = "";
		$type1 = "";
		$user_id = ";";
	}
?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=$menu_title?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
    <body>
		
		<div class="container">
			<div class="header">
				<h1> <?php echo $menu_header; ?> </h1> </br>
				<h4><?php echo $menu_welcome.'<a href="technician_profile.php?user_id=' .$user_id. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')'; ?> | <a href="logout.php"><button class="exit_button" id="exit_button"> <?php echo $menu_exit_button; ?> </button></a></h4></br>			
			</div> 
			
			<div class="menustyle">
				<?php 
					if ($type == "technician"){
						include('menu_user.php');
					}
					else{
						include('menu_super.php');
					}
				?>
			</div>				
		</div>
		
		<div id="copyright" >
				<?php copyright(); ?>	
		</div>
		
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="js/jquery.iconmenu.js"></script>
		<script type="text/javascript">
			$(function() {
				$('#sti-menu').iconmenu({
					animMouseenter	: {
						'mText' : {speed : 200, easing : 'easeOutExpo', delay : 0, dir : 1},
						'sText' : {speed : 600, easing : 'easeOutExpo', delay : 400, dir : 1},
						'icon'  : {speed : 200, easing : 'easeOutExpo', delay : 0, dir : 1}
					},
					animMouseleave	: {
						'mText' : {speed : 200, easing : 'easeInExpo', delay : 150, dir : 1},
						'sText' : {speed : 200, easing : 'easeInExpo', delay : 0, dir : 1},
						'icon'  : {speed : 200, easing : 'easeInExpo', delay : 300, dir : 1}
					}
				});
			});
		</script> 
    </body>
</html>