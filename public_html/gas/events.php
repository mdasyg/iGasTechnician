<?php
	include('errors_warnings.php');
	include('lock.php');

	// List of events
	 $json = array();
	 
	 $creator_id = $_GET['creator_id'];
	 $type = $_GET['type'];
	 
	 $creator_id = filter_var($creator_id, FILTER_SANITIZE_NUMBER_INT);
	 $type = filter_var($type, FILTER_SANITIZE_STRING);
	 
	 // Query that retrieves events
	 if ($type == "technician"){
		$requete = "SELECT * FROM eventsili WHERE creator_id='$creator_id'";
	 }
	 else if ($type == "super"){
		$requete = "SELECT * FROM eventsili";
	 }
	 
	 // Execute the query
	 $resultat = $dbh->query($requete) or die(print_r($bdd->errorInfo()));

	 // sending the encoded result to success page
	 echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));
?>