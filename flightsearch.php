<?php
  include 'utility.php';
  //include 'home.php';
  $output = array();
  $output1 = array();
  $count=0;
  $airline;

  if(isset($_POST['selected-flight'])) //submission of selected flights
  {
    echo "in selected flight";
    $bool = isset($_SESSION['flightandhotel']);
    echo $bool;

    if(!empty($_POST['deptFlight'])){
      //get deptFlight counter number from form
      $deptflightNum = $_POST['deptFlight'];
      $deptflightNum--;

      //store selected departure flignt
      $selectedDeptFlight = array();
      $selectedDeptFlight = $_SESSION['deptFlights'][$deptflightNum];
      $_SESSION['deptFlightSelection'] = $selectedDeptFlight;
    }
    if(!empty($_POST['returnFlight'])){
      //store selected return flight
      $returnflightNum = $_POST['returnFlight'];
      $returnflightNum--;

      $selectedReturnFlight = array();
      $selectedReturnFlight = $_SESSION['returnFlights'][$returnflightNum];
      $_SESSION['returnFlightSelection'] = $selectedReturnFlight;
      //print_r($_SESSION['deptFlightSelection']);
      //print_r($_SESSION['returnFlightSelection']);
    }
    else
       unset($_SESSION['returnFlightSelection']);

    if(isset($_SESSION['user']) && !isset($_SESSION['flightandhotel'])){
      header('Location: confirmation.php');
    }
    else if(isset($_SESSION['flightandhotel'])){
      header('Location: hotelsearch.php');
    }
    else{
      $_SESSION['login_required'] = true;
      //echo "flight and hotel = " . $_SESSION['flightandhotel'];
      echo '<script type="text/javascript">alert("You must login to continue!")</script>';
      echo '<script type="text/javascript">location.replace("login.php")</script>';
    }
  }


  if(isset($_POST['flight-submit']) || (isset($_POST['hotel-flight-submit'])) ) { //submission from home page
    //if user chose  hotel + flight
    if(isset($_POST['hotel-flight-submit'])){
      $_SESSION['flightandhotel'] = true;
      echo "storing passHotel Session variable";
      $_SESSION['passHotel'] = array(
        'destination' => $_POST['destination'],
        'check_in'=> $_POST['checkIn'],
        'check_out' => $_POST['checkOut'],
        'guests' => $_POST['guests'],
        'rooms' => $_POST['rooms']
        );
     // print_r($_SESSION['passHotel']);
    }
    else{ //unset hotel because we only want flights
      unset($_SESSION["hotelSelection"]);
    }
    //echo $_SESSION['flightandhotel'];
    $connect = mysqli_connect("localhost","root","","survey_db_2018") or die('Error Connecting To Databse');
    unset($_SESSION['returnFlights']);
    unset($_SESSION['deptFlights']);

    //get values from form
    $source = $_POST['source'];
    $destination = $_POST['fdestination'];
    $dd_date = $_POST['departureDate'];
    $rr_date = $_POST['returnDate'];
    $airline = $_POST['airline'];
    $travelers = $_POST['travelers'];
    $class = $_POST['class'];
  
    //get airline_id from airline name
    $airlineQuery = (mysqli_query($connect,"SELECT airline_id from airlines where airline_name = '$airline'"));
    $count = mysqli_num_rows($airlineQuery); 
    $row = 0;

    if($count > 0){
      $row = mysqli_fetch_assoc($airlineQuery);
      $airline_id = $row['airline_id'];
    }   

    //get source airport_id from city name
    $airportSourceQuery = (mysqli_query($connect,"SELECT airport_id from airport_detail where city = '$source'"));
    $count = mysqli_num_rows($airportSourceQuery); 

    if($count > 0){
      $row = mysqli_fetch_array($airportSourceQuery);
      $sourceID = $row['airport_id'];
    }

    //get destination airport_id from city name
    $airportDestQuery = (mysqli_query($connect,"SELECT airport_id from airport_detail where city = '$destination'"));
    $count = mysqli_num_rows($airportDestQuery); 

    if($count > 0){
      $row = mysqli_fetch_array($airportDestQuery);
      $destID = $row['airport_id'];
    }   

    //departing flight query
    $deptFlightQuery = mysqli_query($connect,"SELECT * FROM flights WHERE dept_airport='$sourceID' AND arr_airport='$destID' AND dept_date='$dd_date' AND cabin_type='$class' and remaining_seats >= $travelers and airline_id = '$airline_id'") or die("Could not search flights");
    
    $count = mysqli_num_rows($deptFlightQuery);

    if($count == 0){
      echo '<script type="text/javascript">alert("No Flights Match Criteria Entered!")</script>';
      echo '<script type="text/javascript">location.replace("home.php")</script>';

    }
    else {
      $deptFlights = array();
        //add a departing flight record
        while($row = $deptFlightQuery->fetch_array(MYSQLI_ASSOC)) {
          //print_r($row);
          $record = array(
            "num_travelers" => $travelers,
            "flight_id" => $row['flight_id'],
            "airline_name" => $airline,
            "flight_no" => $row['flight_no'],
            "cabin" => $class,
            "dept_airport" => $row['dept_airport'],
            "dept_city" => $source,
            "arr_airport" => $row['arr_airport'],
            "arr_city" => $destination,
            "flight_id" => $row['flight_id'],
            "dept_date" => $row['dept_date'],
            "dept_time" => $row['dept_time'],
            "arr_date" => $row['arrival_date'],
            "arr_time" => $row['arrival_time'],
            "fare_dollars" => $row['fare_dollars'],
            "fare_mileage" => $row['fare_mileage'],
            "journey_hr" => $row['journey_hr'],
            "distance" => $row['distance'],
            "remaining_seats" => $row['remaining_seats']
          );

          array_push($deptFlights, $record);
            
        }
        $_SESSION["deptFlights"] = $deptFlights;
    }

    if(isset($_POST['returnDate'])){
      $returnFlightQuery = mysqli_query($connect,"SELECT * FROM flights WHERE dept_airport='$destID' AND arr_airport='$sourceID' AND arrival_date='$rr_date' AND cabin_type='$class' and remaining_seats >= $travelers and airline_id = '$airline_id'") or die("Could not search flights");
      $count = mysqli_num_rows($returnFlightQuery);

      if($count == 0){
          $output[] = 'There was no search results';
      }
      else {
        $returnFlights = array();
          //add a returning flight record
          while($row = $returnFlightQuery->fetch_array(MYSQLI_ASSOC)) {
            //print_r($row);
            $record = array(
              "num_travelers" => $travelers,
              "flight_id" => $row['flight_id'],
              "airline_name" => $airline,
              "flight_no" => $row['flight_no'],
              "cabin" => $class,
              "dept_airport" => $row['dept_airport'],
              "dept_city" => $destination,
              "arr_airport" => $row['arr_airport'],
              "arr_city" => $source,
              "flight_id" => $row['flight_id'],
              "dept_date" => $row['dept_date'],
              "dept_time" => $row['dept_time'],
              "arr_date" => $row['arrival_date'],
              "arr_time" => $row['arrival_time'],
              "fare_dollars" => $row['fare_dollars'],
              "fare_mileage" => $row['fare_mileage'],
              "journey_hr" => $row['journey_hr'],
              "distance" => $row['distance'],
              "remaining_seats" => $row['remaining_seats']
            );

            array_push($returnFlights, $record);
              
          }
          $_SESSION["returnFlights"] = $returnFlights;

        }
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

  </head>

<body>
  <?php echo(get_header());?>


<div id="background-login">
  <div id="search" class="container-fluid">
    <div class="container">     
<!--Flight Search ==================================================================================-->
      <div class="tab-content">
        <div id="flights" class="tab-pane fade in active">
          <div class="panel panel-default home-panel">
            <div class="panel-body">
              <div class="page-header" style="margin-top:5px;">
                <center><b><font id="formhead">SEARCH FOR A FLIGHT</font></b><i class="fa fa-plane fa-3x" style="margin-left: 20px"></i></center>
              </div>
              <div class="panel body">
                <form name="flightResults" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <br>
                  <div class="row padding-top-10">
                    <div class="col-md-12"  style="overflow-x:auto;">
                      <?php
                        $deptFlightCount = 1;
                        $sessionFlights = $_SESSION["deptFlights"];
                        echo '<h1>Departing Flights</h1>';
                        foreach($sessionFlights as $flightRecord){  
                          //Departing Flight Display-----------------------------------------------------------------------------
                          echo "<table border=\"3\" height = \"120\">";
                          if($deptFlightCount == 1)
                            echo "<label style='font-size:20px;'><input type=\"radio\" id='deptFlight' name='deptFlight'  checked='checked' style='margin-right: 5px;' value='$deptFlightCount'>Flight-$deptFlightCount </label>";
                          else
                            echo "<label style='font-size:20px;'><input type=\"radio\" id='deptFlight' name='deptFlight' style='margin-right: 5px;' value='$deptFlightCount'>Flight-$deptFlightCount </label>";                            
                          echo "<span style='margin-left: 20px;'>" . "<strong><span style='color:#59f442; font-size:20px;'>Price: $" . $flightRecord['fare_dollars'] ."<span style='margin-left:20px'>" . "Mileage Price: ". $flightRecord['fare_mileage'] . "</strong></span></span></span>";
                          echo "<input type='radio' id='deptFlight' name='deptFlight' style='display: none;' value=''>";
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
                          echo  "<td align = \"center\" style=\"color: white;\"><strong>Price</strong></td>";
                          echo  "<td align = \"center\" style=\"color: white;\"><strong>Mileage Price</strong></td>";
                          echo  "<td align = \"center\" style=\"color: white;\"><strong>Seats Remaining</strong></td>";

                          echo  "</tr>";
                          echo "<tr>";
                          echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['flight_no'] . "</td>";
                          echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['airline_name'] . "</td>";
                          echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['dept_city'] . ' (' . $flightRecord['dept_airport'] . ')' . '</td>';
                          echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['dept_date'] . " at " . $flightRecord['dept_time'] . "</td>";   
                          echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['arr_city'] . ' (' . $flightRecord['arr_airport'] . ')' . "</td>";    
                          echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['arr_date'] . " at " . $flightRecord['arr_time'] . "</td>"; 
                          echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['journey_hr'] . "</td>";     
                          echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['distance'] . "</td>";
                          echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['cabin'] . "</td>";
                          echo "<td align = \"center\" style=\"color: white;\">" . "$" . $flightRecord['fare_dollars'] . "</td>";                   
                          echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['fare_mileage'] . "</td>";
                          echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['remaining_seats'] . "</td>";                    
                          echo "</tr>";
                          echo "<tr></tr>";
                          echo "</table>";
                          echo "</tbody>";
                          echo "<br>";

                          $deptFlightCount++;
                        }

                      
                        echo "<h1>Returning Flights</h1>";                    
                        $returnFlightCount = 1;
                        if(isset($_SESSION["returnFlights"])){
                          $sessionFlights = $_SESSION["returnFlights"];
                          foreach($sessionFlights as $flightRecord){  
                            //Returning Flight Display-----------------------------------------------------------------------------
                            echo "<table border=\"3\" height = \"120\">";
                            if($returnFlightCount == 1)
                              echo "<label style='font-size:20px;'><input type=\"radio\" id='returnFlight' name='returnFlight'  checked='checked' style='margin-right: 5px;' value='$returnFlightCount'>Flight-$returnFlightCount </label>";
                            else
                             echo "<label style='font-size:20px;'><input type=\"radio\" id='returnFlight' name='returnFlight' style='margin-right: 5px;' value='$returnFlightCount'>Flight-$returnFlightCount </label>";
                             echo "<span style='margin-left: 20px;'>" . "<strong><span style='color:#59f442; font-size:20px;'>Price: $" . $flightRecord['fare_dollars'] ."<span style='margin-left:20px'>" . "Mileage Price: ". $flightRecord['fare_mileage'] . "</strong></span></span></span>";
                           // echo "<input type='radio' id='returnFlight' name='returnFlight' style='display: none;' value=''>";
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
                            echo  "<td align = \"center\" style=\"color: white;\"><strong>Price</strong></td>";
                            echo  "<td align = \"center\" style=\"color: white;\"><strong>Mileage Price</strong></td>";
                            echo  "<td align = \"center\" style=\"color: white;\"><strong>Seats Remaining</strong></td>";

                            echo  "</tr>";
                            echo "<tr>";
                            echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['flight_no'] . "</td>";
                            echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['airline_name'] . "</td>";
                            echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['dept_city'] . ' (' . $flightRecord['dept_airport'] . ')' . '</td>';
                            echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['dept_date'] . " at " . $flightRecord['dept_time'] . "</td>";   
                            echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['arr_city'] . ' (' . $flightRecord['arr_airport'] . ')' . "</td>";    
                            echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['arr_date'] . " at " . $flightRecord['arr_time'] . "</td>"; 
                            echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['journey_hr'] . "</td>";     
                            echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['distance'] . "</td>";
                            echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['cabin'] . "</td>";
                            echo "<td align = \"center\" style=\"color: white;\">" . "$" . $flightRecord['fare_dollars'] . "</td>";                   
                            echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['fare_mileage'] . "</td>"; 
                            echo "<td align = \"center\" style=\"color: white;\">" . $flightRecord['remaining_seats'] . "</td>";                  
                            echo "</tr>";
                            echo "<tr></tr>";
                            echo "</table>";
                            echo "</tbody>";
                            echo "<br>";

                            $returnFlightCount++;
                          }
                        }
                      ?>
                    </div> 
                  </div>
                  <br><br>
                <div class="row padding-top-10">
                  <input type="hidden" name="selected-flight" value="true">
                <div class="col-sm-offset-5 col-sm-10">
                  <button type="submit" data-toggle="tooltip" data-placement="right" title="REGISTER!" class="btn btn-primary">SUBMIT</button>
                </div>        
              </div>        
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
  <?php echo get_footer();?>
</body>
</html> 