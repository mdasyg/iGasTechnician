<?php
	include('errors_warnings.php');
	include('lock.php');
	include('copyright.php');
	include('strings.php');
	include('http_to_https.php');
	$dbh=connect_db();
	
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
	
	$customer_id = 0;
	if (isset($_SESSION['user_id'])){
		$customer_id = $_SESSION['user_id'];
	}
	
	$creator = $dbh->prepare("SELECT user_id FROM usersili WHERE username='$username'");
	$creator->execute();
	$result = $creator->fetchAll();
	foreach ($result as $row)	
	{
		$creator_id = $row['user_id'];
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=$navbar_calendar?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link href='css/fullcalendar.css' rel='stylesheet' />
		<link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
	</head>
	<body>
		<?php 
			include('navbar.php');
			
			echo '<div class="header" style="margin-top:-50px;">
				<h1>'. $menu_header .'</h1> </br>
				<h4> '.$calendar_header.' | <a href="technician_profile.php?user_id=' .$user_id. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>			
			</div> ';
			
			$icon_today = '<img src="images/today.png" width="45" height="45"/> ';
			$icon_next = '<img src="images/next.png" width="45" height="45"/> ';
			
			echo '<div class="header" style="margin-top:10px;">';
						echo '<div class="icons" style="margin-left:-180px;">
							<a href="calendar_checklists.php">'.$icon_today.'<span>'.$calendar_today.'</span></a>			
						</div>';
				
						echo '<div class="icons" style="margin-top:-45px; margin-left:180px;">
							<a href="calendar_next_events.php">'.$icon_next.'<span>'.$calendar_next.'</span></a>			
						</div>';
			echo '</div>';
		?>
		
		<div id='calendar'></div>
		
		<div id="copyright">
			<?php copyright(); ?>	
		</div>
		
		<script src='js/jquery-1.10.2.min.js'></script>
		<script src='js/moment.min.js'></script>
		<script src='js/fullcalendar.min.js'></script>
		<script src='js/lang/el.js'></script>
		<script type="text/javascript">
			$(document).ready(function() 
			{
				var type = <?php echo json_encode($type); ?>;
				var creator_id = <?php echo json_encode($creator_id); ?>;
				var customer_id = <?php echo json_encode($customer_id); ?>;
				var calendar = $('#calendar').fullCalendar({
					lang: 'el',
					header: {
						left: 'prevYear prev,next nextYear today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},
					events: "events.php?creator_id=" + creator_id + "&type=" + type,
					timeFormat: 'H(:mm)', // uppercase H for 24-hour clock
					
					selectable: true,
					selectHelper: true,
					select: function(start, end) {
						var start = start.format("YYYY-MM-DD HH:mm:SS");
						var end = end.format("YYYY-MM-DD HH:mm:SS");
						window.location.href = "event_add.php?event_start=" + start + '&event_end=' + end;
						return false;
					},
					
					eventClick: function(event, jsEvent) {
						window.location.href = "event_edit.php?event_id=" + event.id;
						return false;
					},
					   
					editable: true,
					eventDrop: function(event, delta) {
						var title = event.title;
						var start = event.start.format();
						var end = (event.end == null) ? start : event.end.format();
						$.ajax({
							url: 'event_update.php',
							data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&eventid='+ event.id ,
							type: "POST",
							dataType: 'json',
							success: function(response){
								if(response.status != 'success')
								revertFunc();
							},
							error: function(e){
								revertFunc();
								alert('Error processing your request: '+e.responseText);
							}
						});
					},
					
					eventResize: function(event) {
						var title = event.title;
						var start = event.start.format();
						var end = (event.end == null) ? start : event.end.format();
						$.ajax({
							url: 'event_update.php',
							data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&eventid='+ event.id ,
							type: "POST",
							dataType: 'json',
							success: function(response){
								if(response.status != 'success')
								revertFunc();
							},
							error: function(e){
								revertFunc();
								alert('Error processing your request: '+e.responseText);
							}
						});
					},
						
					eventRender: function(event, element) {
						element.append( "<button class='event_delete'><h4 class='event_delete_size'>&#10799;</h4></button>" );
						element.find(".event_delete").click(function() {
							var con = confirm(<?php echo json_encode($calendar_delete);?>);
							if(con == true) {
								$('#calendar').fullCalendar('removeEvents',event._id);
								$.ajax({
									url: 'event_delete.php',
									data: '&eventid='+ event.id ,
									type: "POST",
									dataType: 'json'
								});
							}
							else{
								$('#calendar').fullCalendar('updateEvent',event);
							}
						});
					}
				});
			});
		</script>
	</body>
</html>