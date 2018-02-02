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
	
	$error="";
	$success="";
	
	$ds = DIRECTORY_SEPARATOR;
	$target_dir = 'tanks_photos/';
	
	if (!empty($_FILES)) 
	{
		$target_name = $_FILES["file"]["name"];
		$tempFile = $_FILES['file']['tmp_name']; 	
		$target_file = $target_dir . $target_name; 
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$hashfile = md5(uniqid(rand(), true)).'.'.$imageFileType;
		$target_hash = $target_dir . $hashfile;
			
		// Check if hash already exists
		while (file_exists($target_hash)) {
			$hashfile = md5(uniqid(rand(), true)).'.'.$imageFileType;
			$target_hash = $target_dir . $hashfile;
		}
		umask(0022);
		$move = move_uploaded_file($tempFile, $target_hash);
		chmod($target_hash, 0755);

		if ($move) 
		{		
			$id=$_GET["id"];
			$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
			
			$stmt = $dbh->prepare("INSERT INTO photosili(photo_id,tnk_id,hash,name) VALUES (:photo_id,:tnk_id,:hash,:name)");
								
			$stmt->bindParam(':photo_id', $photo_id);
			$stmt->bindParam(':tnk_id', $id);
			$stmt->bindParam(':hash', $hashfile);
			$stmt->bindParam(':name', $target_name);
						
			$result = $stmt->execute();
			if ($result)
			{
				echo $success = $tank_upload_base_success."<br>";
			}else
			{
				echo $error = $tank_upload_base_error."<br>";
			}	
		} else {
			echo '<h4 style="text-align:center;">'.$tank_upload_other_error.'</h4></br>';
		}
    }
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		<title><?=$tank_upload_title?></title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/dropzone.css">
	</head>
	<body>
		<?php include('navbar.php');   $id=$_GET["id"]; $model=$_GET["model"];  
		
		$sql = $dbh->prepare("SELECT * FROM tanksili WHERE id='$id'");
		$sql->execute();
		$result1 = $sql->fetchAll();
		foreach ($result1 as $row)
		{
			$id_val=$row['id'];
		}
			
		if (!empty($id_val))
		{
		?>
		
		<div class="header" style="margin-top:-45px;">
			<h4><?php echo $tank_upload_info.$model.'.'; ?></h4></br>
			<h4><?php echo '<a href="technician_profile.php?user_id=' .$user_id. '"><button class="exit_button">'.$username.'</button></a> ('.$type1.')</h4></br>';?>			
		</div>
		
		<div id="copyright" style="bottom:0px;">
			<?php copyright(); ?>	
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="js/dropzone.js"></script>
		<script>
			Dropzone.options.myDropzone = { 
				maxFilesize: 5,
				maxThumbnailFilesize: 5,
				acceptedMimeTypes: 'image/*, .pdf',
				addRemoveLinks: true,
				dictDefaultMessage: 'Σύρετε τα αρχεία σας εδώ <br> ή πατήστε για επιλογή αρχείων!',
				dictFallbackMessage: "Ο browser που χρησιμοποιείτε δεν υποστηρίζει drag'n'drop.",
				dictFileTooBig: "Το αρχείο είναι πολύ μεγάλο. ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.",
				dictInvalidFileType: "Επιτρέπονται μόνο αρχεία JPG, JPEG, PNG, GIF & PDF.",
				dictResponseError: "Ο Server απάντησε με {{statusCode}} κωδικό.",
				dictCancelUpload: "Ακύρωση",
				dictCancelUploadConfirmation: "Είστε σίγουρος ότι θέλετε να ακυρώσετε το ανέβασμα αυτού του αρχείου?",
				dictRemoveFile: "Αφαίρεση αρχείου",
				dictRemoveFileConfirmation: null,
				dictMaxFilesExceeded: "Δεν μπορείτε να ανεβάσετε άλλα αρχεία.",
				init: function() {
					console.log('init');
					this.on("error", function(file, message) { 
						alert(message);
						this.removeFile(file); 
					});
				}
			};
		</script>
		
		<?php 
			echo '<form action="tank_upload.php?id='.$id.'" class="dropzone" id="myDropzone" style="margin-top:40px;"></form>';
		
		}else {
				echo '<h4 style="text-align:center;">'.$moreinfo_no_tank.'</h4></br>';
			}
		?>
		
		
	</body>
</html>