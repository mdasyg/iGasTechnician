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
?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=$customers_header?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  
		<link rel="stylesheet" type="text/css" href="css/customers.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />  
	</head>	

	<body>
		<?php include('navbar.php');?>

		<div class="header" style="margin-top:-45px;">
			<h1> <?php echo $menu_header; ?> </h1> </br>
			<h4><?php echo $customers_header .' | <a href="technician_profile.php?user_id=' .$user_id. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>';?>		
		</div>
		
		<div class="container">
			<div id="wrap">
				<input type="text" class="search" id="searchid" name="search" placeholder="Αναζήτηση... " >&nbsp; &nbsp;
				<input class="search" id="search_submit" value="Rechercher" type="submit">				
			 </div>
			 
			<div id="result"></div>
		</div>

		<div id="tableForm" style="margin-top:-135px;">
			<div class=" plus_icon">
				<a href="customer_add.php"><img src="images/plus.png" width="50" height="50"/><span><?php echo $customers_add ?></span></a>
			</div>
			
			<div class="sum_table display" id="example">
				<table><thead><tr>
					<th></th>
					<th></th>
					<th></th>
					<th style="width:70px;"><?php echo $customers_id; ?></th>
					<th><?php echo $customers_surname; ?></th>
					<th><?php echo $customers_name; ?></th>
					<th><?php echo $customers_phone; ?></th>
				</tr></thead> 
				<tbody>
				<?php 
					$sql_show_customers = $dbh->prepare("SELECT * FROM usersili INNER JOIN phonesili ON usersili.user_id=phonesili.usr_id WHERE usersili.type='customer' AND phonesili.type='Σταθερό'");
					$sql_show_customers->execute();
					$result1 = $sql_show_customers->fetchAll();
					echo '<tr>';
					foreach ($result1 as $row)	
					{		
						$user_id = $row['user_id'];
						$icon_delete = '<img src="images/delete.png" width="46" height="40"/>';
						$icon_edit = '<img src="images/edit.png" width="40" height="40"/> ';
						$icon_profile = '<img src="images/profile.png" width="41" height="42"/> ';
						$icon_appointment = '<img src="images/appointment.png" width="40" height="40"/> ';

						echo '<td style="width:90px;">';
							echo '<div class="icon_delete">';
								echo '&nbsp;<a onclick="return confirm(\'Είστε σίγουρος για τη διαγραφή;\')" href="customer_delete.php?user_id=' .$user_id. '">'.$icon_delete.'<span>'.$customers_delete.'</span></a>'; 
							echo '</div>';
						echo "</td >";
						echo '<td style="width:90px;">';
							echo '<div class="icons">';
								echo '&nbsp;<a href="customer_edit.php?user_id=' .$user_id. '">'.$icon_edit.' <span>'.$customers_edit.'</span></a>'; 
							echo '</div>';
						echo "</td >";
						echo '<td style="width:90px;">';
							echo '<div class="icons">';
								echo '<a href="customer_profile.php?user_id=' .$user_id. '">'.$icon_profile.'<span>'.$customers_profile.'</span></a>'; 
							echo '</div>';
						echo "</td >";
						echo "<td>";	
							echo $row['user_id'];
						echo "</td >";
						echo "<td>";	
							echo $row['surname'];
						echo "</td >";
						echo "<td >";
							echo $row['name'];
						echo "</td>";
						echo "<td>";
							echo $row['number'];
						echo "</td>";
					echo "</tr>";	
					}
					echo "</tbody>"; 
					$_SESSION['user_id'] = $user_id;?>
			    </table>
			</div>	
		</div>
		
		<div id="copyright">
			<?php copyright(); ?>	
		</div>
		
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript">
			$(function()
			{
				$(".search").keyup(function() 
				{	 
					var searchid = $(this).val();
					var dataString = 'search='+ searchid;
					if(searchid!='')
					{
						$.ajax(
						{
							type: "POST",
							url: "customer_search.php",
							data: dataString,
							cache: false,
							success: function(html)
							{
								$("#result").html(html).show();
							}
						});
					}return false;    
				});

				jQuery("#result").live("click",function(e){ 
					var $clicked = $(e.target);
					var $name = $clicked.find('.name').html();
					var decoded = $("<div/>").html($name).text();
					$('#searchid').val(decoded);
				});
				jQuery(document).live("click", function(e) { 
					var $clicked = $(e.target);
					if (! $clicked.hasClass("search")){
						jQuery("#result").fadeOut(); 
					}
				});
				$('#searchid').click(function(){
					jQuery("#result").fadeIn();
				});
				$(document).click(function(e) {
					if (!$(e.target).closest('#result').length) {
						$('#result').fadeOut();
					}
				});
			});
		</script> 
		
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable( {
					"aaSorting": [[ 4, "desc" ]]
				} );
			} );
		</script>
		
	</body>
</html>