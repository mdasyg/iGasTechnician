<?php
	include('errors_warnings.php');

	function copyright()
	{
		include('strings.php');
		
		echo'<p>'.$copyright_developed.'<a href="mailto:ilianaway.10@gmail.com" target="_top">'.$copyright_myname.'</a>'.$copyright_supervised.'<a href="mailto:mdasyg@ieee.org" target="_top">'.$copyright_mdname.'</a> </p> ';
		echo'<p><a target="_blank" href="http://www.uowm.gr/">'.$copyright_university.'</a>'.$copyright_column.'<a target="_blank" href="http://www.icte.uowm.gr/">'.$copyright_department.'</a></p>';
	}
?>
