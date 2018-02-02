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
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title><?=$tanks_header?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
		<link rel="stylesheet" type="text/css" href="css/tanks.css" />  
		<link rel="stylesheet" type="text/css" href="css/style.css" />   
	</head>	
	
	<body>
		<?php include('navbar.php');?>

		<div class="header" style="margin-top:-45px;">
			<h1> <?php echo $menu_header; ?> </h1> </br>
			<h4><?php echo $tanks_header.' | <a href="technician_profile.php?user_id=' .$user_id. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>';?>						
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
				<a href="tank_add.php"><img src="images/plus.png" width="50" height="50"/><span><?php echo $tanks_add ?></span></a>
			</div>
			
			<div class="sum_table display" id="example">
				<table><thead><tr>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th><?php echo $customers_id; ?></th>
					<th><?php echo $tanks_model; ?></th>
					<th><?php echo $tanks_fuel; ?></th>
					<th><?php echo $tanks_manufacturer; ?></th>
					<th><?php echo $tanks_placement; ?></th>
				</tr></thead> 
				<tbody>
				<?php 
					$sql_show_tanks = $dbh->prepare("SELECT * FROM tanksili");
					$sql_show_tanks->execute();
					$result1 = $sql_show_tanks->fetchAll();
					echo '<tr>';
					foreach ($result1 as $row)	
					{		
						$id = $row['id'];
						$model = $row['model'];
						$icon_delete = '<img src="images/delete.png" width="46" height="40"/>';
						$icon_edit = '<img src="images/edit.png" width="40" height="40"/> ';
						$icon_upload = '<img src="images/upload.png" width="39" height="39"/> ';
						$icon_profile = '<img src="images/more_info.png" width="40" height="40"/> ';

						echo '<td style="width:90px;">';
							echo '<div class="icon_delete">';
								echo '&nbsp;<a onclick="return confirm(\'Είστε σίγουρος για τη διαγραφή;\')" href="tank_delete.php?id=' .$id. '">'.$icon_delete.'<span>'.$customers_delete.'</span></a>'; 
							echo '</div>';
						echo "</td >";
						echo '<td style="width:90px;">';
							echo '<div class="icons">';
								echo '&nbsp;<a href="tank_edit.php?id=' .$id. '">'.$icon_edit.'<span>'.$customers_edit.'</span></a>'; 
							echo '</div>';
						echo "</td >";
						echo '<td style="width:90px;">';
							echo '<div class="icons">';
								echo '&nbsp;<a href="tank_upload.php?id=' .$id. '&model='.$model.'">'.$icon_upload.'<span>'.$tanks_upload.'</span></a>'; 
							echo '</div>';
						echo "</td >";
						echo '<td style="width:90px;">';
							echo '<div class="icons">';
								echo '<a href="tank_moreinfo.php?id=' .$id. '">'.$icon_profile.'<span>'.$tanks_moreinfo.'</span></a>'; 
							echo '</div>';
						echo "</td >";
						echo "<td>";	
							echo $row['id'];
						echo "</td >";
						echo "<td>";	
							echo $row['model'];
						echo "</td >";
						echo "<td>";	
							echo $row['fuel'];
						echo "</td >";
						echo "<td >";
							echo $row['manufacturer'];
						echo "</td>";
						echo "<td>";
							echo $row['placement'];
						echo "</td>";
					echo "</tr>";	
					}?>
					</tbody>
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
							url: "tank_search.php",
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