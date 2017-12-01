<?
session_start();



if (!isset($_SESSION['result'])){
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		$data = str_replace("'","''",$data);
		return $data;
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$fullName = $email = $telephone = $comment = ""; 
	
		if (!empty($_POST["fname"])){
			$fullName = test_input($_POST["fname"]);
		}

		if (!empty($_POST["email"])){
			$email = test_input($_POST["email"]);
		}

		if (!empty($_POST["telephone"])){
			$telephone = test_input($_POST["telephone"]);
		}

		if (!empty($_POST["comment"])){
			$comment = test_input($_POST["comment"]);
		}
		
		
		$to = "contactme@shahriyar.us"; // Send email to our user
		$subject = 'CONTACT ME - SHAHRIYAR.US - '.$fullName; // Give the email a subject 
		$headers = 'From:'.$email. "\r\n"; // Set from headers
		
		$message = "Name: ".$fullName."\n"."Phone:".$telephone."\n\n".$comment;
		
		mail($to, $subject, $message, $headers); // Send our email

		$_SESSION['result'] = "done";

		}
	
}
else {
	unset($_SESSION['result']);
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
						<a class="nav-item nav-link" id="navBarCollapse" href="contact.php">contact me</a>
					</div><!-- navbar-nav -->
				</div><!-- collapse navbar-collapse -->
			</nav><!-- nav -->
			
			
		</div>
	
	
	</header>
	


	<div class="container" id="bodyContainer">
		<div class="row">
			<div class="col-lg-6">
				<div class="container">
					<form id="contactMe" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

						<div class="reg_form">
							
							<h3>Contact me</h3>

							<div id="signup_err">
								Please fill out all of the required fields.
							</div>
							
							<? if (isset($_SESSION['result'])){ echo '<label class="success">Thank you! You message has been sent!</label><br>';}?>
							
							<label class="editLabel">Full Name</label>
							<input type="text" placeholder="Shahriyar ValielahiRoshan" name="fname" id="fname" required/>
							
							<label class="editLabel">Email</label>
							<input type="email" placeholder="contactMe@drsvr.us" name="email" required/>

							<label class="editLabel">Telephone</label>
							<input type="text" placeholder="1 (702) 545-5831" name="telephone" required/>

							<label class="editLabel">Comment</label>
							<textarea id="comment" name="comment" placeholder="Please write you comment here!" rows="4"></textarea>

							<input type="submit" ID="submitbtn" name="Submit" value="Submit"/>
						</div>


					</form>
				</div> 
			</div>
			
			<div class="col-lg-6"> 
				<div class="container">
					<div class="reg_form">
						<p class="text-center text-uppercase">
							<i class="fa fa-map-marker goldText" aria-hidden="true"></i>
							<br> 459 Winston Chung Hall
							<br> University of California, Riverside
							<br> Riverside, CA 92521
							<br>
							<br>
							<i class="fa fa-envelope goldText" aria-hidden="true"></i>
							<br> contactme@shahriyar.us
							<br>
							<br>
							<i class="fa fa-mobile goldText" aria-hidden="true"></i>
							<br> 1 (702) 545-5831 
							<br> [please leave me a voice message or send me a sms]
							<br>
							<br>
							<center>
								<div id="SkypeButton_Call_shvroshan_1">
									 <script type="text/javascript">
										 Skype.ui({
										 "name": "dropdown",
										 "element": "SkypeButton_Call_shvroshan_1",
										 "participants": ["shvroshan"]
										 });
									</script>
							   </div>
							</center>		
						</p>
					</div>
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