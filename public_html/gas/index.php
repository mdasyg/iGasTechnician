<?php
	include('errors_warnings.php');
	include('login.php');
	include('strings.php');
	include('http_to_https.php');
?>
<html >
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<title><?=$login_title?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<div class="header_login">
			<p> <?php echo $menu_header; ?> </p> </br>
		</div> 
			
		<div class="cont">
		<div class="container">
		<div class="demo">
			<div class="login">
				<div class="row">
				<div class="login__image">
					<div><img src="images/gas.png" alt="gas" style="width:165px;height:165px;"></div>
				</div>
				</div>
				<form class="login__form" role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
					<h5 class = "error_message"><?php echo $error; ?></h5>
					<div class="login__row">
						<svg class="login__icon name svg-icon" viewBox="0 0 20 20">
							<path d="M0,20 a10,8 0 0,1 20,0z M10,0 a4,4 0 0,1 0,8 a4,4 0 0,1 0,-8" />
						</svg>
						<input type="text" name = "username" class="login__input name" placeholder="Όνομα Χρήστη"/>
					</div>
					<div class="login__row">
						<svg class="login__icon pass svg-icon" viewBox="0 0 20 20">
							<path d="M0,20 20,20 20,8 0,8z M10,13 10,16z M4,8 a6,8 0 0,1 12,0" />
						</svg>
						<input type="password" name = "password" class="login__input pass" placeholder="Κωδικός Πρόσβασης"/>
					</div>
					<button type="submit" name = "login" class="login__submit"><?php echo $index_submit_button; ?></button>
					<p class="login__signup"><?php echo $index_question; ?> &nbsp;<a href="signup.php"><?php echo $index_signup_link; ?></a></p>
				</form>
			</div>
		</div>
		</div>
		</div> 

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="js/index.js"></script>

	</body>
</html>
