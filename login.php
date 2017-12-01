<?
	session_start();
	if (isset($_SESSION['authorizedUser'])){
		header("location: index.php");
	}

	$servername = "";
	$username = "";
	$password = "";
	$dbname = "";

	$con = mysqli_connect($servername, $username, $password, $dbname);

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		$data = str_replace("'","''",$data);
		return $data;
	}

?>
<?

if ( !isset($_SESSION['result']) && !isset($_SESSION['authorizedUser']) ){
	
	if ( isset($_POST['Submit']) ){
		
			$username = test_input($_POST['uname']);
			$password = test_input($_POST['password']);
		
			$hashed_username = md5($username);	
			$hashed_password = md5($password);

			$sql = "SELECT * FROM `admin` WHERE `username` LIKE '$hashed_username' AND `password` LIKE '$hashed_password'";
			$result = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($result);

			if ($row){
				$_SESSION['authorizedUser'] = $username;	
				$_SESSION['result'] = "done";
				error_reporting(E_ALL);
				header("location: index.php");
			}
			else {
				$_SESSION['result'] = "notdone";
				unset($_SESSION['authorizedUser']);
			}
		}
}
	
	

?>

<!DOCTYPE html>
<html lang="en">
	
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="css/signup.css"   rel="stylesheet" type="text/css">
	<link href="css/homepage.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>
	<script src="js/jquery.slim.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/c71879315a.js"></script>
	

<title>Admin Login</title>
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
						<a class="nav-item nav-link" id="navBarCollapse" href="contact.php">contact me</a>
					</div><!-- navbar-nav -->
				</div><!-- collapse navbar-collapse -->
			</nav><!-- nav -->
			
			
		</div>
	
	
	</header>
	


	<div class="container" id="bodyContainer">
		<div class="row">
			<div class="col">
				<div class="container">
					<form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

						<div class="reg_form" style="width: 75%; margin: 20px auto">
							
							<h3>LOGIN</h3>

							<div id="signup_err">
								Please fill out all of the required fields.
							</div>
							
							<? if (isset($_SESSION['result'])){ 
										if ($_SERVER['result']=='done'){
											echo '<center><label class="success text-success">You have logged in successfully!</label></center><br>';
											unset($_SESSION['result']);
										}
										else {
											echo '<center><label class="error text-danger">Username and Password does not match, please try again!</label></center><br>';
											unset($_SESSION['result']);
										}
										
								}
							
								
							?>
							
							<label class="editLabel">USERNAME</label>
							<input type="text" placeholder="Enter your username" name="uname" id="uname" required/>
							
							<label class="editLabel">PASSWORD</label>
							<input type="password" placeholder="Enter your password" name="password" id="password" required/>

							<input type="submit" ID="submitbtn" name="Submit" value="Submit"/>
						</div>

					</form>
				</div> 
			</div>
		</div>
	</div>
		<footer>
			<div class="container" id="myFooter">
					<div class="row">
						<div class="col-md-6 col-lg-7 col-xl-8">
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
					</div>
			</div>
		</footer>
	
	
		    <script>
					$("form input").on("invalid", function(event) { 
						event.preventDefault(); 
						$("#signup_err").show();
					});
	    	</script>
	
			
	
</body>

</html>