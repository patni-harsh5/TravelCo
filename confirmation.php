<?php
	include 'utility.php';
	$flightRecords = array();
	$hotelRecord = array();

	$uName = $_SESSION['user'];
	if(isset($_SESSION["deptFlightSelection"])){
		$deptFlightRecord = $_SESSION["deptFlightSelection"];
		//$flightRecords = array($deptFlightRecord, $returnFlightRecord);
		array_push($flightRecords, $deptFlightRecord);
	}
	else
		$deptFlightRecord = array();

	if(isset($_SESSION["returnFlightSelection"])){
		$returnFlightRecord = $_SESSION["returnFlightSelection"];
		//$flightRecords = array($deptFlightRecord, $returnFlightRecord);
		array_push($flightRecords, $returnFlightRecord);
	}

	else
		$returnFlightRecord = array();
	if(isset($_SESSION["hotelSelection"])){
		//echo "hotelSelection set!";
		$hotelRecord = $_SESSION["hotelSelection"];
		//print_r($hotelRecord);
	}

	/************************************* TEST DATA *******************************************/
	//$uName = "z_l24";
	//$deptFlightRecord = array("num_travelers"=>"2", "flight_id"=>"2", "airline_name"=>"Delta", "flight_no"=>"D4365", "cabin"=>"Economy", "fare_mileage"=>"25000",
	//							"distance"=>"1001", "dept_airport"=>"AUS", "dept_city"=>"Austin", "dept_date"=>"10/10/2018", "dept_time"=>"06:30 am",
	//							"arr_airport"=>"IND", "arr_city"=>"Indianapolis", "arr_date"=>"10/10/2018", "arr_time"=>"10:30 am", "fare_dollars"=>"200"
	//					);
	//$returnFlightRecord = array("num_travelers"=>"2", "flight_id"=>"3", "airline_name"=>"Delta", "flight_no"=>"D5634", "cabin"=>"Economy", "fare_mileage"=>"25000",
  //						"distance"=>"1001", "dept_airport"=>"IND", "dept_city"=>"Indianapolis", "dept_date"=>"10/20/2018", "dept_time"=>"08:30 am",
	//							"arr_airport"=>"AUS", "arr_city"=>"Austin", "arr_date"=>"10/20/2018", "arr_time"=>"11:30 am", "fare_dollars"=>"250"
	//					);
	//$flightRecords = array($deptFlightRecord, $returnFlightRecord);
	//$hotelRecord = array("num_rooms"=>"2", "hotel_id"=>"1", "hotel_name"=>"Holiday Inn", "hotel_address"=>"Austin, TX", "room_id"=>"Queen",
	//							"hotel_check_in"=>"10/10/2018", "hotel_check_out"=>"10/13/2018", "price"=>"175"
	//						);
	/**********************************************************************************/

	$conn = mysqli_connect("localhost","root","","survey_db_2018");
	if (mysqli_connect_errno()) {
		die('Could not connect: ' . mysqli_connect_error());
	}
	//mysql_select_db($dbname,$conn);
	$sql = "SELECT * FROM users WHERE user_id = '$uName'";
	$result = mysqli_query($conn, $sql);
	$accInfo = $result->fetch_array(MYSQLI_ASSOC);

	//USER CONFIRMED PAYMENT
	if(isset($_POST["Submit"])){
		//SHARED DATA PEEL
		$option = $_POST["paymentradiobutton"];
		$sql = "SELECT creditcard FROM creditcard WHERE user_id = '$uName'";
		$result = mysqli_query($conn, $sql);
		$temp = $result->fetch_array(MYSQLI_ASSOC);
		$creditcard = $temp["creditcard"];
		//$total = $_SESSION["total"];

		if($hotelRecord){
			$hoteltotal = $_SESSION["totalHotel"];
			$hoteltotal += ( $hoteltotal * 0.15);
		}

		if($flightRecords){
			$currentMileage = $_SESSION["userMileage"];
			$flighttotal = $_SESSION["totalFlight"];
			if($option == 0){
				$newMileage = $currentMileage + ($deptFlightRecord["distance"] + $returnFlightRecord["distance"] );
				$flighttotal += ( $flighttotal * 0.15);
			}

			else {
				$totaltickets = $_SESSION["fractionBase"];
				$newMileage = ($currentMileage - ($option * $deptFlightRecord["fare_mileage"]));
				if($option != $totaltickets){
					$flighttotal -= ( $flighttotal * ( $option / $totaltickets));
					$flighttotal += ( $flighttotal * 0.15);
				}
				else{$flighttotal = 0;} //Selected all the tickets paid with mileage
			}
			$_SESSION["userMileage"]= $newMileage;
	}


		//HOTEL WAS INCLUDED
		if($hotelRecord){

			//LOAD HOTEL INFO INTO DATABASE
			$sql = "INSERT INTO hotel_transactions ( user_id, creditcard, amount)
				VALUES('$uName', '$creditcard', '$hoteltotal')";
			if (mysqli_query($conn, $sql) === TRUE) {
				$last_id = $conn->insert_id;
				echo "hotel_transactions table updated successfully";
			} else {
				echo "Error inserting hotel transaction: " . $conn->error;
				error();
			}

			$check_in = $hotelRecord["hotel_check_in"];
			$check_out = $hotelRecord["hotel_check_out"];
			$hotel_id = $hotelRecord["hotel_id"];
			$sql = "INSERT INTO hotel_bookings ( htrans_id, check_in, check_out, hotel_id)
				VALUES('$last_id', '$check_in', '$check_out', '$hotel_id')";
			if (mysqli_query($conn, $sql) === TRUE) {
				$last_id = $conn->insert_id;
				echo "hotel_bookings table updated successfully";
			} else {
				echo "Error updating hotel_bookings: " . $conn->error;
				error();
			}

			$num = $hotelRecord["guests"];
			$sql = "INSERT INTO trips ( hbook_id, user_id, num_travelers)
				VALUES('$last_id', '$uName', '$num')";
			if (mysqli_query($conn, $sql) === TRUE) {
				$last_id = $conn->insert_id;
				echo "trips table insert successfully";
			} else {
				echo "Error updating trips: " . $conn->error;
				error();
			}
			$tripRecordUpdated = $last_id;
		}

		//UPDATE FLIGHT DATABASE INFO
		if($flightRecords){

			//INSERT INTO FLIGHT_TRANSACTIONS
			$sql = "INSERT INTO flight_transacations ( user_id, creditcard, amount)
				VALUES('$uName', '$creditcard', '$flighttotal')";
			if (mysqli_query($conn, $sql) === TRUE) {
				$last_id = $conn->insert_id;
				echo "flight_transactions table updated successfully";
			} else {
				echo "Error inserting flight transaction: " . $conn->error;
				error();
			}

			//UPDATE FLIGHT BOOKINGS TABLE
			$dept_flight_id = $deptFlightRecord["flight_id"];
			if(isset($_SESSION["returnFlightSelection"])){
				$return_flight_id = $returnFlightRecord["flight_id"];
				$sql = "INSERT INTO flight_booking ( trans_id, dept_flight_id, return_flight_id)
				VALUES('$last_id', '$dept_flight_id', '$return_flight_id')";
			}
			else{
				//NO RETURN FLIGHT
				$sql = "INSERT INTO flight_booking ( trans_id, dept_flight_id)
				VALUES('$last_id', '$dept_flight_id')";
			}
			if (mysqli_query($conn, $sql) === TRUE) {
				$last_id = $conn->insert_id;
				echo "flight_bookings table updated successfully";
			} else {
				echo "Error updating flight_bookings: " . $conn->error;
				error();
			}

			//UPDATE FLIGHTS TABLE REMAINING SEATS
			$seatsTaken = $deptFlightRecord["num_travelers"];
			$deptFlight = $deptFlightRecord["flight_id"];
			$deptCabin = $deptFlightRecord["cabin"];
			$sql = "UPDATE flights SET remaining_seats = remaining_seats - '$seatsTaken' WHERE (flight_id = '$deptFlight' AND cabin_type = '$deptCabin')";
			if(isset($_SESSION["returnFlightSelection"])){
				$returnFlight = $returnFlightRecord["flight_id"];
				$returnCabin = $returnFlightRecord["cabin"];
				$sql2 = "UPDATE flights SET remaining_seats = remaining_seats - '$seatsTaken' WHERE flight_id = '$returnFlight' AND cabin_type = '$returnCabin'";
				if(mysqli_query($conn, $sql2) === TRUE){
					echo "flight table updated successfully - Return Flight";
				}
			}
			if(mysqli_query($conn, $sql) === TRUE){
				echo "flight table updated successfully - Departing FLight";
			}
			else{
				echo "Error updating flights: " . $conn->error;
			}

			//UPDATE TRIPS TABLE IF HOTEL, INSERT IF NO HOTEL
			if($hotelRecord){ //HOTEL CREATED TRIP, UPDATE TRIP
				$sql = "UPDATE trips SET fbook_id='$last_id' WHERE trips_id = '$tripRecordUpdated'";
				if (mysqli_query($conn, $sql) === TRUE) {
					$last_id = $conn->insert_id;
					echo "trips table update successfully";
				} else {
					echo "Error updating trips: " . $conn->error;
					error();
				}
			}
			else{ // NO HOTEL MUST INSERT
				$num = $deptFlightRecord["num_travelers"];
				$sql = "INSERT INTO trips ( fbook_id, user_id, num_travelers)
					VALUES('$last_id', '$uName', '$num')";
				if (mysqli_query($conn, $sql) === TRUE) {
					$last_id = $conn->insert_id;
					echo "trips table insert successfully";
				} else {
					echo "Error updating trips: " . $conn->error;
					error();
				}
			}

			//UPDATE USER MILEAGE IN USERS TABLE
			//$userMileage = $_SESSION["userMileage"];
			$sql = "UPDATE users SET mileage='$newMileage' WHERE user_id='$uName'";
			if (mysqli_query($conn, $sql) === TRUE) {
					$last_id = $conn->insert_id;
					echo "users table updated successfully";
			} else {
				echo "Error updating users: " . $conn->error;
				error();
			}

		}

		$conn->close();
		//$_SESSION["trips_Record"] = array("trips_id"=>'$tripRecordUpdated');
		unset($_SESSION["deptFlightSelection"]);
		unset($_SESSION["returnFlightSelection"]);
		unset($_SESSION["hotelSelection"]);
		echo '<meta http-equiv="refresh" content="0;URL=userAccountPage.php" />';
	}

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
			if(document.confirmation.payment.value=="")
			{
				alert("Please select a payment option");
				document.confirmation.payment.focus();
				return false;
			}
		}
	</script>

	<script type="text/Javascript">
		function error()
		{
				alert("OOPS! There was an error, please try again later.");
				document.location.href="/";
				return false;
		}
	</script>

	</head>

	<body>
	<?php echo get_header();?>
	<div class="container-fluid" id="background">
		<div class="container padding-top-10"  id="login-form">
			<div class="panel panel-default register-panel">
				<div class="panel-heading" align = "center">
					<b><font size="8px" style="font-family: 'Josefin Sans', sans-serif;">Confirmation</font></b>
				</div>
				<div class="panel body">
					<?php
					if(isset($_SESSION["flightandhotel"])){
							echo '<b><font size="4px" style="font-family: \'Josefin Sans\', sans-serif;">*20% Discount Applied in Total</font></b>';
						}
						$totalFlight = 0;
						if($flightRecords){
							foreach($flightRecords as $flightRecord){
								$totalFlight += $flightRecord["fare_dollars"];
								echo '<table border="1" bordercolor="ffffff" height = "120" color = "white">';
								echo '<tbody>';
								echo '<tr>';
								echo '<td align = "center" style="color: white;"><p><strong>Travelers</strong></p></td>';
								echo '<td align = "center" style="color: white;"><strong>Flight</strong></td>';
								echo '<td align = "center" style="color: white;"><strong>Cabin</strong></td>';
								echo '<td align = "center" style="color: white;"><strong>Departure Airport</strong></td>';
								echo '<td align = "center" style="color: white;"><strong>Dept. Date/Time</strong></td>';
								echo '<td align = "center" style="color: white;"><strong>Arrival Airport</strong></td>';
								echo '<td align = "center" style="color: white;"><strong>Arrival Dept. Date/Time</strong></td>';
								echo '<td align = "center" style="color: white;"><strong>Fare(before taxes + fees)</strong></td>';
								echo '<td align = "center" style="color: white;"><strong>Mileage Cost</strong></td>';
								echo '</tr>';

								echo "<tr>";
								echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord["num_travelers"] . "</td>";
								echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord["airline_name"] . " Flight " . $flightRecord["flight_no"] . "</td>";
								echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord["cabin"] . "</td>";
								echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord["dept_airport"] . ", " . $flightRecord["dept_city"] . "</td>";
								echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord["dept_date"] . "  at  " . $flightRecord["dept_time"] ."</td>";
								echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord["arr_airport"]. ", " . $flightRecord["arr_city"] . "</td>";
								echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord["arr_date"] . "  at  " . $flightRecord["arr_time"] ."</td>";
								echo "<td align = \"center\" style=\"color: white;\">" . "$" . $flightRecord["fare_dollars"] . "</td>";
								echo "<td align = \"center\" style=\"color: white;\">" .  $flightRecord["fare_mileage"] . "</td>";
								echo "</tr>";

								echo '</tbody>';
								echo '</table>';
								echo '<br><br>';
							}
						}
					?>
					<?php
						if($hotelRecord){
							echo "<table border=\"1\" bordercolor=\"ffffff\" height = \"120\" color = \"white\">";
							echo "<tbody>";
							echo "<tr>";
							echo '<td align = "center" style="color: white;"><p><strong>Rooms</strong></p></td>';
							echo '<td align = "center" style="color: white;"><strong>Hotel</strong></td>';
							echo '<td align = "center" style="color: white;"><strong>Room Type</strong></td>';
							echo '<td align = "center" style="color: white;"><strong>Check-in</strong></td>';
							echo '<td align = "center" style="color: white;"><strong>Check-out</strong></td>';
							echo '<td align = "center" style="color: white;"><strong>Per Night</strong></td>';
							echo '</tr>';

							echo "<tr>";
							echo "<td align = \"center\" style=\"color: white;\">" . $hotelRecord["num_rooms"] . "</td>"; 	/*<!-- Number Travelers	-->*/
							echo "<td align = \"center\" style=\"color: white;\">" . $hotelRecord["hotel_name"] . " at " . $hotelRecord["hotel_address"]. "</td>"; 		/*<!-- Hotel Name    	-->*/
							echo "<td align = \"center\" style=\"color: white;\">" . $hotelRecord["room_id"] . "</td>";
							echo "<td align = \"center\" style=\"color: white;\">" . $hotelRecord["hotel_check_in"] . "</td>"; 	/*<!-- Hotel Check-in      -->*/
							echo "<td align = \"center\" style=\"color: white;\">" . $hotelRecord["hotel_check_out"] . "</td>"; /*<!-- Hotel Check-out   -->*/
							echo "<td align = \"center\" style=\"color: white;\">" . "$" . $hotelRecord["price"] . "</td>";
							echo "</tr>";

							echo '</tbody>';
							echo '</table>';
							echo '<br><br>';
						}
					?>
					<?php
						echo '<br><br>';
						echo '<table border="1" bordercolor="ffffff" height = "120" color = "white">';
						echo '<tbody>';
						echo "<tr>";
						if($flightRecords){
							echo '<td align = "center" style="color: white;"><strong> Airline Cost </strong></td>';
						}
						if($hotelRecord){
							echo '<td align = "center" style="color: white;"><strong> Hotel Cost </strong></td>';
						}
						echo '<td align = "center" style="color: white;"><strong> Tax + Fees </strong></td>';
						echo '<td align = "center" style="color: white;"><strong> Total </strong></td>';
						echo "</tr>";

						echo "<tr>";

						$totalHotel = 0;
						if($flightRecords){
							$totalFlight *= $flightRecord["num_travelers"] ;
							if(isset($_SESSION["flightandhotel"])){
								$totalFlight *= .8;
							}
							$_SESSION["totalFlight"] = $totalFlight;
							echo '<td align = "center" style="color: white;">' . "$" . $totalFlight . '</td>';
						}
						if($hotelRecord){
							$in = new DateTime($hotelRecord["hotel_check_in"]);
							$out = new DateTime($hotelRecord["hotel_check_out"]);
							$dayCounter = $in->diff($out);
							$daysHotel = $dayCounter->d;
							$totalHotel = $hotelRecord["num_rooms"] * $hotelRecord["price"] * ($daysHotel);
							if(isset($_SESSION["flightandhotel"])){
								$totalHotel *= .8;
							}
							$_SESSION["totalHotel"] = $totalHotel;
							echo '<td align = "center" style="color: white;">' . "$" . $totalHotel . '</td>';
						}

						$taxTotal = ($totalFlight + $totalHotel)*0.15;
						echo '<td align = "center" style="color: white;">' . "$" . $taxTotal . '</td>';
						$total = $taxTotal + $totalHotel +$totalFlight;
						$_SESSION["total"] = $total;
						echo '<td align = "center" style="color: white;">' . "$" . $total . '</td>';
						echo "</tr>";

						echo '</tbody>';
						echo '</table>';
					?>
					<br>

					<form name="confirmation" action="confirmation.php" onsubmit="return validate()" method="post">
						<br>
						<fieldset class="payment">
							<legend>Please Select a Payment Method:</legend>
							<h3 style="color: #59f442">Your current mileage: <?php echo $accInfo["mileage"]; ?></h3>
							<input type="radio" id="paymentMethod" name="paymentradiobutton" value="0" checked />
							<label for="creditCardMethod" style="padding-right: 3em;">Credit Card</label>
							<?php
							$_SESSION["fractionBase"]=1;
							if($flightRecords){
								$userMileage = $accInfo["mileage"];
								$_SESSION["userMileage"]=$userMileage;
								$perTicketMileage = $flightRecord["fare_mileage"];
								$totalMileageCost = $flightRecord["fare_mileage"] * $flightRecord["num_travelers"];
								if($userMileage > 0){
									$counter = $flightRecord["num_travelers"];
									$_SESSION["fractionBase"] = $counter;
								}
								$passenger = 1;
								while(($userMileage >= $perTicketMileage)&&($counter >= $passenger)){
									$userMileage = $userMileage - $perTicketMileage;
									$fraction = ($passenger/$counter);
									echo "<br>";
									if($passenger==$counter){
										echo '<input type="radio" id="paymentMethod" name="paymentradiobutton" value="'. $passenger . '" />';
										echo '<label for="mileageMethod" title="Tickets" style="padding-right: 3em;">' . $passenger . ' ticket(s) via mileage</label>';
									}
									else{
										echo '<input type="radio" id="paymentMethod" name="paymentradiobutton" value="'. $passenger . '" />';
										echo '<label for="mileageMethod" title="Tickets" style="padding-right: 3em;">' . $passenger . ' ticket(s) via mileage + Credit Card ($' . ($total - ($total*$fraction)) . ' will be charged to your card)</label>';
									}
									$passenger++;
								}
							}
							?>
						</fieldset>
						<div class="row padding-top-10">
							<div class="col-sm-offset-5 col-sm-10">
								<button type="Submit" data-toggle="tooltip" name="Submit" data-placement="right" title="Submit" class="btn btn-primary">CONFIRM</button>
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
