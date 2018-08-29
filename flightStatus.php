<?php 
include 'utility.php';
$statusresults = ''; 
$flightnumber = '';
$airline = 'false';
$deptdate = '';

if(isset($_POST['flight-status-submit']))
{

	$connect = mysqli_connect("localhost","root","","survey_db_2018") or die('Error Connecting To Databse');
	$flightnumber = $_POST['flightnumber'];
	$airline = $_POST['airline'];
	$deptdate = $_POST['departuredate'];
	$stmt = "SELECT DISTINCT flight_status_id from flights, airlines where flight_no = $flightnumber and flights.airline_id = airlines.airline_id and airline_name = '$airline' and dept_date = '$deptdate';";
	$query = mysqli_query($connect, $stmt);
	if(mysqli_num_rows($query) > 0)
	{
		$row = $query->fetch_array(MYSQLI_ASSOC);
		$flightstatus = $row["flight_status_id"];
		$statusresults = <<<HTML
		<html>
			<body>
				<table border="3" height="120">
					<tbody>
						<tr>
							<td align = "center" style="color: white;"><strong>Flight Number</strong></td>
							<td align = "center" style="color: white;"><strong>Airline</strong></td>
							<td align = "center" style="color: white;"><strong>Departure Date</strong></td>
							<td align = "center" style="color: white;"><strong>Status</strong></td>
						</tr>
						<tr>					     
							<td align = "center" style="color: white;">$flightnumber</td> 		 <!-- flight number    -->
							<td align = "center" style="color: white;">$airline</td>   		 <!-- Airline Name  -->
							<td align = "center" style="color: white;">$deptdate</td>   		 <!-- departure date   -->
							<td align = "center" style="color: white;">$flightstatus</td>   		 <!-- flight status  -->
						</tr>

					</tbody>
				</table>
				<br><br>
			</body>
		</html>

HTML;
	}
		else
		{
				echo '<script language="javascript">';
				echo'alert("Flight Not Found!")';
				echo '</script>';			
		}	
	
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
			if(document.flightSearch.flightnumber.value=="")
			{
				alert("Please enter flight number");
				document.flightSearch.flightnumber.focus();
				return false;
			}
			if(document.flightSearch.airline.value=="")
			{
				alert("Please enter an airline");
				document.flightSearch.airline.focus();
				return false;
			}
			if(document.flightSearch.departuredate.value=="")
			{
				alert("Please enter your departuredate");
				document.flightSearch.departuredate.focus();
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
				<b><font size="8px" style="font-family: 'Josefin Sans', sans-serif;">FLIGHT STATUS</font><i class="fas fa-calendar-alt fa-3x" style="margin-left: 20px"></i></b>
			</div>
			<div class="panel body">
				<form name="flightSearch" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validate()" method="post">
					<br>
					<div class="row padding-top-10">
						<div class="col-md-8">
							<?php echo $statusresults?>
						</div> 
					</div>
					<label class="control-label padding-top-10">Flight Number:</label>
					<div class="row padding-top-10">
						<div class="col-md-3">
							<input type="text" class="form-control" id="flightnumber" name="flightnumber" placeholder="Enter Flight Number"/>
						</div>
					</div>
					<br>
					<label class="control-label padding-top-10">Airline:</label>
					<div class="row">
						<div class="col-md-3">
               <select id="flight" name="airline" class="form-control" placeholder="">
                 <option value="" id="airline" name="airline" selected disabled>Select Your Airline</option>
                 <option>Delta</option>
                 <option>United</option>
                 <option>Southwest</option>
                 <option>Frontier</option>
               </select>
            </div>
          </div>
					<br>
					<label class="control-label padding-top-10">Departure Date:</label>
					<div class="row">
						<div class="col-md-3">
							<input type="Date" id="departuredate" class="form-control" name="departuredate">
						</div>
					</div>
			<br><br>
			<div class="row padding-top-10">
			<input type="hidden" name="flight-status-submit" value="true">
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

