<? include ($_SERVER['DOCUMENT_ROOT']."/phpscripts/"."session.php") ?>
<? include ($_SERVER['DOCUMENT_ROOT']."/phpscripts/"."connectDB.php") ?>	

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="css/homepage.css" rel="stylesheet" type="text/css">
	<script src="js/jquery.slim.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/c71879315a.js"></script>

<title>Work Experiences</title>
</head>
	


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
		
		<?
	
		$tableName = "workExperiences";		

		$sql_we = "SELECT * FROM `workExperiences` WHERE 1 ORDER BY `startDateYear` desc , `startDataMonth` desc";
		$result_we = mysqli_query($con, $sql_we);

		while ($row_we = mysqli_fetch_array($result_we)) {
			
				
				$workTitle = $row_we['workTitle'];
				$workURL = $row_we['workURL'];
				$workLocation = $row_we['workLocation'];


				$workStartDateMonth = num_to_month($row_we['startDataMonth']); 
				$workStartDateYear = $row_we['startDateYear']; 
				$workEndDateMonth = num_to_month($row_we['endDateMonth']);
				$workEndDateYear = $row_we['endDateYear']; 

				$workDescription = $row_we['workDescription'];
				$workID = $row_we['workID'];


				$workPDF = $row_we['pdfDir'];
			
				$tableName = "workExperiences";
				

				echo '<div class="row reg_form" style="margin-left: 5px; margin-right: 5px">';
				echo '<div class="col">';
				echo '<div class="row text-left">';
				echo '<span class="research_header_text text-uppercase"> ';
				echo '<i class="fa fa-building fa-lg goldText" aria-hidden="true">&nbsp</i>'.$workTitle;
				echo '</span></div>';
				echo '<div class="row">';
				echo '<div class="col-auto" style="padding-left: 0px; border-right: solid thin gray;">';
				echo '<div class="myDate">';
				echo '<center><div class="myYear">FROM</div></center>';
				echo '<div class="myMonth">'.$workStartDateMonth.'</div>';
				echo '<center><div class="myYear">'.$workStartDateYear.'</div></center>';
				echo '</div>';
				echo '<div class="myDate">';
				echo '<center><div class="myYear">TO</div></center>';
				echo '<div class="myMonth">'.$workEndDateMonth.'</div>';
				echo '<center><div class="myYear">'.$workEndDateYear.'</div></center>';
				echo '</div></div>';
				echo '<div class="col">';
				echo '<span class="teaching_location_date_text text-muted">'.'<a href="'.$workURL.'" target="_blank" class="bioLink text-muted">'.$workLocation.'</a>'.'</span>';

				echo '<br>';
			    echo '<hr>';
				echo '<p class="teaching_desc_date_text text-justify">'.$workDescription;
				
			
			
				if ($target_file_pdf){
					
					echo '<br>';
					echo '<br>';
					
					echo '<span class="text-justify text-uppercase">';
					echo '<a href="'.$target_file_pdf.'" class="fa fa-file-pdf-o fa-2x bioLink skillTag" target="_blank">&nbsp</a>';
					
					echo '</span>';
					
					
				}
			
				
			
				echo '<br>';
				echo '<br>';
			
				echo '<span class="text-justify text-uppercase">';
				
				$sql_tags = "SELECT * FROM `tagsDB` WHERE `entryID` LIKE '$workID' AND `tableName` LIKE '$tableName'";
				$result_tags = mysqli_query($con, $sql_tags);
				
				while ($row_tags = mysqli_fetch_array($result_tags)) {
					$tagName = $row_tags['tagName'];
					echo '<a href="result.php?tag='.$tagName.'" target="_blank" class="bioLink skillTag">'.splitWords($tagName).'&nbsp</a>';
				}
				echo '</span>';
				echo '</p>';
				echo '</div></div></div></div>';

			}

		?>
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

</html>