<div class="cbp-spmenu-push no-print">
	<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left no-print" id="cbp-spmenu-s1">
		<a href="menu.php" class="h3link no-print"><?php echo $navbar_menu; ?></a>
			
		<?php  
		include('errors_warnings.php');
		
		if(isset($_SESSION['type']))
		{
			$type=$_SESSION['type'];
		}
		
			$link = $_SERVER['SCRIPT_NAME'];
			$page_id = substr($link, strrpos($link, '/') + 1);
				
			if (($page_id == "calendar.php") || ($page_id == "event_edit.php") || ($page_id == "event_add.php") || ($page_id == "calendar_checklists.php") || ($page_id == "calendar_next_events.php"))
			{
				echo'<a href="calendar.php" class="cbp-spmenua"><img src="images/calendar-menu-color.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_calendar.'</a>
					<a href="notifications.php" class="cbp-spmenua"><img src="images/notifications-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_notifications.'</a>
					<a href="customers.php" class="cbp-spmenua"><img src="images/customers-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_customers.'</a>
					<a href="tanks.php" class="cbp-spmenua"><img src="images/gas-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_tanks.'</a>';
					if ((isset($type)) && ($type == "super")){
						echo '<a href="technicians.php" class="cbp-spmenua"><img src="images/technician-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_technicians.'</a>';
					}
			}
			else if ($page_id == "notifications.php")
			{
				echo'<a href="calendar.php" class="cbp-spmenua"><img src="images/calendar-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_calendar.'</a>
					<a href="notifications.php" class="cbp-spmenua"><img src="images/notifications-menu-color.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_notifications.'</a>
					<a href="customers.php" class="cbp-spmenua"><img src="images/customers-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_customers.'</a>
					<a href="tanks.php" class="cbp-spmenua"><img src="images/gas-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_tanks.'</a>';
					if ((isset($type)) && ($type == "super")){
						echo '<a href="technicians.php" class="cbp-spmenua"><img src="images/technician-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_technicians.'</a>';
					}
			}
			else if (($page_id == "customers.php") || ($page_id == "customer_add.php") || ($page_id == "customer_edit.php") || ($page_id == "customer_profile.php") || ($page_id == "possession_qr.php"))
			{
				echo'<a href="calendar.php" class="cbp-spmenua"><img src="images/calendar-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_calendar.'</a>
					<a href="notifications.php" class="cbp-spmenua"><img src="images/notifications-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_notifications.'</a>
					<a href="customers.php" class="cbp-spmenua"><img src="images/customers-menu-color.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_customers.'</a>
					<a href="tanks.php" class="cbp-spmenua"><img src="images/gas-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_tanks.'</a>';
					if ((isset($type)) && ($type == "super")){
						echo '<a href="technicians.php" class="cbp-spmenua"><img src="images/technician-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_technicians.'</a>';
					}
			}
			else if (($page_id == "tanks.php") || ($page_id == "tank_add.php") || ($page_id == "tank_edit.php") || ($page_id == "tank_moreinfo.php") || ($page_id == "tank_upload.php"))
			{
				echo'<a href="calendar.php" class="cbp-spmenua"><img src="images/calendar-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_calendar.'</a>
					<a href="notifications.php" class="cbp-spmenua"><img src="images/notifications-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_notifications.'</a>
					<a href="customers.php" class="cbp-spmenua"><img src="images/customers-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_customers.'</a>
					<a href="tanks.php" class="cbp-spmenua"><img src="images/gas-menu-color.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_tanks.'</a>';
					if ((isset($type)) && ($type == "super")){
						echo '<a href="technicians.php" class="cbp-spmenua"><img src="images/technician-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_technicians.'</a>';
					}
			}
			else if (($page_id == "technicians.php") || ($page_id == "technician_add.php") || ($page_id == "technician_edit.php") || ($page_id == "technician_profile.php") || ($page_id == "technician_change_password.php") || ($page_id == "technician_change_password1.php"))
			{
				echo'<a href="calendar.php" class="cbp-spmenua"><img src="images/calendar-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_calendar.'</a>
					<a href="notifications.php" class="cbp-spmenua"><img src="images/notifications-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_notifications.'</a>
					<a href="customers.php" class="cbp-spmenua"><img src="images/customers-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_customers.'</a>
					<a href="tanks.php" class="cbp-spmenua"><img src="images/gas-menu.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_tanks.'</a>';
					if ((isset($type)) && ($type == "super")){
						echo '<a href="technicians.php" class="cbp-spmenua"><img src="images/technician-menu-color.png" width="35" height="35"alt=""/>&nbsp;&nbsp;'.$navbar_technicians.'</a>';
					}
			}
		?>
		<a href="logout.php" id="exit_button" class="logout_link"><?php echo $menu_exit_button; ?></a>
	</nav>
			<div class="main">
				<button id="showLeft"><img src="images/menu-icon.png" width="25" height="25"alt=""/>&nbsp;&nbsp;</button>
			</div>
		</div>
		
		<script src="js/classie.js"></script>
		<script src="js/modernizr.custom.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeft = document.getElementById( 'showLeft' ),
				body = document.body;

			showLeft.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeft' );
			};

			function disableOther( button ) {
				if( button !== 'showLeft' ) {
					classie.toggle( showLeft, 'disabled' );
				}
			}
		</script>