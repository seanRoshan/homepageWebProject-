<? include ($_SERVER['DOCUMENT_ROOT']."/phpscripts/"."session.php") ?>
<?
	if (!isset($_SESSION['authorizedUser'])){
		error_reporting(E_ALL);
		header("location: index.php");
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="css/homepage.css" rel="stylesheet" type="text/css">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="js/jquery.slim.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/c71879315a.js"></script>
	
	<title>Site Management</title>
	
</head>



<? include ($_SERVER['DOCUMENT_ROOT']."/phpscripts/"."connectDB.php") ?>
	

<?
	
	unset($_SESSION['tagName']);
	unset($_SESSION['submitStatus']);

	if ( isset($_POST['teachingSubmit']) ) {
		$jobTitle = test_input($_POST['Tjobtitle']);
		$jobLocation = $_POST['Tjoblocation'];
		$jobStartDateMonth = $_POST['TstartDateMonth'];
		$jobStartDateYear = $_POST['TstartDateYear'];
		$jobEndDateMonth = $_POST['TendDateMonth'];
		$jobEndDateYear = $_POST['TendDateYear'];
		$jobDescription = test_input2($_POST['Tjobdescription']);
		
		
		$sql = "INSERT INTO teachingExperiences (`Title`, `University`, `startMonth`, `startYear`, `endMonth`, `endYear`, `Description`)
				VALUES ('$jobTitle','$jobLocation','$jobStartDateMonth','$jobStartDateYear','$jobEndDateMonth','$jobEndDateYear','$jobDescription')";

		if ($con->query($sql) === TRUE) {
			//header("Location: individual_listing.php?listname=".$uniqueListingTitle);
			$_SESSION['submitStatus'] = "success";	
			$_SESSION['tagName'] = "TE";
			
			$sql_id = "SELECT MAX(id) FROM `teachingExperiences`";
			$result_id = mysqli_query($con, $sql_id);
			$row_id = mysqli_fetch_array($result_id);
			
			$entryID = $row_id['MAX(id)'];
			$tableName = 'teachingExperiences';
						
			$sql_tags = "SELECT * FROM `tags` WHERE 1";
			$result_tags = mysqli_query($con, $sql_tags);
										   	
			while ($row_tags = mysqli_fetch_array($result_tags)) {
				if ($_POST[$row_tags['tagName']]){
					$tagName = $_POST[$row_tags['tagName']];
					
					$sql = "INSERT INTO tagsDB (`tagName`, `tableName`, `entryID`)
					VALUES ('$tagName','$tableName','$entryID')";
					
					if ($con->query($sql) === TRUE) {
						//echo "tag added successfully!"."<br>";
					}
					else {
						$_SESSION['submitStatus'] = "error";
					}

				}
			}
			
		} 
		else {
			$_SESSION['submitStatus'] = "error";
			$_SESSION['tagName'] = "TE";
		}
	}
	
	if ( isset($_POST['researchSubmit']) ) {
		
		$researchTitle = test_input($_POST['Lresearchtitle']);
		
		$labTitle = $_POST['Llabtitle'];
		$labLocation =  $_POST['Llablocation'];
		$labURL = $_POST['Llaburl'];
		
		$advisor = $_POST['Ladvisor'];
		$advisorURL = $_POST['Ladvisorurl'];
			
		
		$jobStartDateMonth = $_POST['LstartDateMonth'];
		$jobStartDateYear = $_POST['LstartDateYear'];
		$jobEndDateMonth = $_POST['LendDateMonth'];
		$jobEndDateYear = $_POST['LendDateYear'];
		
		$jobDescription = test_input2($_POST['Ljobdescription']);
		
		
		$target_dir = "files/";
		$msg = "?";
		$noImg = true;

		if ($_FILES['filesToUploadPDF']['tmp_name']){
		
			$noImg = false;

			$name = $_FILES['filesToUploadPDF']['name'];
			$size = $_FILES['filesToUploadPDF']['size'];
			$type = $_FILES['filesToUploadPDF']['type'];
			$file = $_FILES['filesToUploadPDF']['tmp_name'];
			
			$target_file = $target_dir . $_SERVER['REQUEST_TIME'] ."_" . basename($name);
			
			$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$uploadOk = 1;


			// Check if file already exists and rename if necessary
			if (file_exists($target_file)) {
				$renameIndex = 1;
				while (file_exists($target_file ."(".$renameIndex.")")){
					$renameIndex++;
				}
				$target_file = $target_file ."(".$renameIndex.")";
			}

			// Check file size is less than 10MB
			if ($size > 10000000) {
				$msg = $msg."&largeFile=1";
				$uploadOk = 0;
			}


			// Allow certain file formats
			if($fileType != "pdf" ) {
					$msg = $msg."&invalidType=1";
					$uploadOk = 0;
			}


			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			} else {

				if (move_uploaded_file($file, $target_file)) {
					$target_file_pdf = $target_file;
				}
				else {
					$uploadOk = 0;
				}
			}

		}
		
		
		$target_dir = "files/";
		$msg = "?";
		$noImg = true;

		if ($_FILES['filesToUploadPPT']['tmp_name']){
		
			$noImg = false;

			$name = $_FILES['filesToUploadPPT']['name'];
			$size = $_FILES['filesToUploadPPT']['size'];
			$type = $_FILES['filesToUploadPPT']['type'];
			$file = $_FILES['filesToUploadPPT']['tmp_name'];
			
			$target_file = $target_dir . $_SERVER['REQUEST_TIME'] ."_" . basename($name);
			
			$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$uploadOk = 1;


			// Check if file already exists and rename if necessary
			if (file_exists($target_file)) {
				$renameIndex = 1;
				while (file_exists($target_file ."(".$renameIndex.")")){
					$renameIndex++;
				}
				$target_file = $target_file ."(".$renameIndex.")";
			}

			// Check file size is less than 10MB
			if ($size > 10000000) {
				$msg = $msg."&largeFile=1";
				$uploadOk = 0;
			}


			// Allow certain file formats
			if( ($fileType != "pptx") && ($fileType != "ppt") ) {
					$msg = $msg."&invalidType=1";
					$uploadOk = 0;
			}


			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			} else {

				if (move_uploaded_file($file, $target_file)) {
					$target_file_ppt = $target_file;
				}
				else {
					$uploadOk = 0;
				}
			}

		}
		
		$sql = "INSERT INTO `researchExperiences`(`researchTitle`, `labTitle`, `labLocation`, `labURL`, `labAdvisor`, `labAdvisorURL`, `startDateMonth`, `startDateYear`, `endDateMonth`, `endDateYear`, `labDescription`, `pdfDir`, `pptDir`) VALUES ('$researchTitle','$labTitle','$labLocation','$labURL','$advisor','$advisorURL','$jobStartDateMonth','$jobStartDateYear','$jobEndDateMonth','$jobEndDateYear','$jobDescription','$target_file_pdf','$target_file_ppt')";

		if ($con->query($sql) === TRUE) {
			//header("Location: individual_listing.php?listname=".$uniqueListingTitle);
			$_SESSION['submitStatus'] = "success";	
			$_SESSION['tagName'] = "RE";
			
			$sql_id = "SELECT MAX(researchID) FROM `researchExperiences`";
			$result_id = mysqli_query($con, $sql_id);
			$row_id = mysqli_fetch_array($result_id);
			
			$entryID = $row_id['MAX(researchID)'];
			$tableName = 'researchExperiences';
						
			$sql_tags = "SELECT * FROM `tags` WHERE 1";
			$result_tags = mysqli_query($con, $sql_tags);
										   	
			while ($row_tags = mysqli_fetch_array($result_tags)) {
				
				$tagHTMLID = "L". $row_tags['tagName'];
				
				if ($_POST[$tagHTMLID]){
					$tagName = $_POST[$tagHTMLID];
					
					$sql = "INSERT INTO tagsDB (`tagName`, `tableName`, `entryID`)
					VALUES ('$tagName','$tableName','$entryID')";
					
					if ($con->query($sql) === TRUE) {
						//echo "tag added successfully!"."<br>";
					}
					else {
						$_SESSION['submitStatus'] = "error";
					}

				}
			}
			
		} 
		else {
			$_SESSION['submitStatus'] = "error";
			$_SESSION['tagName'] = "RE";
		}
	}
	
	if ( isset($_POST['workSubmit']) ) {
		
		
		$workTitle = test_input($_POST['workTitle']);

		$workLocation =  $_POST['workLocation'];
		
		$workURL = $_POST['workURL'];
		
	
		$workStartDateMonth = $_POST['WstartDateMonth'];
		$workStartDateYear = $_POST['WstartDateYear'];
		$workEndDateMonth = $_POST['WendDateMonth'];
		$workEndDateYear = $_POST['WendDateYear'];
		
		$workDescription = test_input2($_POST['Wjobdescription']);
		
		
		
		
		
		
		
		$target_dir = "files/";
		$msg = "?";
		$noImg = true;

		if ($_FILES['filesToUploadPDF']['tmp_name']){
		
			$noImg = false;

			$name = $_FILES['filesToUploadPDF']['name'];
			$size = $_FILES['filesToUploadPDF']['size'];
			$type = $_FILES['filesToUploadPDF']['type'];
			$file = $_FILES['filesToUploadPDF']['tmp_name'];
			
			$target_file = $target_dir . $_SERVER['REQUEST_TIME'] ."_" . basename($name);
			
			$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$uploadOk = 1;


			// Check if file already exists and rename if necessary
			if (file_exists($target_file)) {
				$renameIndex = 1;
				while (file_exists($target_file ."(".$renameIndex.")")){
					$renameIndex++;
				}
				$target_file = $target_file ."(".$renameIndex.")";
			}

			// Check file size is less than 10MB
			if ($size > 10000000) {
				$msg = $msg."&largeFile=1";
				$uploadOk = 0;
			}


			// Allow certain file formats
			if($fileType != "pdf" ) {
					$msg = $msg."&invalidType=1";
					$uploadOk = 0;
			}


			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			} else {

				if (move_uploaded_file($file, $target_file)) {
					$target_file_pdf = $target_file;
				}
				else {
					$uploadOk = 0;
				}
			}

		}		
		
		$sql = "INSERT INTO `workExperiences` (`workTitle`, `workURL`, `workLocation`, `startDataMonth`, `startDateYear`, `endDateMonth`, `endDateYear`, `workDescription`, `pdfDir`) VALUES ('$workTitle', '$workURL', '$workLocation', '$workStartDateMonth', '$workStartDateYear', '$workEndDateMonth', '$workEndDateYear', '$workDescription', '$target_file_pdf');";
		
		
		if ($con->query($sql) === TRUE) {
			//header("Location: individual_listing.php?listname=".$uniqueListingTitle);
			$_SESSION['submitStatus'] = "success";	
			$_SESSION['tagName'] = "WE";
			
			$sql_id = "SELECT MAX(workID) FROM `workExperiences`";
			$result_id = mysqli_query($con, $sql_id);
			$row_id = mysqli_fetch_array($result_id);
			
			$entryID = $row_id['MAX(workID)'];
			$tableName = 'workExperiences';			
						
			$sql_tags = "SELECT * FROM `tags` WHERE 1";
			$result_tags = mysqli_query($con, $sql_tags);
										   	
			while ($row_tags = mysqli_fetch_array($result_tags)) {
				
				$tagHTMLID = "W". $row_tags['tagName'];
				
				if ($_POST[$tagHTMLID]){
					$tagName = $_POST[$tagHTMLID];
					
					$sql = "INSERT INTO tagsDB (`tagName`, `tableName`, `entryID`)
					VALUES ('$tagName','$tableName','$entryID')";
					
					if ($con->query($sql) === TRUE) {
						//echo "tag added successfully!"."<br>";
					}
					else {
						$_SESSION['submitStatus'] = "error";
					}

				}
			}
			
		} 
		else {
			$_SESSION['submitStatus'] = "error";
			$_SESSION['tagName'] = "WE";
		}
	}
	
	
	if ( isset($_POST['projectSubmit']) ) {
		
		
		
		
		
		
		
		$projectTitle = test_input($_POST['projectTitle']);
		
		$courseTitle = test_input($_POST['courseTitle']);

		$projectLocation =  $_POST['projectLocation'];
		
		$repoURL = $_POST['repoURL'];
		
	
		$projectStartDateMonth = $_POST['PstartDateMonth'];
		$projectStartDateYear = $_POST['PstartDateYear'];
		$projectEndDateMonth = $_POST['PendDateMonth'];
		$projectEndDateYear = $_POST['PendDateYear'];
		
		$projectDescription = test_input2($_POST['Pjobdescription']);
		

		$target_dir = "files/";
		$msg = "?";
		$noImg = true;

		if ($_FILES['filesToUploadPDF']['tmp_name']){
		
			$noImg = false;

			$name = $_FILES['filesToUploadPDF']['name'];
			$size = $_FILES['filesToUploadPDF']['size'];
			$type = $_FILES['filesToUploadPDF']['type'];
			$file = $_FILES['filesToUploadPDF']['tmp_name'];
			
			$target_file = $target_dir . $_SERVER['REQUEST_TIME'] ."_" . basename($name);
			
			$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$uploadOk = 1;


			// Check if file already exists and rename if necessary
			if (file_exists($target_file)) {
				$renameIndex = 1;
				while (file_exists($target_file ."(".$renameIndex.")")){
					$renameIndex++;
				}
				$target_file = $target_file ."(".$renameIndex.")";
			}

			// Check file size is less than 10MB
			if ($size > 10000000) {
				$msg = $msg."&largeFile=1";
				$uploadOk = 0;
			}


			// Allow certain file formats
			if($fileType != "pdf" ) {
					$msg = $msg."&invalidType=1";
					$uploadOk = 0;
			}


			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			} else {

				if (move_uploaded_file($file, $target_file)) {
					$target_file_pdf = $target_file;
				}
				else {
					$uploadOk = 0;
				}
			}

		}
		
		$sql = "INSERT INTO `projects` (`projectTitle`, `courseTitle`, `repoURL`, `projectLocation`, `startDateMonth`, `startDateYear`, `endDateMonth`, `endDateYear`, `projectDescription`, `pdfDir`) VALUES ('$projectTitle', '$courseTitle', '$repoURL', '$projectLocation', '$projectStartDateMonth', '$projectStartDateYear', '$projectEndDateMonth', '$projectEndDateYear', '$projectDescription', '$target_file_pdf')";
		
			
		
		if ($con->query($sql) === TRUE) {
			//header("Location: individual_listing.php?listname=".$uniqueListingTitle);
			$_SESSION['submitStatus'] = "success";	
			$_SESSION['tagName'] = "PE";
			
			$sql_id = "SELECT MAX(projectID) FROM `projects`";
			$result_id = mysqli_query($con, $sql_id);
			$row_id = mysqli_fetch_array($result_id);
			
			$entryID = $row_id['MAX(projectID)'];
			$tableName = 'projects';			
						
			$sql_tags = "SELECT * FROM `tags` WHERE 1";
			$result_tags = mysqli_query($con, $sql_tags);
										   	
			while ($row_tags = mysqli_fetch_array($result_tags)) {
				
				$tagHTMLID = "P". $row_tags['tagName'];
				
				if ($_POST[$tagHTMLID]){
					$tagName = $_POST[$tagHTMLID];
					
					$sql = "INSERT INTO tagsDB (`tagName`, `tableName`, `entryID`)
					VALUES ('$tagName','$tableName','$entryID')";
					
					if ($con->query($sql) === TRUE) {
						//echo "tag added successfully!"."<br>";
					}
					else {
						$_SESSION['submitStatus'] = "error";
					}

				}
			}
			
		} 
		else {
			$_SESSION['submitStatus'] = "error";
			$_SESSION['tagName'] = "PE";
		}
	}
	
	
	if ( isset($_POST['imageSubmit']) ) {
		
		
		$imageCaption = test_input($_POST['imageCaption']);
		
		$imageLocation = test_input($_POST['imageLocation']);
		
		$target_dir = "files/";
		$msg = "?";
		$noImg = true;

		if ($_FILES['filesToUpload']['tmp_name']){
		
			$noImg = false;

			$name = $_FILES['filesToUpload']['name'];
			$size = $_FILES['filesToUpload']['size'];
			$type = $_FILES['filesToUpload']['type'];
			$file = $_FILES['filesToUpload']['tmp_name'];
			
			$target_file = $target_dir . $_SERVER['REQUEST_TIME'] ."_" . basename($name);
			
			$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$uploadOk = 1;


			// Check if file already exists and rename if necessary
			if (file_exists($target_file)) {
				$renameIndex = 1;
				while (file_exists($target_file ."(".$renameIndex.")")){
					$renameIndex++;
				}
				$target_file = $target_file ."(".$renameIndex.")";
			}

			// Check file size is less than 10MB
			if ($size > 10000000) {
				$msg = $msg."&largeFile=1";
				$uploadOk = 0;
			}


			// Allow certain file formats
			if( $fileType != "jpg" &&  $fileType != "png" &&  $fileType != "jpeg" &&  $fileType != "gif" ) {
						
					$msg = $msg."&invalidType=1";
					$uploadOk = 0;
			}


			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			} else {

				if (move_uploaded_file($file, $target_file)) {
					$imageURL = $target_file;
				}
				else {
					$uploadOk = 0;
				}
			}

		}
		
		
		$sql = "INSERT INTO `gallery` (`imageCaption`, `imageLocation`, `imageURL`, `imageIndex`) VALUES ('$imageCaption', '$imageLocation', '$imageURL', NULL);";
					
		
		if ($con->query($sql) === TRUE) {
			//header("Location: individual_listing.php?listname=".$uniqueListingTitle);
			$_SESSION['submitStatus'] = "success";	
			$_SESSION['tagName'] = "GALLERY";
		} 
		else {
			$_SESSION['submitStatus'] = "error";
			$_SESSION['tagName'] = "GALLERY";
		}
	}
	

	if ( isset($_POST['removeTagSubmit']) ){
		
		$_SESSION['submitStatus'] = "success1";
		$_SESSION['tagName'] = "TAGS";
		
		$sql_tags = "SELECT * FROM `tags` WHERE 1";
		$result_tags = mysqli_query($con, $sql_tags);
										   	
			while ($row_tags = mysqli_fetch_array($result_tags)) {
				if ($_POST[$row_tags['tagName']]){
					
					$tagName = $_POST[$row_tags['tagName']];
				
					$sql = "DELETE FROM `tags` WHERE `tagName`='$tagName'";
					
					if ($con->query($sql) === TRUE) {
						
						$sql_db = "DELETE FROM `tagsDB` WHERE `tagName`='$tagName'";
						
						if ($con->query($sql_db) === TRUE) {
							
						}
						else {
							$_SESSION['submitStatus'] = "error1";
						}

					}
					else {
						$_SESSION['submitStatus'] = "error1";
					}

				}
			}

	}
	
	if ( isset($_POST['addTagSubmit']) ){
		$tagName = test_input1($_POST['tagName']);
				
		$sql = "INSERT INTO tags (`tagName`)
				VALUES ('$tagName')";

		if ($con->query($sql) === TRUE) {
			$_SESSION['submitStatus'] = "success";	
			$_SESSION['tagName'] = "TAGS";
		} 
		else {
			$_SESSION['submitStatus'] = "error";
			$_SESSION['tagName'] = "TAGS";
			//echo "Error: " . $sql1 . "<br>" . $con->error;
		}	
	}
	
	
	if ( isset($_POST['addJobLocationSubmit']) ){
		
		$jobLocationName = test_input($_POST['jobLocationName']);
		$jobLocationTitle = test_input($_POST['jobLocationTitle']);

		$sql = "INSERT INTO `jobs`(`jobTitle`, `jobText`) VALUES ('$jobLocationName','$jobLocationTitle')";
		

		if ($con->query($sql) === TRUE) {
			$_SESSION['submitStatus'] = "success";	
			$_SESSION['tagName'] = "JOBLOCATIONS";
		} 
		else {
			$_SESSION['submitStatus'] = "error";
			$_SESSION['tagName'] = "JOBLOCATIONS";
			//echo "Error: " . $sql1 . "<br>" . $con->error;
		}	
	}
	
	
	if ( isset($_POST['removeJobLocation']) ){
		
		$_SESSION['submitStatus'] = "success1";
		$_SESSION['tagName'] = "JOBLOCATIONS";

		$sql_jobLocation = "SELECT * FROM `jobs` WHERE 1";
		$result_jobLocation = mysqli_query($con, $sql_jobLocation);
										   	
		while ($row_jobLocation = mysqli_fetch_array($result_jobLocation)) {
			if ($_POST[$row_jobLocation['id']]){

				$jobID = $_POST[$row_jobLocation['id']];
				
				$sql = "DELETE FROM `jobs` WHERE `id`='$jobID'";

				if ($con->query($sql) === TRUE) {
				}
				else {
					$_SESSION['submitStatus'] = "error1";
				}

			}
		}

	}
	

	if ( isset($_POST['removeTeachingExperience']) ){
		
		$_SESSION['submitStatus'] = "success1";
		$_SESSION['tagName'] = "TE";

		$sql_teachingExperiences = "SELECT * FROM `teachingExperiences` WHERE 1";
		$result_teachingExperiences = mysqli_query($con, $sql_teachingExperiences);
										   	
		while ($row_teachingExperiences = mysqli_fetch_array($result_teachingExperiences)) {
			if ($_POST[$row_teachingExperiences['id']]){

				$tagID = $_POST[$row_teachingExperiences['id']];
				
				$sql = "DELETE FROM `teachingExperiences` WHERE `id`='$tagID'";

				if ($con->query($sql) === TRUE) {
					
					$sql_db = "DELETE FROM `tagsDB` WHERE `entryID`='$tagID' AND `tableName`='teachingExperiences' ";
						
						if ($con->query($sql_db) === TRUE) {
							
						}
						else {
							$_SESSION['submitStatus'] = "error1";
						}
					

				}
				else {
					$_SESSION['submitStatus'] = "error1";
				}

			}
		}

	}
	
	
	if ( isset($_POST['removeResearchExperience']) ){
		
		$_SESSION['submitStatus'] = "success1";
		$_SESSION['tagName'] = "RE";

		$sql_ResearchExperience = "SELECT * FROM `researchExperiences` WHERE 1";
		$result_ResearchExperience = mysqli_query($con, $sql_ResearchExperience);
										   	
		while ($row_ResearchExperience = mysqli_fetch_array($result_ResearchExperience)) {
			
			
			$researchHTMLID = "L".$row_ResearchExperience['researchID'];
			
			if ($_POST[$researchHTMLID]){

				$tagID = $_POST[$researchHTMLID];

				$sql = "DELETE FROM `researchExperiences` WHERE `researchID`='$tagID'";

				if ($con->query($sql) === TRUE) {
					
					$sql_db = "DELETE FROM `tagsDB` WHERE `entryID`='$tagID' AND `tableName`='researchExperiences' ";
						
						if ($con->query($sql_db) === TRUE) {
							
						}
						else {
							$_SESSION['submitStatus'] = "error1";
						}
					

				}
				else {
					$_SESSION['submitStatus'] = "error1";
				}

			}
		}

	}
	
	
	if ( isset($_POST['removeWorkExperience']) ){
		
		$_SESSION['submitStatus'] = "success1";
		$_SESSION['tagName'] = "WE";

		$sql_WorkExperience = "SELECT * FROM `workExperiences` WHERE 1";
		$result_WorkExperience = mysqli_query($con, $sql_WorkExperience);
										   	
		while ($row_WorkExperience = mysqli_fetch_array($result_WorkExperience)) {
			
			
			$workHTMLID = "W".$row_WorkExperience['workID'];
			
			if ($_POST[$workHTMLID]){

				$tagID = $_POST[$workHTMLID];

				$sql = "DELETE FROM `workExperiences` WHERE `workID`='$tagID'";

				if ($con->query($sql) === TRUE) {
					
					$sql_db = "DELETE FROM `tagsDB` WHERE `entryID`='$tagID' AND `tableName`='workExperiences' ";
						
						if ($con->query($sql_db) === TRUE) {
							
						}
						else {
							$_SESSION['submitStatus'] = "error1";
						}
					

				}
				else {
					$_SESSION['submitStatus'] = "error1";
				}

			}
		}

	}
	
	if ( isset($_POST['removeProject']) ){
		
		$_SESSION['submitStatus'] = "success1";
		$_SESSION['tagName'] = "PE";

		$sql_project = "SELECT * FROM `projects` WHERE 1";
		$result_project = mysqli_query($con, $sql_project);
										   	
		while ($row_project = mysqli_fetch_array($result_project)) {
			
			
			$projectHTMLID = "P".$row_project['projectID'];
			
			if ($_POST[$projectHTMLID]){

				$tagID = $_POST[$projectHTMLID];

				$sql = "DELETE FROM `projects` WHERE `projectID`='$tagID'";

				if ($con->query($sql) === TRUE) {
					
					$sql_db = "DELETE FROM `tagsDB` WHERE `entryID`='$tagID' AND `tableName`='projects' ";
						
						if ($con->query($sql_db) === TRUE) {
							
						}
						else {
							$_SESSION['submitStatus'] = "error1";
						}
					

				}
				else {
					$_SESSION['submitStatus'] = "error1";
				}

			}
		}

	}
	
	if ( isset($_POST['removeImage']) ){
		
		$_SESSION['submitStatus'] = "success1";
		$_SESSION['tagName'] = "GALLERY";

		$sql_gallery = "SELECT * FROM `gallery` WHERE 1";
		$result_gallery = mysqli_query($con, $sql_gallery);
										   	
		while ($row_gallery = mysqli_fetch_array($result_gallery)) {
			
			
			$galleryHTMLID = "I".$row_gallery['imageIndex'];
			
			$tagID = $_POST[$galleryHTMLID];
				
			if ($tagID){

				$sql = "DELETE FROM `gallery` WHERE `imageIndex`='$tagID'";

				if ($con->query($sql) === TRUE) {

				}
				else {
					$_SESSION['submitStatus'] = "error1";
				}

			}
		}

	}
	

$tabVar = 'TE';

if ( isset($_GET['TE']) ){
	$tabVar = 'TE';
}
	
if ( isset($_GET['RE']) ){
	$tabVar = 'RE';
}
	
if ( isset($_GET['WE']) ){
	$tabVar = 'WE';
}	
	
if ( isset($_GET['PE']) ){
	$tabVar = 'PE';
}	
	
if ( isset($_GET['GALLERY']) ){
	$tabVar = 'GALLERY';
}	
	
if ( isset($_GET['JOBLOCATIONS']) ){
	$tabVar = 'JOBLOCATIONS';
}	

if ( isset($_GET['TAGS']) ){
	$tabVar = 'TAGS';
}

if (isset($_SESSION['tagName'])){
	$tabVar = $_SESSION['tagName'];
}


	
?>




<body>
	
	<header>
		
		<div class="container" style="padding-left: 0 ; padding-right: 0" id="myNavBar">
			<nav class="navbar navbar-inverse navbar-toggleable-lg">
				
						<button class="navbar-toggler navbar-toggler-right" type="button"
						data-toggle="collapse" data-target="#navBarMenu" aria-controls="navBarMenu"
						aria-expanded="false" aria-label="Toggle Navigation">
								<span class="toggle-menu-bar"></span>
								<span class="toggle-menu-bar"></span>
								<span class="toggle-menu-bar"></span>	
						</button>
						
						<a href="index.php" class="nav-item nav-link" style="padding-left: 0" id="navBarCollapse">HOME</a>

				<div class="collapse navbar-collapse text-uppercase" id="navBarMenu">
					<div class="navbar-nav">
						<a class="nav-item nav-link" id="navBarCollapse" href="job.php">work experiences</a>
						<a class="nav-item nav-link" id="navBarCollapse" href="research.php">research experiences</a>
						<a class="nav-item nav-link" id="navBarCollapse" href="teaching.php">teaching experiences</a>
						<a class="nav-item nav-link" id="navBarCollapse" href="project.php">projects</a>
						<a class="nav-item nav-link" id="navBarCollapse" href="gallery.php">gallery</a>
						
						<?
							if (isset($_SESSION['authorizedUser'])){
								echo '<a class="nav-item nav-link" id="navBarCollapse" href="siteManagement.php">Admin</a>';
							}
							else {
								echo '<a class="nav-item nav-link" id="navBarCollapse" href="contact.php">contact me</a>';
							}
						?>
					</div><!-- navbar-nav -->
				</div><!-- collapse navbar-collapse -->
			</nav><!-- nav -->
			
			
		</div>
	
	
	</header>
	


	<div class="container" id="bodyContainer">
		<div class="row reg_form" style="margin-left: 5px; margin-right: 5px">
			<div class="col">
				
					<div class="tab">
					  	  <button class="tablinks" onclick="openT(event, 'TE')" <?  if ($tabVar=='TE'){ echo 'id="defaultOpen"' ; } ?> >TEACHING EXPERIENCE</button>
						  <button class="tablinks" onclick="openT(event, 'RE')" <?  if ($tabVar=='RE'){ echo 'id="defaultOpen"' ; } ?> >RESEARCH EXPERIENCE</button>
						  <button class="tablinks" onclick="openT(event, 'WE')" <?  if ($tabVar=='WE'){ echo 'id="defaultOpen"' ; } ?> >WORK EXPERIENCE</button>
						  <button class="tablinks" onclick="openT(event, 'PE')" <?  if ($tabVar=='PE'){ echo 'id="defaultOpen"' ; } ?> >PROJECTS</button>
						  <button class="tablinks" onclick="openT(event, 'GALLERY')" <?  if ($tabVar=='GALLERY'){ echo 'id="defaultOpen"' ; } ?> >GALLERY</button>	
						  <button class="tablinks" onclick="openT(event, 'JOBLOCATIONS')" <?  if ($tabVar=='JOBLOCATIONS'){ echo 'id="defaultOpen"' ; } ?> >JOB LOCATIONS</button>
					  	  <button class="tablinks" onclick="openT(event, 'TAGS')" <?  if ($tabVar=='TAGS'){ echo 'id="defaultOpen"' ; } ?> >TAGS</button>
						  
						
						
						
						
					</div>
				
					<div id="TE" class="tabcontent">
						  <h3 style="text-align:center" class="tabTitle">TEACHING EXPERIENCE</h3>
						  <hr>
						  <br>
							<form id="editTeaching" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
								<div class="edit">
									
									<?
									
										if ($_SESSION['tagName']=='TE'){
											if ( ($_SESSION['submitStatus'] == "success") ) {
												echo '<center><label class="success text-success">The job title added successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error")) {
												echo '<center><label class="error text-danger">We could not add the job title!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									<label class="editLabel">Job Title</label>
									<input type="text" class="editInput" placeholder="Enter the job title" name="Tjobtitle" <? echo 'value="'.$fname.'" '?> required>
									
									
									<label class="editLabel">Job Location</label>
									<br>
									<select name="Tjoblocation" class="editSelect">
										<option value="University of California, Riverside, California, United States">University of California, Riverside</option>
										<option value="Sharif University of Technology, Tehran, Iran">Sharif University of Technology</option>
								 	</select>
									
									<br><br>
									
									
									<label class="editLabel">Start Date</label>
									<br>
									<select name="TstartDateMonth" class="editSelect">
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">Augest</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">Novermber</option>
										<option value="12">December</option>
								 	</select>
								
									<select name="TstartDateYear" class="editSelect">
										<option value="2010">2010</option>
										<option value="2011">2011</option>
										<option value="2012">2012</option>
										<option value="2013">2013</option>
										<option value="2014">2014</option>
										<option value="2015">2015</option>
										<option value="2016">2016</option>
										<option value="2017">2017</option>
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
										<option value="2021">2021</option>
										<option value="2022">2022</option>
								 	</select>
									
									<br><br>
									
									<label class="editLabel">End Date</label>
									<br>
									<select name="TendDateMonth" class="editSelect">
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">Augest</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">Novermber</option>
										<option value="12">December</option>
								 	</select>
								
									<select name="TendDateYear" class="editSelect">
										<option value="2010">2010</option>
										<option value="2011">2011</option>
										<option value="2012">2012</option>
										<option value="2013">2013</option>
										<option value="2014">2014</option>
										<option value="2015">2015</option>
										<option value="2016">2016</option>
										<option value="2017">2017</option>
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
										<option value="2021">2021</option>
										<option value="2022">2022</option>
								 	</select>
									
									<br><br>
									
									<label class="editLabel">Job Description</label>
									
									
									<br>
									
									
									<label for="drsvr_bold" class="customDrsvrEditor">
    										<i class="fa fa-bold fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="drsvr_bold" name="drsvr_bold"> 
									
									
									
									<label for="drsvr_italic" class="customDrsvrEditor">
    										<i class="fa fa-italic fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="drsvr_italic" name="drsvr_italic"> 
									
									
									<label for="drsvr_enter" class="customDrsvrEditor">
    										<i class="fa fa-arrow-circle-down fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="drsvr_enter" name="drsvr_enter"> 
									
									<label for="drsvr_tab" class="customDrsvrEditor">
    										<i class="fa fa-arrow-circle-right fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="drsvr_tab" name="drsvr_tab"> 
									
									<label for="drsvr_caret_right" class="customDrsvrEditor">
    										<i class="fa fa-caret-right fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="drsvr_caret_right" name="drsvr_caret_right"> 
									
									
									
									<textarea id="Tjobdescription" name="Tjobdescription" rows="4" class="editTextBox" placeholder="Enter the job description" required></textarea>
									
									
									
									
									<label class="editLabel">Select Tags</label>
									<br>
									
									<div class="control-group">
									
									
									<?
										
											$sql_tags = "SELECT * FROM `tags` WHERE 1";
										    $result_tags = mysqli_query($con, $sql_tags);
										   	
										   	while ($row_tags = mysqli_fetch_array($result_tags)) {
												echo '<label class="control control--checkbox">'.$row_tags['tagName'];
												echo '<input type="checkbox" name="'.$row_tags['tagName'].'" value="'.$row_tags['tagName'].'"/>';
												echo '<div class="control__indicator"></div>';
												echo '</label>';
											}

									?>
										
									</div>	
									
									<input type="submit" ID="submitbtn" name="teachingSubmit" value="Save Changes"/>
								</div>
							</form>
							<br>
							<form id="addTags" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
								<div class="edit">
									
										
									<?
									
									
										if ($_SESSION['tagName']=='TAGS'){
											if ( ($_SESSION['submitStatus'] == "success1") ) {
												echo '<center><label class="success text-success">The tag removed successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error1")) {
												echo '<center><label class="error text-danger">There was an error for removing tags!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									<label class="editLabel">Select Teaching Experiences to Remove</label>
									<br>
									
									<div class="control-group">
									
									
									<?
										
											$sql_te = "SELECT * FROM `teachingExperiences` WHERE 1";
										    $result_te = mysqli_query($con, $sql_te);
										   	
										   	while ($row_te = mysqli_fetch_array($result_te)) {
												
												$jobTitle = $row_te['Title'];
												$jobLocation = $row_te['University'];
												$jobStartDateMonth = $row_te['startMonth'];
												$jobStartDateYear = $row_te['startYear'];
												$jobEndDateMonth = $row_te['endMonth'];
												$jobEndDateYear = $row_te['endYear'];
												$jobDescription = $row_te['Description'];
												$jobID = $row_te['id'];
												
												
												$label = "[".$jobID."]-[".$jobTitle."]-[".$jobLocation."]-[".$jobStartDateMonth."]-[".$jobStartDateYear."]-[".$jobEndDateMonth."]-[".$jobEndDateYear."]";																						
												
												echo '<label class="control control--checkbox">'.$label;
												echo '<input type="checkbox" name="'.$jobID.'" value="'.$jobID.'"/>';
												echo '<div class="control__indicator"></div>';
												echo '</label>';
											}

									?>
										
									</div>	
									
									<input type="submit" ID="submitbtn" class="mediumButton" name="removeTeachingExperience" value="Remove a Teaching Experience"/>
								</div>
							</form>

					</div>
				
					<div id="RE" class="tabcontent">
						  <h3 style="text-align:center" class="tabTitle">RESEARCH EXPERIENCE</h3>
						  <hr>
						  <br>
							<form id="editTeaching" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
								<div class="edit">
									
									<?
									
										if ($_SESSION['tagName']=='RE'){
											if ( ($_SESSION['submitStatus'] == "success") ) {
												echo '<center><label class="success text-success">The job title added successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error")) {
												echo '<center><label class="error text-danger">We could not add the job title!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									<label class="editLabel">Research Title</label>
									<input type="text" class="editInput" placeholder="Enter the research title" name="Lresearchtitle" <? echo 'value="'.$fname.'" '?> required>
									
									
									<label class="editLabel">Lab Title</label>
									<input type="text" class="editInput" placeholder="Enter the the lab title" name="Llabtitle" <? echo 'value="'.$fname.'" '?> required>
									
									
									<label class="editLabel">Lab URL</label>
									<input type="text" class="editInput" placeholder="Enter the the lab title" name="Llaburl" <? echo 'value="'.$fname.'" '?> required>
									
									<label class="editLabel">Advisor</label>
									<input type="text" class="editInput" placeholder="Enter the the lab title" name="Ladvisor" <? echo 'value="'.$fname.'" '?> required>
									
									<label class="editLabel">Advisor URL</label>
									<input type="text" class="editInput" placeholder="Enter the the lab title" name="Ladvisorurl" <? echo 'value="'.$fname.'" '?> required>
								
									<label class="editLabel">Lab Location</label>
									<br>
									<select name="Llablocation" class="editSelect">
										
										<?
											$sql_jobLocation = "SELECT * FROM `jobs` WHERE 1";
										    $result_jobLocation = mysqli_query($con, $sql_jobLocation);
										   	
										   	while ($row_jobLocation = mysqli_fetch_array($result_jobLocation)) {
												
												$jobTitle = $row_jobLocation['jobTitle'];
												$jobText = $row_jobLocation['jobText'];
												
												echo '<option value="'.$jobText.'">'.$jobTitle."</option>";
											}
										
										
										?>
										
										
									</select>	
									
									<br><br>
									
									
									<label class="editLabel">Start Date</label>
									<br>
									<select name="LstartDateMonth" class="editSelect">
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">Augest</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">Novermber</option>
										<option value="12">December</option>
								 	</select>
								
									<select name="LstartDateYear" class="editSelect">
										<option value="2010">2010</option>
										<option value="2011">2011</option>
										<option value="2012">2012</option>
										<option value="2013">2013</option>
										<option value="2014">2014</option>
										<option value="2015">2015</option>
										<option value="2016">2016</option>
										<option value="2017">2017</option>
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
										<option value="2021">2021</option>
										<option value="2022">2022</option>
								 	</select>
									
									<br><br>
									
									<label class="editLabel">End Date</label>
									<br>
									<select name="LendDateMonth" class="editSelect">
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">Augest</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">Novermber</option>
										<option value="12">December</option>
								 	</select>
								
									<select name="LendDateYear" class="editSelect">
										<option value="2010">2010</option>
										<option value="2011">2011</option>
										<option value="2012">2012</option>
										<option value="2013">2013</option>
										<option value="2014">2014</option>
										<option value="2015">2015</option>
										<option value="2016">2016</option>
										<option value="2017">2017</option>
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
										<option value="2021">2021</option>
										<option value="2022">2022</option>
								 	</select>
									
									<br><br>
									
									<label class="editLabel">Research Description</label>
									
									
									<br>
									
									
									<label for="Ldrsvr_bold" class="customDrsvrEditor">
    										<i class="fa fa-bold fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Ldrsvr_bold" name="Ldrsvr_bold"> 
									
									
									
									<label for="Ldrsvr_italic" class="customDrsvrEditor">
    										<i class="fa fa-italic fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Ldrsvr_italic" name="Ldrsvr_italic"> 
									
									
									<label for="Ldrsvr_enter" class="customDrsvrEditor">
    										<i class="fa fa-arrow-circle-down fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Ldrsvr_enter" name="Ldrsvr_enter"> 
									
									<label for="Ldrsvr_tab" class="customDrsvrEditor">
    										<i class="fa fa-arrow-circle-right fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Ldrsvr_tab" name="Ldrsvr_tab"> 
									
									<label for="Ldrsvr_caret_right" class="customDrsvrEditor">
    										<i class="fa fa-caret-right fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Ldrsvr_caret_right" name="Ldrsvr_caret_right"> 
									
									
									
									<textarea id="Ljobdescription" name="Ljobdescription" rows="4" class="editTextBox" placeholder="Enter the job description" required></textarea>
									
									
									<center><div class="file">
				  					<label for="file-input">Choose a PDF File</label>
				 							 <input name="filesToUploadPDF" id="filesToUploadPDF" type="file"/>
									</div></center>
									
									
									<center><div class="file">
				  					<label for="file-input">Choose a PPT File</label>
				 							 <input name="filesToUploadPPT" id="filesToUploadPPT" type="file"/>
									</div></center>
									
									
									
									
									<label class="editLabel">Select Tags</label>
									<br>
									
									<div class="control-group">
									
									
									<?
										
											$sql_tags = "SELECT * FROM `tags` WHERE 1";
										    $result_tags = mysqli_query($con, $sql_tags);
										   	
										   	while ($row_tags = mysqli_fetch_array($result_tags)) {
												echo '<label class="control control--checkbox">'.$row_tags['tagName'];
												echo '<input type="checkbox" name="L'.$row_tags['tagName'].'" value="'.$row_tags['tagName'].'"/>';
												echo '<div class="control__indicator"></div>';
												echo '</label>';
											}

									?>
										
									</div>	
									
									<input type="submit" ID="submitbtn" name="researchSubmit" value="Add a research experience"/>
								</div>
							</form>
							<br>
							<form id="addTags" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
								<div class="edit">
									
										
									<?
									
										if ($_SESSION['tagName']=='RE'){
											if ( ($_SESSION['submitStatus'] == "success1") ) {
												echo '<center><label class="success text-success">Research experiences removed successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error1")) {
												echo '<center><label class="error text-danger">There was an error for removing research experiences!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									<label class="editLabel">Select Research Experiences to Remove</label>
									<br>
									
									<div class="control-group">
									
									
									<?
										
											$sql_re = "SELECT * FROM `researchExperiences` WHERE 1";
										    $result_re = mysqli_query($con, $sql_re);
										   	
										   	while ($row_re = mysqli_fetch_array($result_re)) {
												
												$researchTitle = $row_re['researchTitle'];
												$labTitle = $row_re['labTitle'];
												$labLocation = $row_re['labLocation'];
												$laburl = $row_re['labURL'];
												$labAdvisor = $row_re['labAdvisor']; 
												$labAdvisorURL = $row_re['labAdvisorURL'];
												$labStartDateMonth = $row_re['startDateMonth'];
												$labStartDateYear = $row_re['startDateYear'];
												$labEndDateMonth = $row_re['endDateMonth'];
												$labEndDateYear = $row_re['endDateYear'];  
												$labDescription = $row_re['labDescription']; 
												$researchID = $row_re['researchID']; 
													
												$label = "[".$researchID."]-[".$researchTitle."]-[".$labTitle."]-[".$labLocation."]-[".$laburl."]-[".$labAdvisor."]-[".$labAdvisorURL."]-[".$labStartDateMonth."]-[".$labStartDateYear."]-[".$labEndDateMonth ."]-[".$labEndDateYear."]";
												
												
												echo '<label class="control control--checkbox">'.$label;
												echo '<input type="checkbox" name="L'.$researchID.'" value="'.$researchID.'"/>';
												echo '<div class="control__indicator"></div>';
												echo '</label>';
											}

									?>
										
									</div>	
									
									<input type="submit" ID="submitbtn" class="mediumButton" name="removeResearchExperience" value="remove A Research Experience"/>
								</div>
							</form>

					</div>
					
				
					<div id="WE" class="tabcontent">
						  <h3 style="text-align:center" class="tabTitle">WORK EXPERIENCE</h3>
						  <hr>
						  <br>
							<form id="editTeaching" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
								<div class="edit">
									
									<?
									
										if ($_SESSION['tagName']=='WE'){
											if ( ($_SESSION['submitStatus'] == "success") ) {
												echo '<center><label class="success text-success">The work title added successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error")) {
												echo '<center><label class="error text-danger">We could not add the work title!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									<label class="editLabel">WORK Title</label>
									<input type="text" class="editInput" placeholder="Enter the work title" name="workTitle" <? echo 'value="'.$fname.'" '?> required>
																	
									
									<label class="editLabel">WORK URL</label>
									<input type="text" class="editInput" placeholder="Enter the website URL of your work place" name="workURL" <? echo 'value="'.$fname.'" '?> required>
									
							
									<label class="editLabel">WORK Location</label>
									<br>
									<select name="workLocation" class="editSelect">
										
										<?
											$sql_jobLocation = "SELECT * FROM `jobs` WHERE 1";
										    $result_jobLocation = mysqli_query($con, $sql_jobLocation);
										   	
										   	while ($row_jobLocation = mysqli_fetch_array($result_jobLocation)) {
												
												$jobTitle = $row_jobLocation['jobTitle'];
												$jobText = $row_jobLocation['jobText'];
												
												echo '<option value="'.$jobText.'">'.$jobTitle."</option>";
											}
										
										
										?>
										
										
									</select>	
									
									<br><br>
									
									
									<label class="editLabel">Start Date</label>
									<br>
									<select name="WstartDateMonth" class="editSelect">
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">Augest</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">Novermber</option>
										<option value="12">December</option>
								 	</select>
								
									<select name="WstartDateYear" class="editSelect">
										<option value="2010">2010</option>
										<option value="2011">2011</option>
										<option value="2012">2012</option>
										<option value="2013">2013</option>
										<option value="2014">2014</option>
										<option value="2015">2015</option>
										<option value="2016">2016</option>
										<option value="2017">2017</option>
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
										<option value="2021">2021</option>
										<option value="2022">2022</option>
								 	</select>
									
									<br><br>
									
									<label class="editLabel">End Date</label>
									<br>
									<select name="WendDateMonth" class="editSelect">
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">Augest</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">Novermber</option>
										<option value="12">December</option>
								 	</select>
								
									<select name="WendDateYear" class="editSelect">
										<option value="2010">2010</option>
										<option value="2011">2011</option>
										<option value="2012">2012</option>
										<option value="2013">2013</option>
										<option value="2014">2014</option>
										<option value="2015">2015</option>
										<option value="2016">2016</option>
										<option value="2017">2017</option>
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
										<option value="2021">2021</option>
										<option value="2022">2022</option>
								 	</select>
									
									<br><br>
									
									<label class="editLabel">Work Description</label>
									
									
									<br>
									
									
									<label for="Wdrsvr_bold" class="customDrsvrEditor">
    										<i class="fa fa-bold fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Wdrsvr_bold" name="Wdrsvr_bold"> 
									
									
									
									<label for="Wdrsvr_italic" class="customDrsvrEditor">
    										<i class="fa fa-italic fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Wdrsvr_italic" name="Wdrsvr_italic"> 
									
									
									<label for="Wdrsvr_enter" class="customDrsvrEditor">
    										<i class="fa fa-arrow-circle-down fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Wdrsvr_enter" name="Wdrsvr_enter"> 
									
									<label for="Wdrsvr_tab" class="customDrsvrEditor">
    										<i class="fa fa-arrow-circle-right fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Wdrsvr_tab" name="Wdrsvr_tab"> 
									
									<label for="Wdrsvr_caret_right" class="customDrsvrEditor">
    										<i class="fa fa-caret-right fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Wdrsvr_caret_right" name="Wdrsvr_caret_right"> 
									
									
									
									<textarea id="Wjobdescription" name="Wjobdescription" rows="4" class="editTextBox" placeholder="Enter the job description" required></textarea>
									
									
									<center><div class="file">
				  					<label for="file-input">Choose a PDF File</label>
				 							 <input name="filesToUploadPDF" id="filesToUploadPDF" type="file"/>
									</div></center>
									
																	
									<label class="editLabel">Select Tags</label>
									<br>
									
									<div class="control-group">
									
									
									<?
										
											$sql_tags = "SELECT * FROM `tags` WHERE 1";
										    $result_tags = mysqli_query($con, $sql_tags);
										   	
										   	while ($row_tags = mysqli_fetch_array($result_tags)) {
												echo '<label class="control control--checkbox">'.$row_tags['tagName'];
												echo '<input type="checkbox" name="W'.$row_tags['tagName'].'" value="'.$row_tags['tagName'].'"/>';
												echo '<div class="control__indicator"></div>';
												echo '</label>';
											}

									?>
										
									</div>	
									
									<input type="submit" ID="submitbtn" name="workSubmit" value="Add a work experience"/>
								</div>
							</form>
							<br>
							<form id="addWorks" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
								<div class="edit">
									
										
									<?
									
										if ($_SESSION['tagName']=='WE'){
											if ( ($_SESSION['submitStatus'] == "success1") ) {
												echo '<center><label class="success text-success">Research experiences removed successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error1")) {
												echo '<center><label class="error text-danger">There was an error for removing research experiences!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									<label class="editLabel">Select Work Experiences to Remove</label>
									<br>
									
									<div class="control-group">
									
									
									<?
										
											$sql_we = "SELECT * FROM `workExperiences` WHERE 1";
										    $result_we = mysqli_query($con, $sql_we);
										   	
										   	while ($row_we = mysqli_fetch_array($result_we)) {
												
												$workTitle = $row_we['workTitle'];
												$workURL = $row_we['workURL'];
												$workLocation = $row_we['workLocation'];
													
		
												$workStartDateMonth = $row_we['startDataMonth']; 
												$workStartDateYear = $row_we['startDateYear']; 
												$workEndDateMonth = $row_we['endDateMonth'];
												$workEndDateYear = $row_we['endDateYear']; 
												
												$workDescription = $row_we['workDescription'];
												$workID = $row_we['workID'];
												
												
												$workPDF = $row_we['pdfDir'];
												
													
												$label = "[".$workID."]-[".$workTitle."]-[".$workURL."]-[".$workLocation."]-[".$workStartDateMonth."]-[".$workStartDateYear."]-[".$workEndDateMonth."]-[".$workEndDateYear."]";
												
												
												echo '<label class="control control--checkbox">'.$label;
												echo '<input type="checkbox" name="W'.$workID.'" value="'.$workID.'"/>';
												echo '<div class="control__indicator"></div>';
												echo '</label>';
											}

									?>
										
									</div>	
									
									<input type="submit" ID="submitbtn" class="mediumButton" name="removeWorkExperience" value="remove A work Experience"/>
								</div>
							</form>

					</div>
					
					<div id="PE" class="tabcontent">
						  <h3 style="text-align:center" class="tabTitle">Projects</h3>
						  <hr>
						  <br>
							<form id="editTeaching" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
								<div class="edit">
									
									<?
									
										if ($_SESSION['tagName']=='PE'){
											if ( ($_SESSION['submitStatus'] == "success") ) {
												echo '<center><label class="success text-success">The project added successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error")) {
												echo '<center><label class="error text-danger">We could not add the project!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									<label class="editLabel">Project Title</label>
									<input type="text" class="editInput" placeholder="Enter the project title" name="projectTitle" <? echo 'value="'.$fname.'" '?> required>
									
									<label class="editLabel">Course Title</label>
									<input type="text" class="editInput" placeholder="Enter the project title" name="courseTitle" <? echo 'value="'.$fname.'" '?> required>
																	
									
									<label class="editLabel">Repo URL</label>
									<input type="text" class="editInput" placeholder="Enter the URL of the repo associated with the project" name="repoURL" <? echo 'value="'.$fname.'" '?> >
									
							
									<label class="editLabel">Project Location</label>
									<br>
									<select name="projectLocation" class="editSelect">
										
										<?
											$sql_jobLocation = "SELECT * FROM `jobs` WHERE 1";
										    $result_jobLocation = mysqli_query($con, $sql_jobLocation);
										   	
										   	while ($row_jobLocation = mysqli_fetch_array($result_jobLocation)) {
												
												$jobTitle = $row_jobLocation['jobTitle'];
												$jobText = $row_jobLocation['jobText'];
												
												echo '<option value="'.$jobText.'">'.$jobTitle."</option>";
											}
										
										
										?>
										
										
									</select>	
									
									<br><br>
									
									
									<label class="editLabel">Start Date</label>
									<br>
									<select name="PstartDateMonth" class="editSelect">
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">Augest</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">Novermber</option>
										<option value="12">December</option>
								 	</select>
								
									<select name="PstartDateYear" class="editSelect">
										<option value="2010">2010</option>
										<option value="2011">2011</option>
										<option value="2012">2012</option>
										<option value="2013">2013</option>
										<option value="2014">2014</option>
										<option value="2015">2015</option>
										<option value="2016">2016</option>
										<option value="2017">2017</option>
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
										<option value="2021">2021</option>
										<option value="2022">2022</option>
								 	</select>
									
									<br><br>
									
									<label class="editLabel">End Date</label>
									<br>
									<select name="PendDateMonth" class="editSelect">
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">Augest</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">Novermber</option>
										<option value="12">December</option>
								 	</select>
								
									<select name="PendDateYear" class="editSelect">
										<option value="2010">2010</option>
										<option value="2011">2011</option>
										<option value="2012">2012</option>
										<option value="2013">2013</option>
										<option value="2014">2014</option>
										<option value="2015">2015</option>
										<option value="2016">2016</option>
										<option value="2017">2017</option>
										<option value="2018">2018</option>
										<option value="2019">2019</option>
										<option value="2020">2020</option>
										<option value="2021">2021</option>
										<option value="2022">2022</option>
								 	</select>
									
									<br><br>
									
									<label class="editLabel">Project Description</label>
									
									
									<br>
									
									
									<label for="Pdrsvr_bold" class="customDrsvrEditor">
    										<i class="fa fa-bold fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Pdrsvr_bold" name="Pdrsvr_bold"> 
									
									
									
									<label for="Pdrsvr_italic" class="customDrsvrEditor">
    										<i class="fa fa-italic fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Pdrsvr_italic" name="Pdrsvr_italic"> 
									
									
									<label for="Pdrsvr_enter" class="customDrsvrEditor">
    										<i class="fa fa-arrow-circle-down fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Pdrsvr_enter" name="Pdrsvr_enter"> 
									
									<label for="Pdrsvr_tab" class="customDrsvrEditor">
    										<i class="fa fa-arrow-circle-right fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Pdrsvr_tab" name="Pdrsvr_tab"> 
									
									<label for="Pdrsvr_caret_right" class="customDrsvrEditor">
    										<i class="fa fa-caret-right fa-lg"></i>
									</label>
									
									<input class="drsvrEditor" type="button" id="Pdrsvr_caret_right" name="Pdrsvr_caret_right"> 
									
									
									
									<textarea id="Pjobdescription" name="Pjobdescription" rows="4" class="editTextBox" placeholder="Enter the project description" required></textarea>
									
									
									<center><div class="file">
				  					<label for="file-input">Choose a PDF File</label>
				 							 <input name="filesToUploadPDF" id="filesToUploadPDF" type="file"/>
									</div></center>
									
																	
									<label class="editLabel">Select Tags</label>
									<br>
									
									<div class="control-group">
									
									
									<?
										
											$sql_tags = "SELECT * FROM `tags` WHERE 1";
										    $result_tags = mysqli_query($con, $sql_tags);
										   	
										   	while ($row_tags = mysqli_fetch_array($result_tags)) {
												echo '<label class="control control--checkbox">'.$row_tags['tagName'];
												echo '<input type="checkbox" name="P'.$row_tags['tagName'].'" value="'.$row_tags['tagName'].'"/>';
												echo '<div class="control__indicator"></div>';
												echo '</label>';
											}

									?>
										
									</div>	
									
									<input type="submit" ID="submitbtn" name="projectSubmit" value="Add a project"/>
								</div>
							</form>
							<br>
							<form id="addProject" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
								<div class="edit">
									
										
									<?
									
										if ($_SESSION['tagName']=='PE'){
											if ( ($_SESSION['submitStatus'] == "success1") ) {
												echo '<center><label class="success text-success">Project removed successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error1")) {
												echo '<center><label class="error text-danger">There was an error for removing project experiences!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									<label class="editLabel">Select Projects to Remove</label>
									<br>
									
									<div class="control-group">
									
									
									<?
										
										
										
											$sql_pe = "SELECT * FROM `projects` WHERE 1";
										    $result_pe = mysqli_query($con, $sql_pe);
										   	
										   	while ($row_pe = mysqli_fetch_array($result_pe)) {
												
												
												$projectTitle = $row_pe['projectTitle'];
												$courseTitle = $row_pe['courseTitle'];
												$repoURL = $row_pe['repoURL'];
												
												
												$projectLocation = $row_pe['projectLocation'];
												
												$projectStartDateMonth = $row_pe['startDateMonth'];
												$projectStartDateYear = $row_pe['startDateYear'];	
												$projectEndDateMonth = $row_pe['endDateMonth'];
												$projectEndDateYear = $row_pe['endDateYear'];  
												
												$projectDescription = $row_pe['projectDescription'];
													
												$projectPDF = $row_pe['pdfDir'];
													
												$projectID = $row_pe['projectID']; 	
													
												
													
												$label = "[".$projectID."]-[".$projectTitle."]-[".$courseTitle."]-[".$repoURL."]-[".$projectLocation."]-[".$projectStartDateMonth."]-[".$projectStartDateYear."]-[".$projectEndDateMonth."]-[".$projectEndDateYear."]";
												
												
												echo '<label class="control control--checkbox">'.$label;
												echo '<input type="checkbox" name="P'.$projectID.'" value="'.$projectID.'"/>';
												echo '<div class="control__indicator"></div>';
												echo '</label>';
											}

									?>
										
									</div>	
									
									<input type="submit" ID="submitbtn" class="mediumButton" name="removeProject" value="remove A Project"/>
								</div>
							</form>

					</div>
				

					<div id="GALLERY" class="tabcontent">
						  <h3 style="text-align:center" class="tabTitle">GALLERY</h3>
						  <hr>
						  <br>
							<form id="editTeaching" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
								<div class="edit">
									
									<?
									
										if ($_SESSION['tagName']=='GALLERY'){
											if ( ($_SESSION['submitStatus'] == "success") ) {
												echo '<center><label class="success text-success">The image uploaded successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error")) {
												echo '<center><label class="error text-danger">We could not add the image!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									<label class="editLabel">Image Caption</label>
									<input type="text" class="editInput" placeholder="Enter the image caption" name="imageCaption" <? echo 'value="'.$fname.'" '?> required>
									
									<label class="editLabel">Image Location</label>
									<input type="text" class="editInput" placeholder="Enter the image location" name="imageLocation" <? echo 'value="'.$fname.'" '?> required>
	
									

									
									<br><br>
								
									
									<center><div class="file">
				  					<label for="file-input">Choose an Image File</label>
				 							 <input name="filesToUpload" id="filesToUpload" type="file" required/>
									</div></center>
									
																	
									<input type="submit" ID="submitbtn" name="imageSubmit" value="Upload an Image"/>
								</div>
							</form>
							<br>
							<form id="addImages" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
								<div class="edit">
									
										
									<?
									
										if ($_SESSION['tagName']=='GALLERY'){
											if ( ($_SESSION['submitStatus'] == "success1") ) {
												echo '<center><label class="success text-success">Images removed successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error1")) {
												echo '<center><label class="error text-danger">There was an error for removing images!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									<label class="editLabel">Select Images to Remove</label>
									<br>
									
									<div class="control-group">
									
									
									<?
										
										
										
											$sql_images = "SELECT * FROM `gallery` WHERE 1";
										    $result_images = mysqli_query($con, $sql_images);
										   	
										   	while ($row_images = mysqli_fetch_array($result_images)) {
												
												
												$imageCaption = $row_images['imageCaption'];
												$imageLocation = $row_images['imageLocation'];
												$imageURL = $row_images['imageURL'];
												$imageIndex = $row_images['imageIndex'];

												$label = "[".$imageIndex."]-[".$imageCaption."]-[".$imageLocation."]-[".$imageURL."]";
												
												
												echo '<label class="control control--checkbox">'.$label;
												echo '<input type="checkbox" name="I'.$imageIndex.'" value="'.$imageIndex.'"/>';
												echo '<div class="control__indicator"></div>';
												echo '</label>';
											}

									?>
										
									</div>	
									
									<input type="submit" ID="submitbtn" class="mediumButton" name="removeImage" value="remove Images"/>
								</div>
							</form>

					</div>
					

					<div id="TAGS" class="tabcontent">
						  <h3 style="text-align:center" class="tabTitle">EDIT TAGS</h3>
						  <hr>
						  <br>
						  <form id="addTags" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
								<div class="edit">
									
										
									<?
									
										if ($_SESSION['tagName']=='TAGS'){
											if ( ($_SESSION['submitStatus'] == "success") ) {
												echo '<center><label class="success text-success">The tag added successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error")) {
												echo '<center><label class="error text-danger">The tag is already in the database!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									
									<label class="editLabel">Tag name</label>
									<input type="text" class="editInput" placeholder="Enter the name for tag" name="tagName" <? echo 'value="'.$fname.'" '?> required>

										<? echo $info ?>
									</textarea>
									<input type="submit" ID="submitbtn" class="mediumButton" name="addTagSubmit" value="Add a Tag"/>
								
								</div>
						 </form>
						 <br>
						 <form id="addTags" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
								<div class="edit">
									
										
									<?
									
										if ($_SESSION['tagName']=='TAGS'){
											if ( ($_SESSION['submitStatus'] == "success1") ) {
												echo '<center><label class="success text-success">The tag removed successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error1")) {
												echo '<center><label class="error text-danger">There was an error for removing tags!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									<label class="editLabel">Select Tags to Remove</label>
									<br>
									
									<div class="control-group">
									
									
									<?
										
											$sql_tags = "SELECT * FROM `tags` WHERE 1";
										    $result_tags = mysqli_query($con, $sql_tags);
										   	
										   	while ($row_tags = mysqli_fetch_array($result_tags)) {
												echo '<label class="control control--checkbox">'.$row_tags['tagName'];
												echo '<input type="checkbox" name="'.$row_tags['tagName'].'" value="'.$row_tags['tagName'].'"/>';
												echo '<div class="control__indicator"></div>';
												echo '</label>';
											}

									?>
										
									</div>	
									
									<input type="submit" ID="submitbtn" class="mediumButton" name="removeTagSubmit" value="Remove a Tag"/>
								</div>
							</form>

					</div>
			
					<div id="JOBLOCATIONS" class="tabcontent">
						  <h3 style="text-align:center" class="tabTitle">EDIT JOB LOCATIONS</h3>
						  <hr>
						  <br>
						  <form id="addTags" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
								<div class="edit">
									
										
									<?
									
										if ($_SESSION['tagName']=='JOBLOCATIONS'){
											if ( ($_SESSION['submitStatus'] == "success") ) {
												echo '<center><label class="success text-success">The job location added successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error")) {
												echo '<center><label class="error text-danger">The job location is already in the database!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									
									<label class="editLabel">Job Location Name</label>
									<input type="text" class="editInput" placeholder="Enter the name for the job location" name="jobLocationName" <? echo 'value="'.$fname.'" '?> required>
									
									
									<label class="editLabel">Job Location Title</label>
									<input type="text" class="editInput" placeholder="Enter the title for the job location" name="jobLocationTitle" <? echo 'value="'.$fname.'" '?> required>
									
									
									<input type="submit" ID="submitbtn" class="mediumButton" name="addJobLocationSubmit" value="Add a job location"/>
								
								</div>
						 </form>
						 <br>
						 <form id="addTags" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
								<div class="edit">
									
										
									<?
									
										if ($_SESSION['tagName']=='JOBLOCATIONS'){
											if ( ($_SESSION['submitStatus'] == "success1") ) {
												echo '<center><label class="success text-success">The job location removed successfully!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}
											else if (($_SESSION['submitStatus'] == "error1")) {
												echo '<center><label class="error text-danger">There was an error for removing job locations!</label></center><br>';
												unset($_SESSION['tagName']);
												unset($_SESSION['submitStatus']);
											}	
										}
										
									
									?>
									
									<label class="editLabel">Select Job Locations to Remove</label>
									<br>
									
									<div class="control-group">
									
									
									<?
										
											
											$sql_jobLocation = "SELECT * FROM `jobs` WHERE 1";
										    $result_jobLocation = mysqli_query($con, $sql_jobLocation);
										   	
										   	while ($row_jobLocation = mysqli_fetch_array($result_jobLocation)) {
												
												$jobID = $row_jobLocation['id'];
												$jobName = $row_jobLocation['jobTitle'];
												$jobText = $row_jobLocation['jobText'];
												
												$label = "[".$jobName."]-[".$jobText."]";
												
												
												echo '<label class="control control--checkbox">'.$label;
												echo '<input type="checkbox" name="'.$jobID.'" value="'.$jobID.'"/>';
												echo '<div class="control__indicator"></div>';
												echo '</label>';
											}

									?>
										
									</div>	
									
									<input type="submit" ID="submitbtn" class="mediumButton" name="removeJobLocation" value="Remove a Tag"/>
								</div>
							</form>

					</div>
			
			
			</div>
		</div>
	</div>
	
	
		<footer>
			<div class="container" id="myFooter">
					<div class="row">
						<div class="col-md-6 col-lg-6 col-xl-7">
							<a href="http://www.shahriyar.us" class="nav-item nav-link float-left" target="_blank">
								<span id="navBarCollapse">Designed by Shahriyar ValielahiRoshan</span>
							</a>
						</div>
						<div class="col">
							<a href="https://www.linkedin.com/in/shahriyar-valielahiroshan-0645823a/" class="nav-item nav-link nav-justified" target="_blank">
								<span class="fa fa-linkedin" id="navBarCollapse"></span>
							</a>
						</div>
						<div class="col">
							<a href="https://bitbucket.org/svali003/" class="nav-item nav-link" target="_blank">
								<span class="fa fa-bitbucket" id="navBarCollapse"></span>
							</a>
						</div>
						<div class="col">
							<a href="https://www.instagram.com/shvroshan/" class="nav-item nav-link" target="_blank">
								<span class="fa fa-instagram" id="navBarCollapse"></span>
							</a>
						</div>
						<div class="col">
							<a href="https://www.facebook.com/DRSVR1991" class="nav-item nav-link" target="_blank">
								<span class="fa fa-facebook" id="navBarCollapse"></span>
							</a>
						</div>
						
						<?
							if (isset($_SESSION['authorizedUser'])){
								echo '<div class="col">';
								echo '<a href="?logout=1" class="nav-item nav-link" target="_self">';
								echo '<span class="fa fa-sign-out" id="navBarCollapse"></span>';
								echo '</a></div>';
							}
							else {
								echo '<div class="col">';
								echo '<a href="login.php" class="nav-item nav-link" target="_self">';
								echo '<span class="fa fa-sign-in" id="navBarCollapse"></span>';
								echo '</a></div>';
							}
						
						?>
					</div>
			</div>
		</footer>
	
</body>
	
<script>
function openT(evt, tname) {
	var i, tabcontent, tablinks;
	tabcontent = document.getElementsByClassName("tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}
	document.getElementById(tname).style.display = "block";
	evt.currentTarget.className += " active";
}

document.getElementById("defaultOpen").click();
</script>

<script>

	$( '#drsvr_bold' ).on('click', function(){
				var cursorPos = $('#Tjobdescription').prop('selectionStart');
				var tag_begin = "<b>";
				var tag_End = "</b>";
				var v = $('#Tjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Tjobdescription').val( textBefore+ tag_begin +textAfter + tag_End );
	});
	
	
	$( '#drsvr_italic' ).on('click', function(){
				var cursorPos = $('#Tjobdescription').prop('selectionStart');
				var tag_begin = "<i>";
				var tag_End = "</i>";
				var v = $('#Tjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Tjobdescription').val( textBefore + tag_begin + textAfter + tag_End );
	});
	
	$( '#drsvr_enter' ).on('click', function(){
				var cursorPos = $('#Tjobdescription').prop('selectionStart');
				var tag_End = "</br>";
				var v = $('#Tjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Tjobdescription').val( textBefore + textAfter + tag_End );
	});
	
	$( '#drsvr_tab' ).on('click', function(){
				var cursorPos = $('#Tjobdescription').prop('selectionStart');
				var tag_begin = "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
				var v = $('#Tjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Tjobdescription').val( textBefore + tag_begin + textAfter );
	});
	
	$( '#drsvr_caret_right' ).on('click', function(){
				var cursorPos = $('#Tjobdescription').prop('selectionStart');
				var tag_begin = '<i class="fa fa-caret-right" aria-hidden="true">';
				var tag_End = "</i>";
				var v = $('#Tjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Tjobdescription').val( textBefore + tag_begin + textAfter + tag_End );
	});
	
	
	
	// LAB
	
	$( '#Ldrsvr_bold' ).on('click', function(){
				var cursorPos = $('#Ljobdescription').prop('selectionStart');
				var tag_begin = "<b>";
				var tag_End = "</b>";
				var v = $('#Ljobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Ljobdescription').val( textBefore+ tag_begin +textAfter + tag_End );
	});
	
	
	$( '#Ldrsvr_italic' ).on('click', function(){
				var cursorPos = $('#Ljobdescription').prop('selectionStart');
				var tag_begin = "<i>";
				var tag_End = "</i>";
				var v = $('#Ljobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Ljobdescription').val( textBefore + tag_begin + textAfter + tag_End );
	});
	
	$( '#Ldrsvr_enter' ).on('click', function(){
				var cursorPos = $('#Ljobdescription').prop('selectionStart');
				var tag_End = "</br>";
				var v = $('#Ljobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Ljobdescription').val( textBefore + textAfter + tag_End );
	});
	
	$( '#Ldrsvr_tab' ).on('click', function(){
				var cursorPos = $('#Ljobdescription').prop('selectionStart');
				var tag_begin = "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
				var v = $('#Ljobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Ljobdescription').val( textBefore + tag_begin + textAfter );
	});
	
	$( '#Ldrsvr_caret_right' ).on('click', function(){
				var cursorPos = $('#Ljobdescription').prop('selectionStart');
				var tag_begin = '<i class="fa fa-caret-right" aria-hidden="true">';
				var tag_End = "</i>";
				var v = $('#Ljobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Ljobdescription').val( textBefore + tag_begin + textAfter + tag_End );
	});
	
	
	// WORK
	
	$( '#Wdrsvr_bold' ).on('click', function(){
				var cursorPos = $('#Wjobdescription').prop('selectionStart');
				var tag_begin = "<b>";
				var tag_End = "</b>";
				var v = $('#Wjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Wjobdescription').val( textBefore+ tag_begin +textAfter + tag_End );
	});
	
	
	$( '#Wdrsvr_italic' ).on('click', function(){
				var cursorPos = $('#Wjobdescription').prop('selectionStart');
				var tag_begin = "<i>";
				var tag_End = "</i>";
				var v = $('#Wjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Wjobdescription').val( textBefore + tag_begin + textAfter + tag_End );
	});
	
	$( '#Wdrsvr_enter' ).on('click', function(){
				var cursorPos = $('#Wjobdescription').prop('selectionStart');
				var tag_End = "</br>";
				var v = $('#Wjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Wjobdescription').val( textBefore + textAfter + tag_End );
	});
	
	$( '#Wdrsvr_tab' ).on('click', function(){
				var cursorPos = $('#Wjobdescription').prop('selectionStart');
				var tag_begin = "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
				var v = $('#Wjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Wjobdescription').val( textBefore + tag_begin + textAfter );
	});
	
	$( '#Wdrsvr_caret_right' ).on('click', function(){
				var cursorPos = $('#Wjobdescription').prop('selectionStart');
				var tag_begin = '<i class="fa fa-caret-right" aria-hidden="true">';
				var tag_End = "</i>";
				var v = $('#Wjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Wjobdescription').val( textBefore + tag_begin + textAfter + tag_End );
	});
	
	
	// Project
	
	$( '#Pdrsvr_bold' ).on('click', function(){
				var cursorPos = $('#Pjobdescription').prop('selectionStart');
				var tag_begin = "<b>";
				var tag_End = "</b>";
				var v = $('#Pjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Pjobdescription').val( textBefore+ tag_begin +textAfter + tag_End );
	});
	
	
	$( '#Pdrsvr_italic' ).on('click', function(){
				var cursorPos = $('#Pjobdescription').prop('selectionStart');
				var tag_begin = "<i>";
				var tag_End = "</i>";
				var v = $('#Pjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Pjobdescription').val( textBefore + tag_begin + textAfter + tag_End );
	});
	
	$( '#Pdrsvr_enter' ).on('click', function(){
				var cursorPos = $('#Pjobdescription').prop('selectionStart');
				var tag_End = "</br>";
				var v = $('#Pjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Pjobdescription').val( textBefore + textAfter + tag_End );
	});
	
	$( '#Pdrsvr_tab' ).on('click', function(){
				var cursorPos = $('#Pjobdescription').prop('selectionStart');
				var tag_begin = "<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
				var v = $('#Pjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Pjobdescription').val( textBefore + tag_begin + textAfter );
	});
	
	$( '#Pdrsvr_caret_right' ).on('click', function(){
				var cursorPos = $('#Pjobdescription').prop('selectionStart');
				var tag_begin = '<i class="fa fa-caret-right" aria-hidden="true">';
				var tag_End = "</i>";
				var v = $('#Pjobdescription').val();
				var textBefore = v.substring(0,  cursorPos );
				var textAfter  = v.substring( cursorPos, v.length );
				$('#Pjobdescription').val( textBefore + tag_begin + textAfter + tag_End );
	});	


</script>
	


</html>