<?php
	include('errors_warnings.php');
	include('strings.php');
	include('http_to_https.php');
	session_start();
	/**
	 * Delete cookies - the time must be in the past,
	 * so just negate what you added when creating the
	 * cookie.
	 */

	if(( isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass']) ) || ( isset($_COOKIE['user']) || isset($_COOKIE['admin']) )){
		$past = time() - 60*60*24*30;
		foreach ( $_COOKIE as $key => $value )
		{
				setcookie( $key, $value, $past, '/' );
		}
	}

	session_destroy();
	echo '<html><head><META http-equiv="refresh" content="2;URL=index.php"></head>';
	echo '<h3 style="color:#013a89; margin-top:20px;">'.$logout_message.'</h3></html>';
?>
