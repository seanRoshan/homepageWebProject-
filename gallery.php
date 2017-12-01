<? include ($_SERVER['DOCUMENT_ROOT']."/phpscripts/"."session.php") ?>
<? include ($_SERVER['DOCUMENT_ROOT']."/phpscripts/"."connectDB.php") ?>	

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/gallery.css">
	<link href="css/homepage.css" rel="stylesheet" type="text/css">
	<script src="js/jquery.slim.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/c71879315a.js"></script>

<title>Gallery</title>
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
			
		<div class="row">
			
				<div class="gallery">
					
					<?
					
						$sql_images = "SELECT * FROM `gallery` WHERE 1";
						$result_images = mysqli_query($con, $sql_images);
										   	
							while ($row_images = mysqli_fetch_array($result_images)) {


								$imageCaption = $row_images['imageCaption'];
								$imageLocation = $row_images['imageLocation'];
								$imageURL = $row_images['imageURL'];
								$imageIndex = $row_images['imageIndex'];
								
								
								
								echo '<figure>';
								echo '<img src="'.$imageURL.'" alt="'.$imageCaption.'"/>';
								echo '<figcaption>'.$imageCaption.'<small>'.$imageLocation.'</small></figcaption>';
								echo '</figure>';
							}
					
					
					?>
  
				</div>

				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display:none;">
				  <symbol id="close" viewBox="0 0 18 18">
					<path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M9,0.493C4.302,0.493,0.493,4.302,0.493,9S4.302,17.507,9,17.507
							S17.507,13.698,17.507,9S13.698,0.493,9,0.493z M12.491,11.491c0.292,0.296,0.292,0.773,0,1.068c-0.293,0.295-0.767,0.295-1.059,0
							l-2.435-2.457L6.564,12.56c-0.292,0.295-0.766,0.295-1.058,0c-0.292-0.295-0.292-0.772,0-1.068L7.94,9.035L5.435,6.507
							c-0.292-0.295-0.292-0.773,0-1.068c0.293-0.295,0.766-0.295,1.059,0l2.504,2.528l2.505-2.528c0.292-0.295,0.767-0.295,1.059,0
							s0.292,0.773,0,1.068l-2.505,2.528L12.491,11.491z"/>
				  </symbol>
				</svg>

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

<script src="js/gallary.js"></script>

</html>