<?php
	include('errors_warnings.php');
	include('lock.php');

	/* Values received via ajax */
	$id = $_POST['eventid'];
	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	
	//filter_var all variables
	$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);	
	$title = filter_var($title, FILTER_SANITIZE_STRING);
	$start = filter_var($start, FILTER_SANITIZE_STRING);
	$end = filter_var($end, FILTER_SANITIZE_STRING);

	 // update the records
	$stmt = $dbh->prepare("UPDATE eventsili SET title='$title', start='$start', end='$end' WHERE id='$id'");

	$stmt->bindParam(':title', $title);
	$stmt->bindParam(':start', $start);
	$stmt->bindParam(':end', $end);
	$result = $stmt->execute();
	if ($result)
	{
		echo json_encode(array('status'=>'success'));
	}
	else{
		echo json_encode(array('status'=>'failed'));
	}
?>