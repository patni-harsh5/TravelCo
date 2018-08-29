<?php
	include 'utility.php';
	$id;

	if(isset($_SESSION['user'])){
		$uName = $_SESSION['user'];
		//echo $uName . "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
		$id = $_GET['tripid'];
		$tripRecord = $_SESSION["tripRecord" . $id];

		if(isset($_POST["Submit"])){
			$conn = mysqli_connect("localhost","root","","survey_db_2018");
			if (mysqli_connect_errno()) {
					die('Could not connect: ' . mysqli_connect_error());
			}
			if(!empty($_POST['rating'])){
			$newRating = $_POST['rating'];
			$newComments = $_POST['comments'];
			$tripID = $tripRecord["trips_id"];
			//mysql_select_db($dbname,$conn);
			$sql = "INSERT INTO feedback ( rating, comments, user_id, trips_id)
					VALUES('$newRating', '$newComments', '$uName', '$tripID')";
			if (mysqli_query($conn, $sql) === TRUE) {
				$last_id = $conn->insert_id;
				//echo "Feedback table updated successfully";
			} else {
				echo "Error recording feedback: " . $conn->error;
			}


			$sql = "UPDATE trips SET feedback_id='$last_id' WHERE trips_id = '$tripID'";
			if (mysqli_query($conn, $sql) === TRUE) {
				//echo "User table updated successfully";
			} else {
				echo "Error updating user: " . $conn->error;
			}

			$conn->close();
			echo '<meta http-equiv="refresh" content="0;URL=userAccountPage.php" />';
		}
	}
	}

	else
		header('Location: login.php');
?>

<html>
	<head>
  	<title>TravelCo</title>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
  	<link href='https://fonts.googleapis.com/css?family=Josefin+Sans:700' rel='stylesheet' type='text/css'>
  	<link href='https://fonts.googleapis.com/css?family=Poiret+One&subset=latin,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
  	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  	<link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
  	<link rel="stylesheet" href="css/footer.css">
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  	<link rel="stylesheet" type="text/css" href="css/header1.css">
  	<link rel="stylesheet" type="text/css" href="css/page.css">

	<style>
		#background{
	    <!--background: url(images/flight1.jpg);-->
	    width: 100%;
	    height: auto;
	    background-size: cover;
	    background-position: center center;
	    background-attachment: fixed;
		}
		.affix {
			top:0;
			width: 100%;
			z-index: 9999 !important;
		}

		.navbar{
	  	border-radius: 0px !important;
	  	margin-bottom: 0px;
		}

		#login-form{
			padding-top: 6%;
			padding-bottom: 10%;
		}

		.register-panel, .panel-default>.panel-heading, .panel .body{
	 		background: rgba(0,0,0,0.4);
	   	color: white;
		}

		.panel .body{
			padding: 15px;
		}

		.panel{
			margin-bottom: 0;
		}

		legend {
			color: #FFFFFF;
		}

	</style>
	<script type="text/Javascript">
		function validate()
		{
			if(document.feedback.rating.value == 0)
			{
				alert("Please select a rating");
				document.feedback.rating.focus();
				return false;
			}

			if(document.feedback.comments.value=="")
			{
				alert("Please enter comments");
				document.feedback.comments.focus();
				return false;
			}

		}
	</script>

	</head>

<body>
	<?php echo get_header();?>
	<div class="container-fluid" id="background">
	<div class="container padding-top-10"  id="login-form">
	  <div class="panel panel-default register-panel">
			<div class="panel-heading">
				<b><font size="8px" style="font-family: 'Josefin Sans', sans-serif;">We want your feedback!</font><i class="fas fa-pencil-alt fa-3x" style="margin-left: 20px"></i></b>
				<button type="button" onclick=location.href="userAccountPage.php" style="float: right;" data-toggle="tooltip" data-placement="right" title="Skip" class="btn btn-primary">SKIP</button>
			</div>
			<div class="panel body">
				<table border="1" bordercolor="ffffff" height = "120" color = "white">
				<tbody>
				<tr>
					<td align = "center" style="color: white;"><p><strong>Trip Number</strong></p></td>
					<td align = "center" style="color: white;"><p><strong>Number of Travelers</strong></p></td>
					<?php
					$h = 0;
					$f = 0;
					if($tripRecord["hotel_name"]!=""){
						$h = 1;
						echo '<td align = "center" style="color: white;"><strong>Hotel</strong></td>';
						echo '<td align = "center" style="color: white;"><strong>Check-in</strong></td>';
						echo '<td align = "center" style="color: white;"><strong>Check-out</strong></td>';
					}
					if($tripRecord["airline_name"] != ""){
						$f = 1;
						echo '<td align = "center" style="color: white;"><strong>Airline</strong></td>';
						echo '<td align = "center" style="color: white;"><strong>Departure Airport</strong></td>';
						echo '<td align = "center" style="color: white;"><strong>Deptarture Date</strong></td>';
						echo '<td align = "center" style="color: white;"><strong>Arrival Airport</strong></td>';
						echo '<td align = "center" style="color: white;"><strong>Return Date</strong></td>';
					}
					?>
				</tr>

				<?php
					echo "<tr>";
					echo "<td align = \"center\" style=\"color: white;\">" . $tripRecord["trips_id"] . "</td>"; 		/*<!-- Trip Number   	-->*/
					echo "<td align = \"center\" style=\"color: white;\">" . $tripRecord["num_travelers"] . "</td>"; 	/*<!-- Number Travelers	-->*/
					if($h==1){
						echo "<td align = \"center\" style=\"color: white;\">" . $tripRecord["hotel_name"] . "</td>"; 		/*<!-- Hotel Name    	-->*/
						echo "<td align = \"center\" style=\"color: white;\">" . $tripRecord["hotel_check_in"] . "</td>"; 	/*<!-- Hotel Check-in      -->*/
						echo "<td align = \"center\" style=\"color: white;\">" . $tripRecord["hotel_check_out"] . "</td>"; /*<!-- Hotel Check-out   -->*/
					}
					
					if($f==1){
						echo "<td align = \"center\" style=\"color: white;\">" . $tripRecord["airline_name"] . "</td>"; 	/*<!-- Airline Name    -->*/
						echo "<td align = \"center\" style=\"color: white;\">" . $tripRecord["dept_airport"] . "</td>"; 	/*<!-- Departure Airport -->*/
						echo "<td align = \"center\" style=\"color: white;\">" . $tripRecord["dept_date"] . "</td>"; 		/*<!-- Departure Date/Time  -->*/
						echo "<td align = \"center\" style=\"color: white;\">" . $tripRecord["arr_airport"] . "</td>"; 									/*<!-- Arrival Airport   -->*/
						echo "<td align = \"center\" style=\"color: white;\">" . $tripRecord["return_arr_date"] . "</td>"; 	/*<!-- Airline Name    -->*/
					}
					echo "</tr>";
				?>
				</tbody>
				</table>
				<br><br><br>
				<form name="feedback" method="post" action="?tripid=<?php echo $id?>" onsubmit="return validate()">
					<br>
						<fieldset class="rating">
						<legend>Please rate:</legend>
						<input type="radio" id="rating10" name="rating" value="10" />
						<label for="rating10" title="Best" style="padding-right: 3em;">10 (best)</label>
						<input type="radio" id="rating9" name="rating" value="9" />
						<label for="rating9" style="padding-right: 3em;">9 </label>
						<input type="radio" id="rating8" name="rating" value="8" />
						<label for="rating8" style="padding-right: 3em;">8 </label>
						<input type="radio" id="rating7" name="rating" value="7" />
						<label for="rating7" style="padding-right: 3em;">7 </label>
						<input type="radio" id="rating6" name="rating" value="6" />
						<label for="rating6" style="padding-right: 3em;">6 </label>
						<input type="radio" id="rating5" name="rating" value="5" />
						<label for="rating5" title="Okay" style="padding-right: 3em;">5 (okay) </label>
						<input type="radio" id="rating4" name="rating" value="4" />
						<label for="rating4" style="padding-right: 3em;">4 </label>
						<input type="radio" id="rating3" name="rating" value="3" />
						<label for="rating3" style="padding-right: 3em;">3 </label>
						<input type="radio" id="rating2" name="rating" value="2" />
						<label for="rating2" style="padding-right: 3em;">2 </label>
						<input type="radio" id="rating1" name="rating" value="1" />
						<label for="rating1" title="Worst" style="padding-right: 3em;">1 (worst)</label>
						</fieldset>
						<br><br>
					<label for="comments" class="control-label padding-top-10">Comments:</label>
					<div class="row padding-top-10">
						<div class="col-md-6">
							<textarea  type="text" class="form-control" id="address" name="comments" placeholder="Tell us what you think..."></textarea>
						</div>
					</div>
			<br><br>
			<div class="row padding-top-10">
				<div class="col-sm-offset-5 col-sm-10">
					<button type="Submit" data-toggle="tooltip" data-placement="right" title="Submit" name = "Submit" class="btn btn-primary">SUBMIT</button>
				</div>
			</div>
		</form>
	</div>
	</div>
</div>
</div>
  <?php echo get_footer();?>
	</body>
</html>
