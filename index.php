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

<title>Shahriyar ValielahiRoshan</title>
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
		<h1 class="text-uppercase">Shahriyar ValielahiRoshan</h1>
		<div class="row">
			<div class="col-sm-3" style="padding-top: 5px">
		    <img class="img-fluid m-auto"  src="assets/img/webAvator.jpg" alt="Shahriyar ValielahiRoshan"/> 
			</div>
		  <div class="col">
			<h2>Bio</h2>	
			<p class="text-justify" id="bioText">I am a master student in the <a href="http://cs.ucr.edu" target="_blank" class="bioLink">Department of Computer Science and Engineering</a> at the University of California, Riverside. I work under the supervision of <a href="http://danielwong.org" target="_blank" class="bioLink">Professor Daniel Wong</a>, and my research focuses on the memory transaction scheduling in the GPGPUs; the goal of this research is to minimize the memory occlusions and cache contentions for memory-intensive workloads to improve the overall GPU performance.
			<br>
			I have earned my B.S. degree in Computer Hardware Engineering major from the <a href="http://ce.sharif.ir" target="_blank" class="bioLink">Sharif University of Technology</a> which is the nation's leading institution for engineering in Iran. During my undergraduate studies, I was working on management algorithms like garbage collection and wear leveling to measure their effects on durability and performance of solid-state drives. 
			</p>
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

</html>