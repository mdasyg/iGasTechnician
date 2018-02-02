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
		$user_id1=$row['user_id'];
	}
	
	$user_id=$_GET["user_id"];
	$user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
	
	$count=0;
	$sql_show_customer = $dbh->prepare("SELECT * FROM usersili INNER JOIN phonesili INNER JOIN addressesili ON usersili.user_id=phonesili.usr_id AND usersili.user_id=addressesili.usr_id WHERE usersili.user_id='$user_id' AND phonesili.type='Σταθερό'");
	$sql_phone2 = $dbh->prepare("SELECT * FROM phonesili WHERE usr_id='$user_id' AND phonesili.type='Κινητό'");
	$sql_tank1 = $dbh->prepare("SELECT * FROM possessionili WHERE cust_id='$user_id'");
	
	$sql_show_customer->execute();
	$result1 = $sql_show_customer->fetchAll();
	foreach ($result1 as $row)
	{
		$name=$row['name'];
		$surname=$row['surname'];
		$email=$row['email'];
		$afm=$row['afm'];
		$phone1=$row['number'];
		$address=$row['address'];
		$number=$row['num'];
		$postcode=$row['postcode'];
		$city=$row['city'];
	}
	
	$sql_phone2->execute();
	$result2 = $sql_phone2->fetchAll();
	foreach ($result2 as $row)
	{
		$count++;
		$phone2=$row['number'];
	}
	if(empty($count))
	{
		$phone2="";
	}	
	if (empty($number))
	{
		$number=NULL;
	}
							
	$sql_tank1->execute();
	$result3 = $sql_tank1->fetchAll();	
	foreach ($result3 as $row)
	{
		$pos_id = $row['pos_id'];												
	}
	
	if (isset($_POST['add_notes'])) {
		$notes=$_POST['notes'];
		
		//filter_var all variables
		$notes = filter_var($notes, FILTER_SANITIZE_STRING);
		
		$stmt = $dbh->prepare("INSERT INTO notesili(note_id,possession_id,note) VALUES (:note_id,:possession_id,:note)"); 
		$note_id = "";
		
		$stmt->bindParam(':note_id', $note_id);
		$stmt->bindParam(':possession_id', $pos_id);
		$stmt->bindParam(':note', $notes);
		$stmt->execute();
		
	}
	
	if (isset($_POST['edit_notes'])) {
		$notes=$_POST['notes'];
		$note_id=$_POST['note_id'];
		
		//filter_var all variables
		$notes = filter_var($notes, FILTER_SANITIZE_STRING);
		$note_id = filter_var($note_id, FILTER_SANITIZE_NUMBER_INT);
		
		$stmt = $dbh->prepare("UPDATE notesili SET note = '$notes' WHERE note_id='$note_id'"); 
		$stmt->bindParam(':note', $notes);
		$stmt->execute();	
	}
	
	if (isset($_POST['add_tank'])) {
		$tank_id=$_POST['tank_id'];
		$installation_date=$_POST['installation_date'];
		$certificate_expire_date=$_POST['certificate_expire_date'];
		$tech_id=$_POST['tech_id'];
		
		//filter_var all variables
		$tank_id = filter_var($tank_id, FILTER_SANITIZE_NUMBER_INT);
		$installation_date = filter_var($installation_date, FILTER_SANITIZE_STRING);
		$certificate_expire_date = filter_var($certificate_expire_date, FILTER_SANITIZE_STRING);
		$tech_id = filter_var($tech_id, FILTER_SANITIZE_NUMBER_INT);
		
		$stmt_possesion = $dbh->prepare("INSERT INTO possessionili(pos_id,tank_id,cust_id,installation_date,certificate_expire_date,tech_id) VALUES (:pos_id,:tank_id,:cust_id,:installation_date,:certificate_expire_date,:tech_id)");
		
		$pos_id=''; 
		$cust_id=$user_id;
			
		$stmt_possesion->bindParam(':pos_id', $pos_id);
		$stmt_possesion->bindParam(':tank_id', $tank_id);
		$stmt_possesion->bindParam(':cust_id', $cust_id);
		$stmt_possesion->bindParam(':installation_date', $installation_date);
		$stmt_possesion->bindParam(':certificate_expire_date', $certificate_expire_date);
		$stmt_possesion->bindParam(':tech_id', $tech_id);
			
		$stmt_possesion->execute();
	}
	
	if (isset($_POST['edit_tank'])) {
		$pos_id=$_POST['pos_id'];
		$tank_id=$_POST['tank_id'];
		$installation_date=$_POST['installation_date'];
		$certificate_expire_date=$_POST['certificate_expire_date'];
		$tech_id=$_POST['tech_id'];
		
		//filter_var all variables
		$pos_id = filter_var($pos_id, FILTER_SANITIZE_NUMBER_INT);
		$tank_id = filter_var($tank_id, FILTER_SANITIZE_NUMBER_INT);
		$installation_date = filter_var($installation_date, FILTER_SANITIZE_STRING);
		$certificate_expire_date = filter_var($certificate_expire_date, FILTER_SANITIZE_STRING);
		$tech_id = filter_var($tech_id, FILTER_SANITIZE_NUMBER_INT);
		
		$stmt_possesion = $dbh->prepare("UPDATE possessionili SET tank_id = '$tank_id', installation_date = '$installation_date', certificate_expire_date = '$certificate_expire_date', tech_id = '$tech_id' WHERE pos_id='$pos_id'");
			
		$stmt_possesion->bindParam(':tank_id', $tank_id);
		$stmt_possesion->bindParam(':installation_date', $installation_date);
		$stmt_possesion->bindParam(':certificate_expire_date', $certificate_expire_date);
		$stmt_possesion->bindParam(':tech_id', $tech_id);
		
		$stmt_possesion->execute();
	}
?>

<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=$profile_customer_header?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">  
		<link rel="stylesheet" type="text/css" href="css/style.css" />  
	</head>	

	<body> 
		<?php include('navbar.php');
				$icon_edit = '<img src="images/edit.png" width="30" height="30"/> ';
				$icon_event = '<img src="images/calendar-menu.png" width="30" height="30"/> ';
				$icon_maps = '<img src="images/maps.png" width="40" height="40"/> ';
		?>
		
		<div class="header" style="margin-top:-50px;">
			<h1> <?php echo $menu_header; ?> </h1> </br>
			<h4><?php echo $profile_customer_header.' | <a href="technician_profile.php?user_id=' .$user_id1. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>';?>			
		</div>
		
		<div id="w">
			<?php 
				echo '<div class="icons" style="text-align: right;">';
					echo' <a href="customer_edit.php?user_id=' .$user_id. '">'.$icon_edit.'<span>'.$profile_customer_edit.'</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					echo' <a href="calendar.php">'.$icon_event.'<span>'.$profile_customer_event.'</span></a>';
				echo '</div>';
			?>
			<div id="content">
				<?php
					if ((!empty($surname)) && (!empty($name)) && (!empty($afm)))
					{	
						echo '<nav id="profiletabs" >
							<ul>
								<li><a href="#personal" class="sel1"> '.$profile_customer_personal.'</a></li>
								<li><a href="#logfile" class="sel2">'.$profile_customer_logfile.' </a></li>
								<li><a href="#tank_details" class="sel3">'. $profile_customer_tank_details.' </a></li>
							</ul>
						</nav>
					  
						<section id="personal" class="personal">
							<h5><label>'.$profile_label_surname.'</label> '.$surname.'</h5>
							<h5><label>'.$profile_label_name.'</label> '.$name.'</h5>
							<h5><label>'.$profile_label_afm.'</label> '.$afm.'</h5>
							<h5><label>'.$profile_label_phone1.'</label> '.$phone1.'</h5>';
							if (!empty($phone2)){
								echo'<h5><label>'.$profile_label_phone2.'</label> '. $phone2 .'</h5>';
							}
							if (!empty($email)){
								echo'<h5><label>'. $profile_label_email.'</label> '. $email .'</h5>';
							}
							
							$country = $signup_greece;
							$placestring = $address." ".$number." ".$postcode." ".$city;
							echo '<h5><label>'. $profile_label_address .'</label> <a target="_blank" href="//maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q='.$placestring.'&amp;aq=&amp;sll=&amp;sspn=&amp;vpsrc=0&amp;ie=UTF8&amp;hq=&amp;hnear='.$country.'&amp;t=h&amp;z=12" style="text-decoration:none;">'. $address ." ".$number.' <br> ';
							echo '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;'.$postcode.' '.$city.' </a></h5>
							<a target="_blank" href="//maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q='.$placestring.'&amp;aq=&amp;sll=&amp;sspn=&amp;vpsrc=0&amp;ie=UTF8&amp;hq=&amp;hnear='.$country.'&amp;t=h&amp;z=12" style="text-decoration:none; position:absolute; margin-top:-30px; margin-left:38px;">'.$icon_maps.'</a>
						</section>
					  
						<section id="logfile" class="hidden personal">'; 
							echo' <div>
									  <button id="show" class="notes_button"><img src="images/plus.png" width="30" height="30"/><span>Προσθήκη Σημείωσης</span></button>
								  </div>';
							echo' <form method="post" action="" class="add_note" style="display:none; border-width:3px; border-color:#999; border-style:dashed; text-align:center;">	
									  <h5>
										  <label>Σημείωση: </label>
										  <textarea rows="3" cols="30" name="notes" required> </textarea>
									  </h5>
									  <input type="submit" name="add_notes" class="button" style="background-color:#660013; width:100px; font-size:12px; margin-left:0px; margin-top:-10px;"></input>		
								  </form><br>';
						
							$sql_logfile = $dbh->prepare("SELECT * FROM eventsili WHERE cust_id='$user_id'");
							$sql_logfile->execute();
							$result4 = $sql_logfile->fetchAll();
							foreach ($result4 as $row)
							{
								$title = $row['title'];
								$start = $row['start'];
								$description = $row['description'];
								$creator_id = $row['creator_id'];
								echo '<h5 class="logfile">'. $start .' - '. $title .' </h5>';
							}
							
							$icon_delete = '<img src="images/delete.png" width="25" height="19"/>';
							$icon_edit1 = '<img src="images/edit.png" width="19" height="19"/> ';
							$icon_qr = '<img src="images/qr_code.png" width="19" height="19"/>';
							$count = 0;
							
							$sql__notes = $dbh->prepare("SELECT * FROM notesili WHERE possession_id='$pos_id'");
							$sql__notes->execute();
							$result5 = $sql__notes->fetchAll();
							foreach ($result5 as $row)
							{
								$note_id = $row['note_id'];
								$notes = $row['note'];
								$count++;
								if (!empty($notes))
								{
									echo '<h5 class="logfile">Σημείωση: '. $notes .'  &nbsp;&nbsp;&nbsp;<a onclick="return confirm(\'Είστε σίγουρος για τη διαγραφή;\')" href="note_delete.php?note_id=' .$note_id. '&user_id='.$user_id.'">'.$icon_delete.'</a>  <button class="edit_notes_button'.$count.'" style="background:none;">'.$icon_edit1.'</button></h5>';
									echo' <form method="post" action="" class="edit_note'.$count.'" style="display:none; border-width:3px; border-color:#999; border-style:dashed; text-align:center;">	
											  <h5>
												  <input type="text" name="note_id" style="display:none;" value="'.$note_id.'"/>
												  <label>Σημείωση: </label>
												  <textarea rows="3" cols="30" name="notes" required> '.$notes.' </textarea>
											  </h5>
											  <input type="submit" name="edit_notes" class="button" style="background-color:#660013; width:100px; font-size:12px; margin-left:0px; margin-top:-10px;"></input>		
										  </form><br>';
								}
							}
						echo '</section>
						
						<section id="tank_details" class="hidden personal">	';
							echo ' <div>
								<button id="show" class="notes_button"><img src="images/plus.png" width="30" height="30"/><span>Προσθήκη Δεξαμενής</span></button>
							</div><br>
							<form method="post" action="" class="add_tank" style="display:none; border-width:3px; border-color:#999; border-style:dashed; text-align:center;">	
								<h5>
									<label>'.$add_customer_tank.'</label>
									<select name="tank_id" required>
										<option></option>';
										$sql_tank=$dbh->prepare("SELECT * FROM tanksili");
										$sql_tank->execute();
										$result6 = $sql_tank->fetchAll();
										foreach ($result6 as $row)
										{
											echo '<option value="'.$row['id'].'">'.$row['model'];
										}
										echo '</option>
									</select>
								</h5>
								<h5>
									<label class="optional">'. $add_customer_installation_date.'</label>
									<input type="date" name="installation_date" value="'. date('Y-m-d').'"/> 
								</h5>
								<h5>
									<label class="optional">'. $add_customer_certificate_expire.'</label>
									<input type="date" name="certificate_expire_date" value="'. date('Y-m-d').'"/> 
								</h5>
								<h5>
									<label>'.$add_customer_tech.'</label>
									<select name="tech_id" required>
										<option></option>';
										$sql_tech=$dbh->prepare("SELECT * FROM usersili WHERE type='technician' OR type='super'");
										$sql_tech->execute();
										$result7 = $sql_tech->fetchAll();
										foreach ($result7 as $row)
										{
											echo '<option value="'.$row['user_id'].'">'.$row['surname']." ".$row['name'];
										}
										echo '</option>
									</select>
								</h5>
								<input type="submit" name="add_tank" class="button" style="background-color:#660013; width:100px; font-size:12px; margin-left:0px; margin-top:-10px;"></input>		
							</form><br>';
						
							$sql_pos = $dbh->prepare("SELECT * FROM possessionili WHERE cust_id='$user_id'");
							$count_tanks=0;
							
							$sql_pos->execute();
							$result8 = $sql_pos->fetchAll();	
							foreach ($result8 as $row)
							{
								$pos_id = $row['pos_id'];
								$tank_id = $row['tank_id'];
								$installation_date = $row['installation_date'];
								$certificate_expire_date = $row['certificate_expire_date'];
								$tech_id = $row['tech_id'];
								$count_tanks++;
														
								if (!empty($tank_id))
								{
									$sql_tank_model = $dbh->prepare("SELECT model FROM tanksili WHERE id='$tank_id'");
									$sql_tank_model->execute();
									$result9 = $sql_tank_model->fetchAll();	
									foreach ($result9 as $row)
									{
										$model = $row['model'];
									}
								}
								
								if (!empty($tech_id))
								{
									$sql_tech_name = $dbh->prepare("SELECT name,surname FROM usersili WHERE user_id='$tech_id'");
									$sql_tech_name->execute();
									$result10 = $sql_tech_name->fetchAll();	
									foreach ($result10 as $row)
									{
										$name = $row['name'];
										$surname = $row['surname'];
									}
								}
							
								echo '
								<h4> '.$profile_tank.' '.$count_tanks.' &nbsp;&nbsp;&nbsp;<a onclick="return confirm(\'Είστε σίγουρος για τη διαγραφή;\')" href="possession_delete.php?pos_id=' .$pos_id. '&user_id='.$user_id.'">'.$icon_delete.'</a> &nbsp; <button class="edit_tanks_button'.$count_tanks.'" style="background:none;">'.$icon_edit1.'</button> &nbsp; <a href="possession_qr.php?pos_id=' .$pos_id. '&tank_id='.$tank_id. '&tech_id='.$tech_id.'">'.$icon_qr.'</a>
								<h5><label>'.$profile_label_tank.'</label> <a href="tank_moreinfo.php?id=' .$tank_id. '">'. $model.' </a></h5>
								<h5><label>'.$profile_label_installation_date.'</label> '. $installation_date.'</h5>
								<h5><label>'.$profile_label_certificate_expire.'</label> '. $certificate_expire_date.'</h5>
								<h5><label>'.$profile_label_tech_name.'</label> '. $surname." ".$name.'</h5><br>
								
								<form method="post" action="" class="edit_tank'.$count_tanks.'" style="display:none; border-width:3px; border-color:#999; border-style:dashed; text-align:center;">	
									<input type="text" name="pos_id" style="display:none;" value="'.$pos_id.'"/>
									<h5>
										<label>'.$add_customer_tank.'</label>
										<select name="tank_id" required>
											<option></option>';
											$sql_tank=$dbh->prepare("SELECT * FROM tanksili");
											$sql_tank->execute();
											$result11 = $sql_tank->fetchAll();
											foreach ($result11 as $row)
											{?>
												<option <?php if ($row['id']==$tank_id) { ?>selected="selected"<?php } ?> value="<?php echo $row['id']; ?>" > <?php echo $row['model']; 
											}
											echo '</option>
										</select>
									</h5>
									<h5>
										<label class="optional">'. $add_customer_installation_date.'</label>
										<input type="date" name="installation_date" value="'. $installation_date .'"/> 
									</h5>
									<h5>
										<label class="optional">'. $add_customer_certificate_expire.'</label>
										<input type="date" name="certificate_expire_date" value="'. $certificate_expire_date .'"/> 
									</h5>
									<h5>
									<label>'.$add_customer_tech.'</label>
									<select name="tech_id" required>
										<option></option>';
										$sql_tech=$dbh->prepare("SELECT * FROM usersili WHERE type='technician' OR type='super'");
										$sql_tech->execute();
										$result12 = $sql_tech->fetchAll();
										foreach ($result12 as $row)
										{?>
											<option <?php if ($row['user_id']==$tech_id) { ?>selected="selected"<?php } ?> value="<?php echo $row['user_id']; ?>" > <?php echo $row['surname']." ".$row['name']; 
										}
										echo '</option>
									</select>
								</h5>
									<input type="submit" name="edit_tank" class="button" style="background-color:#660013; width:100px; font-size:12px; margin-left:0px; margin-top:-10px;"></input>		
								</form><br>';
							}
						echo '</section>';
					}else{
						echo '<h4 style="text-align:center;">'.$profile_no_customer.'</h4></br>';
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
				$('#profiletabs ul li a').on('click', function(e){
					e.preventDefault();
					var newcontent = $(this).attr('href');
				
					$('#profiletabs ul li a').removeClass('sel1');
					$(this).addClass('sel1');
				
					$('#content section').each(function(){
					if(!$(this).hasClass('hidden')) { $(this).addClass('hidden'); }
					});
				
					$(newcontent).removeClass('hidden');
				});
			});
		</script>
		<script>
			$(document).ready(function(){
				$(".notes_button").click(function(){
					$(".add_note").toggle();
				});
			});
		</script>
		<script>
			$(document).ready(function(){
				$(".notes_button").click(function(){
					$(".add_tank").toggle();
				});
			});
		</script>
		<script>
			$(document).ready(function(){
				$(".edit_notes_button1").click(function(){
					$(".edit_note1").toggle();
				});
				$(".edit_notes_button2").click(function(){
					$(".edit_note2").toggle();
				});
				$(".edit_notes_button3").click(function(){
					$(".edit_note3").toggle();
				});
				$(".edit_notes_button4").click(function(){
					$(".edit_note4").toggle();
				});
				$(".edit_notes_button5").click(function(){
					$(".edit_note5").toggle();
				});
				$(".edit_notes_button6").click(function(){
					$(".edit_note6").toggle();
				});
				$(".edit_notes_button7").click(function(){
					$(".edit_note7").toggle();
				});
				$(".edit_notes_button8").click(function(){
					$(".edit_note8").toggle();
				});
				$(".edit_notes_button9").click(function(){
					$(".edit_note9").toggle();
				});
				$(".edit_notes_button10").click(function(){
					$(".edit_note10").toggle();
				});
			});
		</script>
		<script>
			$(document).ready(function(){
				$(".edit_tanks_button1").click(function(){
					$(".edit_tank1").toggle();
				});
				$(".edit_tanks_button2").click(function(){
					$(".edit_tank2").toggle();
				});
				$(".edit_tanks_button3").click(function(){
					$(".edit_tank3").toggle();
				});
				$(".edit_tanks_button4").click(function(){
					$(".edit_tank4").toggle();
				});
				$(".edit_tanks_button5").click(function(){
					$(".edit_tank5").toggle();
				});
			});
		</script>
	</body>
</html>