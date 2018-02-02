<?php
	include('errors_warnings.php');

		if((isset($_SESSION['type'])) && ($_SESSION['type'] != "technician") || ((!isset($_SESSION['username'])) && (!isset($_SESSION['password'])))){
			header( 'Location: index.php' );
		}
		
		echo '
			<div class="row" style="margin-left:8px;"><div class="col-md-offset-1 col-md-12">
				<ul id="sti-menu" class="sti-menu" >
					<li data-hovercolor="#d869b2">
						<a href="calendar.php">
							<h2 data-type="mText" class="sti-item">'. $menu_calendar.'</h2>
							<h3 data-type="sText" class="sti-item"> '. $menu_calendar_text.'</h3>
							<div class="row"><div class="col-xs-offset-3 col-xs-8 col-md-offset-3 col-md-9">
								<span data-type="icon" class="sti-icon sti-icon-care sti-item"></span>
							</div></div>
						</a>
					</li>
					<li data-hovercolor="#57e676">
						<a href="notifications.php">
							<h2 data-type="mText" class="sti-item">'. $menu_notifications.'</h2>
							<h3 data-type="sText" class="sti-item">'. $menu_notifications_text.'</h3>
							<div class="row"><div class="col-xs-offset-3 col-xs-9 col-md-offset-3 col-md-6">
								<span data-type="icon" class="sti-icon sti-icon-alternative sti-item"></span>
							</div></div>
						</a>
					</li>
					<li data-hovercolor="#ff395e">
						<a href="customers.php">
							<h2 data-type="mText" class="sti-item">'. $menu_customers.'</h2>
							<h3 data-type="sText" class="sti-item">'. $menu_customers_text.'</h3>
							<div class="row"><div class="col-xs-offset-3 col-xs-9 col-md-offset-3 col-md-9">
								<span data-type="icon" class="sti-icon sti-icon-info sti-item"></span>
							</div></div>
						</a>
					</li>
					<li data-hovercolor="#37c5e9">
						<a href="tanks.php">
							<h2 data-type="mText" class="sti-item">'. $menu_tanks.'</h2>
							<h3 data-type="sText" class="sti-item">'. $menu_tanks_text.'</h3>
							<div class="row"><div class="col-xs-offset-3 col-xs-10 col-md-offset-3 col-md-7">
								<span data-type="icon" class="sti-icon sti-icon-family sti-item"></span>
							</div></div>
						</a>
					</li> 
				</ul>
			</div></div>
		';
?>