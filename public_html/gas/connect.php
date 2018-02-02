<?php
	include('errors_warnings.php');

	function connect_db(){
		// connection information
		$host = '/zstorage/home/ictest00446/mysql/run/mysql.sock';
		$dbname = 'iliana_database';
		$user = 'root';
		$pass = 'iliana123';
		
		// connect to database or return error
		try{
			$dbh = new PDO("mysql:unix_socket=$host;dbname=$dbname;charset=utf8", $user, $pass);
			$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$dbh->query('set character_set_client=utf8');
			$dbh->query('set character_set_connection=utf8');
			$dbh->query('set character_set_results=utf8');
			$dbh->query('set character_set_server=utf8');
			$dbh->exec("set names utf8");
		}
	
		catch(PDOException $e){
			die('Connection error:' . $pe->getmessage()); 
		}
	
		return $dbh;
	}
?>