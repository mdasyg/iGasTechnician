<?php 
	include('errors_warnings.php');
	include('lock.php');

	// Values received via ajax
	$id = $_POST['eventid'];

	$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

	// insert the records
	$stmt = $dbh->prepare("DELETE FROM eventsili where id='$id'");
	$stmt->bindParam('id', $id); 
	$result = $stmt->execute();
?>