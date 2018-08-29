<?php
session_start(); //Start session to access session variables

function get_footer(){ //Returns HTML code to display footer
return <<< HTML
	<footer class="footer-distributed">
		<div class="footer-left">
			<h3><span>TravelCo</span></h3>
			<p class="footer-links">
			</p>
			<p class="footer-company-name">TravelCo &copy; 2018 Developed by Harsh Patni, Ethan Stewart, Nikitha, Zachary Languell</p>
		</div>
		<div class="footer-center">
			<div>
				<i class="fas fa-map-marker-alt"></i>
				<p href="#"><span>TravelCo</span> Austin, USA</p>
			</div>
			<div>
				<i class="fas fa-phone"></i>
				<a href="tel:+1(512)214-2062">+1(512)214-2062</a>
			</div>
			<div>
				<i class="fas fa-envelope"></i>
				<p><a href="mailto:support@travelco.com">support@travelco.com</a></p>
			</div>
		</div>
			<div class="footer-right">
				<p class="footer-company-about">
					<span>About the company</span>
					TravelCo was created to make your life easier. We provide a hassle free booking process for flights and hotels. Please do not hesitate to contact us with any questions!
				</p>
				<div class="footer-icons">
					<a href="#"><i class="fab fa-facebook-f"></i></a>
					<a href="#"><i class="fab fa-twitter"></i></a>
					<a href="#"><i class="fab fa-linkedin"></i></a>
					<a href="#"><i class="fab fa-github"></i></a>
				</div>
			</div>
		</footer> 
HTML;
}


function get_header(){ //Returns HTML code to proper header. (guest vs registered user headers)
	if(!isset($_SESSION["user"])){
 		$user = 'GUEST';
 		$my_header = guest_header($user);
 	}

 	else{
 		$user = $_SESSION["user"];
 		$my_header = user_header($user);
 	}

 	return $my_header;
}



function guest_header($username){
return <<< HTML
	<nav class="navbar navbar-inverse " data-spy="affix" data-offset-top="120" >
  		<div class="container-fluid">
    		<div class="navbar-header">
      		<a class="navbar-brand" href="index.php">TravelCo</a>
    		</div>
    		<div class="collapse navbar-collapse" id="myNavbar">
      		<ul class="nav navbar-nav">
        		<li><a href="index.php">HOME</a></li>
        		<li><a href="flightStatus.php">FLIGHT STATUS</a></li>
        		<!-- 
        		<li><a href="about.php">ABOUT US</a></li>
        		-->
      		</ul>
      		<ul class="nav navbar-nav navbar-right">
						<li><a href="#"><input type="text" style="background-color: khaki; color: red; font-weight: bold; text-transform: uppercase;" value="$username" readonly></a></li>
        		<li><a href="register.php"><span class="glyphicon glyphicon-pencil"></span> Sign Up</a></li>
        		<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
     		  </ul>
    		</div>
  		</div>
	</nav>
HTML;
}

function user_header($username){
return <<< HTML
	<nav class="navbar navbar-inverse " data-spy="affix" data-offset-top="120" >
  		<div class="container-fluid">
    		<div class="navbar-header">
      		<a class="navbar-brand" href="index.php">TravelCo</a>
    		</div>
    		<div class="collapse navbar-collapse" id="myNavbar">
      		<ul class="nav navbar-nav">
        		<li><a href="index.php">HOME</a></li>
        		<li><a href="flightStatus.php">FLIGHT STATUS</a></li>
        		<!-- 
        		<li><a href="about.php">ABOUT US</a></li>
        		-->
      		</ul>
      		<ul class="nav navbar-nav navbar-right">
 						<li><a href="#"><input type="text" style="background-color: khaki; color: red; font-weight: bold; text-transform: uppercase;" value="$username" readonly></a></li>
 						<li><a href="userAccountPage.php"><span class="glyphicon glyphicon-user"></span> My Account</a></li>
        		<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>
     		  </ul>
    		</div>
  		</div>
	</nav>
HTML;
}

?>