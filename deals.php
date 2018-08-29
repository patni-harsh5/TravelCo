<?php 
include 'utility.php';
$dealresults = '';
if(isset($_POST['selected-deal']))
{
	if(!empty($_POST['deal'])){
		//get deal number from form
		$dealNum = $_POST['deal'];
		if($dealNum == 1)
		  $dealNum--;

		//select corresponding deal row in the deals array
		$selectedDeal = array();
		$selectedDeal = $_SESSION['deals'][$dealNum];

		$_SESSION['deptFlightSelection'] = array(
	      "num_travelers" => $selectedDeal['num_travelers'],
	      "flight_id" => $selectedDeal['flight_id'],
	      "airline_name" => $selectedDeal['airline_name'],
	      "flight_no" => $selectedDeal['flight_no'],
	      "cabin" => $selectedDeal['cabin'],
	      "dept_airport" => $selectedDeal['dept_airport'],
	      "dept_city" => $selectedDeal['dept_city'],
	      "arr_airport" => $selectedDeal['arr_airport'],
	      "arr_city" => $selectedDeal['arr_city'],
	      "flight_id" => $selectedDeal['flight_id'],
	      "dept_date" => $selectedDeal['dept_date'],
	      "dept_time" => $selectedDeal['dept_time'],
	      "arr_date" => $selectedDeal['arr_date'],
	      "arr_time" => $selectedDeal['arr_time'],
	      "fare_dollars" => $selectedDeal['fare_dollars'] *.70,
	      "fare_mileage" => $selectedDeal['fare_mileage'] * .70,
	      "journey_hr" => $selectedDeal['journey_hr'],
	      "distance" => $selectedDeal['distance'],
	      "remaining_seats" => $selectedDeal['remaining_seats'],
		);


		$selectedDeal = $_SESSION['deals'][$dealNum + 1];

		$_SESSION['returnFlightSelection'] = array(
	      "num_travelers" => $selectedDeal['num_travelers'],
	      "flight_id" => $selectedDeal['flight_id'],
	      "airline_name" => $selectedDeal['airline_name'],
	      "flight_no" => $selectedDeal['flight_no'],
	      "cabin" => $selectedDeal['cabin'],
	      "dept_airport" => $selectedDeal['dept_airport'],
	      "dept_city" => $selectedDeal['arr_city'],
	      "arr_airport" => $selectedDeal['arr_airport'],
	      "arr_city" => $selectedDeal['dept_city'],
	      "flight_id" => $selectedDeal['flight_id'],
	      "dept_date" => $selectedDeal['dept_date'],
	      "dept_time" => $selectedDeal['dept_time'],
	      "arr_date" => $selectedDeal['arr_date'],
	      "arr_time" => $selectedDeal['arr_time'],
	      "fare_dollars" => $selectedDeal['fare_dollars'] * .70,
	      "fare_mileage" => $selectedDeal['fare_mileage'] * .70,
	      "journey_hr" => $selectedDeal['journey_hr'],
	      "distance" => $selectedDeal['distance'],
	      "remaining_seats" => $selectedDeal['remaining_seats'],
		);

		$_SESSION['hotelSelection'] = array(
	      "num_rooms"=> $selectedDeal['num_rooms'],
	      "hotel_name"=> $selectedDeal['hotel_name'],
	      "hotel_id"=> $selectedDeal['hotel_id'],
	      "hotel_address"=> $selectedDeal['hotel_address'],
	      "room_id"=> $selectedDeal['room_id'],
	      "hotel_check_in" => $selectedDeal['hotel_check_in'],
	      "hotel_check_out" => $selectedDeal['hotel_check_out'],
	      "star" => $selectedDeal['star'],
	      "guests" => $selectedDeal['guests'],
	      "price" => $selectedDeal['price'] * .70
		);

		//pass deal arrays to session variable for confirmation
		// print_r($_SESSION['deptFlightSelection']);
		// print_r($_SESSION['returnFlightSelection']);
		// print_r($_SESSION['hotelSelection']);
    if(isset($_SESSION['user'])){
      header('Location: confirmation.php');
    }
    else{
      $_SESSION['login_required'] = true;
      echo '<script type="text/javascript">alert("You must login to continue!")</script>';
      echo '<script type="text/javascript">location.replace("login.php")</script>';
    }
	}
	else
		echo "Deal not selected!!!!!!!!!!!!!!!!!";
}
if(isset($_POST['deals-submit']))
{

	$connect = mysqli_connect("localhost","root","","survey_db_2018") or die('Error Connecting To Databse');

	//get form data
	$sourceCity = $_POST['source'];
	$destCity = $_POST['destination'];
	$startingdate = $_POST['startingDate'];
	$endingdate = $_POST['endingDate'];
	$rooms = $_POST['rooms'];
	$lowrange = $_POST['low'];
	$highrange = $_POST['high'];
	$travelers = $_POST['travelers'];
	$sourceAirport;
	$destAirport;

	//Query to convert Source City to Airport ID
	$stmtSource = "SELECT airport_id from airport_detail where city='$sourceCity'";
	$sourceQuery = mysqli_query($connect, $stmtSource);
	if(mysqli_num_rows($sourceQuery) > 0){
		$row = $sourceQuery->fetch_array(MYSQLI_ASSOC);
		$sourceAirport = $row['airport_id'];
	}

	//Query to convert Destination City to Airport ID
	$stmtDest = "SELECT airport_id from airport_detail where city='$destCity'";
	$destQuery = mysqli_query($connect, $stmtDest);
	if(mysqli_num_rows($destQuery) > 0){
		$row = $destQuery->fetch_array(MYSQLI_ASSOC);
		$destAirport = $row['airport_id'];
	}

	//echo $sourceCity . " " . $destCity . " " . $startingdate . " " . $endingdate . " " . $guests . " " . $rooms . " " . $lowrange . " " . $highrange . " ";

	//Main Query to select trip details
	$stmt = "SELECT * FROM deals, hotel_availibility, hotels, flights, airlines, rooms WHERE deals.deal_price >= '$lowrange' and deals.deal_price <= '$highrange' and begin_date >= '$startingdate' and end_date <= '$endingdate' and deals.hotel_avail_id = hotel_availibility.hotel_avail_id and hotels.hotel_id = hotel_availibility.hotel_id and deals.arr_airport = '$destAirport' and deals.dept_airport = '$sourceAirport' and flights.airline_id = airlines.airline_id and rooms.room_id = hotel_availibility.room_id and remaining_seats >= $travelers and (flights.flight_id=deals.dept_flight_id or flights.flight_id=deals.return_flight_id) ORDER BY deals.deal_price ASC";

	$query = mysqli_query($connect, $stmt);

	//array to store all deals that are created
	$deals = array();
	if(mysqli_num_rows($query) > 0) //if query returns rows
	{
		$count = mysqli_num_rows($query);
		while($row = $query->fetch_array(MYSQLI_ASSOC)){ //loop through query rows and store deal information in array
		$record = array(
			"deal_price" => $row['deal_price'],
			"deal_mileage" => $row['deal_mileage'],
            "num_travelers" => $travelers,
            "flight_id" => $row['flight_id'],
            "airline_name" => $row['airline_name'],
            "flight_no" => $row['flight_no'],
            "cabin" => $row['cabin_type'],
            "dept_airport" => $row['dept_airport'],
            "dept_city" => $sourceCity,
            "arr_airport" => $row['arr_airport'],
            "arr_city" => $destCity,
            "flight_id" => $row['flight_id'],
            "dept_date" => $row['dept_date'],
            "dept_time" => $row['dept_time'],
            "arr_date" => $row['arrival_date'],
            "arr_time" => $row['arrival_time'],
            "fare_dollars" => $row['fare_dollars'],
            "fare_mileage" => $row['fare_mileage'],
            "journey_hr" => $row['journey_hr'],
            "distance" => $row['distance'],
            "remaining_seats" => $row['remaining_seats'],
            "num_rooms"=> $rooms,
            "hotel_name"=> $row['name'],
            "hotel_id"=> $row['hotel_id'],
            "hotel_address"=> $row['address'],
            "room_id"=> $row['room_id'],
            "hotel_check_in" => $row['begin_date'],
            "hotel_check_out" => $row['end_date'],
            "star" => $row['star'],
            "price" => $row['price'],
            "guests" => $travelers
			);
		array_push($deals, $record); //push deal info array to storage array (2D array now)
	}
	//store deal array just incase user submits form without selecting deal
	$_SESSION["deals"]= $deals;
	}
		else //No deals found
		{
			echo '<script language="javascript">';
			echo'alert("No Deals Found!")';
			echo '</script>';
			echo '<script type="text/javascript">location.replace("home.php")</script>';			
		}	
	mysqli_close($connect);
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
	</style>

	<script type="text/Javascript">
		function validate()
		{
			if(document.dealResults.deal.value=="")
			{
				alert("Please select a deal!");
				document.dealResults.deal.focus();
				return false;
			}
		}
	</script>

	</head>

<body>
	<?php echo get_header();?>
	<div class="container-fluid" id="background-login">
	<div class="container padding-top-10"  id="login-form">
	  <div class="panel panel-default register-panel">
			<div class="panel-heading">
				<b><font size="8px" style="font-family: 'Josefin Sans', sans-serif;">DEAL RESULTS</font><i class="fas fa-dollar-sign fa-3x" style="margin-left: 20px"></i></b>
			</div>
			<div class="panel body">
				<form name="dealResults" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validate()" method="post">
					<span>Prices shown are per person.</span>
					<br>
					<br>
					<div class="row padding-top-10">
						<div class="col-md-12"  style="overflow-x:auto;">
							<?php
							$dealCount = 1;
							$sessionDeals = $_SESSION["deals"];
								foreach($sessionDeals as $dealRecord){	
									//Flight Display-----------------------------------------------------------------------------
									echo "<table border=\"3\" height = \"120\">";
									if($dealCount %2 == 1){
										if($dealCount == 1)
											echo "<label style='font-size:20px;'><input type=\"radio\" id='deal' name='deal'  checked='checked' style='margin-right: 5px;' value='$dealCount'>Deal-$dealCount </label>";
										else{
											$nextDeal = $dealCount - 1;
											echo "<br><label style='font-size:20px;'><input type=\"radio\" id='deal' name='deal' style='margin-right: 5px;' value='$nextDeal'>Deal-$nextDeal </label>";												
										}
										
										echo "<span style='margin-left: 20px;'>" . "<strong><span style='color:#59f442; font-size:20px;'>Deal Price: $" . $dealRecord['deal_price'] ."<span style='margin-left:20px'>" . "Deal Mileage: ". $dealRecord['deal_mileage'] . "</strong></span></span></span>";
										echo '<h3>Departing Flight</h3>';
	                  echo "<tbody>";
	                  echo "<tr>";
	                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Flight #</strong></td>";
	                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Airline</strong></td>";
	                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Departing</strong></td>";
	                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Dept Date/Time</strong></td>";
	                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Arriving</strong></td>";
	                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Arrival Date/Time </strong></td>";
	                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Journey Time (hrs)</strong></td>";
	                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Distance (mi)</strong></td>";
	                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Cabin</strong></td>";
	                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Seats Remaining</strong></td>";

	                  echo  "</tr>";
	                  echo "<tr>";
	                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['flight_no'] . "</td>";
	                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['airline_name'] . "</td>";
	                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['dept_city'] . ' (' . $dealRecord['dept_airport'] . ')' . '</td>';
	                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['dept_date'] . " at " . $dealRecord['dept_time'] . "</td>";   
	                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['arr_city'] . ' (' . $dealRecord['arr_airport'] . ')' . "</td>";    
	                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['arr_date'] . " at " . $dealRecord['arr_time'] . "</td>"; 
	                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['journey_hr'] . "</td>";     
	                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['distance'] . "</td>";
	                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['cabin'] . "</td>";
	                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['remaining_seats'] . "</td>";                     
	                  echo "</tr>";
	                  echo "<tr></tr>";
	                  echo "</table>";
	                  echo "</tbody>";
	                  echo "<br>";
                }
                if($dealCount % 2 == 0){
									echo '<h3>Returning Flight</h3>';
                  echo "<tbody>";
                  echo "<tr>";
                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Flight #</strong></td>";
                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Airline</strong></td>";
                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Departing</strong></td>";
                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Dept Date/Time</strong></td>";
                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Arriving</strong></td>";
                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Arrival Date/Time </strong></td>";
                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Journey Time (hrs)</strong></td>";
                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Distance (mi)</strong></td>";
                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Cabin</strong></td>";
                  echo  "<td align = \"center\" style=\"color: white;\"><strong>Seats Remaining</strong></td>";
                  echo  "</tr>";

                  echo "<tr>";
                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['flight_no'] . "</td>";
                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['airline_name'] . "</td>";
                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['arr_city'] . ' (' . $dealRecord['dept_airport'] . ')' . '</td>';
                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['dept_date'] . " at " . $dealRecord['dept_time'] . "</td>";   
                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['dept_city'] . ' (' . $dealRecord['arr_airport'] . ')' . "</td>";    
                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['arr_date'] . " at " . $dealRecord['arr_time'] . "</td>"; 
                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['journey_hr'] . "</td>";     
                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['distance'] . "</td>";
                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['cabin'] . "</td>";
                  echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['remaining_seats'] . "</td>";                     
                  echo "</tr>";
                  echo "</table>";
                  echo "</tbody>";

									//Hotel Display--------------------------------------------------------------------------------
									echo "<table border=\"3\" height = \"120\">";
									echo '<h3>Hotel</h3>';
									echo "<tbody>";
									echo "<tr>";
									echo	"<td align = \"center\" style=\"color: white;\"><strong>Hotel</strong></td>";
									echo	"<td align = \"center\" style=\"color: white;\"><strong>Room Type</strong></td>";
									echo	"<td align = \"center\" style=\"color: white;\"><strong>Location</strong></td>";
									echo	"<td align = \"center\" style=\"color: white;\"><strong>Check-In</strong></td>";
									echo	"<td align = \"center\" style=\"color: white;\"><strong>Check-Out</strong></td>";
									echo	"<td align = \"center\" style=\"color: white;\"><strong>Star Rating</strong></td>";
									echo	"<td align = \"center\" style=\"color: white;\"><strong>Number of Rooms</strong></td>";
									echo	"</tr>";
									echo "<tr>"; 
									echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['hotel_name'] . "</td>"; 		//Hotel Name
									echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['room_id'] . "</td>"; 			//Room Type					
									echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['hotel_address'] . "</td>"; 	//Location
									echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['hotel_check_in'] . "</td>"; 		//Check-In
									echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['hotel_check_out'] . "</td>";		//Check-Out
									echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['star'] . "</td>";				//Star Rating
									echo "<td align = \"center\" style=\"color: white;\">" . $dealRecord['num_rooms'] . "</td>";			//Number of Rooms
									echo "</tr>";
									
									echo "</table>";
									echo "</tbody>";
								}
										$dealCount++;
									
								}
							?>
						</div> 
					</div>

			<br><br>
			<div class="row padding-top-10">
			<input type="hidden" name="selected-deal" value="true">
				<div class="col-sm-offset-5 col-sm-10">
					<button type="submit" data-toggle="tooltip" data-placement="right" title="REGISTER!" class="btn btn-primary">SUBMIT</button>
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
