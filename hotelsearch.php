<?php
  include 'utility.php';
  //include 'home.php';
  $output = array();
  $output1 = array();
  $count=0;
  $order;
  $sort;
  $sortStmt;
  $sortRequest = 0;

  //get variables from URL
  if(isset($_GET['sortRequest'])){
    $sortRequest = $_GET['sortRequest'];
  
    if(isset($_GET['order'])){
      $order = $_GET['order'];
    }

    if(isset($_GET['sort'])){
      $sort = $_GET['sort'];
    }

    else{
      $sort = 'ASC';
    }
  }


  if(isset($_POST['selected-hotel'])) //submission of selected hotel
  {
    //get hotel counter number from form
    $hotelNum = $_POST['hotel'];
    $hotelNum--;

    //store selected departure flignt
    $selectedHotel = array();
    $selectedHotel = $_SESSION['hotels'][$hotelNum];
    $_SESSION['hotelSelection'] = $selectedHotel;
    //print_r($_SESSION['hotelSelection']);


    if(isset($_SESSION['user'])){
      header('Location: confirmation.php');
    }
    else{
      $_SESSION['login_required'] = true;
      echo '<script type="text/javascript">alert("You must login to continue!")</script>';
      echo '<script type="text/javascript">location.replace("login.php")</script>';
    }
  }

  if(isset($_POST['hotels-submit']) || isset($_SESSION['flightandhotel']) || isset($sortRequest)) { //submission from home page
    $connect = mysqli_connect("localhost","root","","survey_db_2018") or die('Error Connecting To Databse');
    if (isset($_SESSION['flightandhotel'])){
      echo "Flight and hotel set!";
     // print_r($_SESSION['passHotel']);
      $passedHotel = $_SESSION['passHotel'];
      $destination = $passedHotel['destination'];
      echo $destination;
      $check_in = $passedHotel['check_in'];
      $check_out = $passedHotel['check_out'];
      $guests = $passedHotel['guests'];
      $rooms = $passedHotel['rooms'];

      $_SESSION['hotelDetails'] = array(
        'rooms' => $rooms,
        'destination' => $destination,
        'check_in' => $check_in,
        'check_out' => $check_out,
        'guests' => $guests
        );
      //$price = $passHotel['price'];
    }
    //get values from form
    //$source = $_POST['source'];
    else if($sortRequest!=1){
      $destination = $_POST['destination'];
      $check_in = $_POST['checkIn'];
      $check_out = $_POST['checkOut'];
      $guests = $_POST['guests'];
      $rooms = $_POST['rooms'];
      $_SESSION['hotelDetails'] = array(
        'rooms' => $rooms,
        'destination' => $destination,
        'check_in' => $check_in,
        'check_out' => $check_out,
        'guests' => $guests
        );
    }

    //hotel query
    $hotelDetails = array();
    $hotelDetails = $_SESSION['hotelDetails'];

    $hotelDestination = $hotelDetails['destination'];
    if($sortRequest == 1){
       $hotelStmt =  "SELECT * FROM hotels, hotel_availibility WHERE address LIKE '%$hotelDestination%' and hotels.hotel_id=hotel_availibility.hotel_id order by $order $sort";
     }
    else
      $hotelStmt = "SELECT * FROM hotels, hotel_availibility WHERE address LIKE '%$hotelDestination%' and hotels.hotel_id=hotel_availibility.hotel_id";

    $hotelQuery = mysqli_query($connect,$hotelStmt) or die("Could not search hotels");
    $count = mysqli_num_rows($hotelQuery);
    //print($count);
    if($count == 0){
      echo '<script type="text/javascript">alert("No Hotels Match Criteria Entered!")</script>';
      echo '<script type="text/javascript">location.replace("home.php")</script>';

    }
    else {
      $hotels = array();
      //add hotel record
      // while($row = $hotelQuery->fetch_array(MYSQLI_ASSOC)) {
      //   $id = $row["hotel_id"];

        // if($sortRequest == 1){
        //   echo "order= " . $order;
        //   echo "sort= " . $sort;
        //   $sql = "SELECT * FROM hotel_availibility WHERE hotel_id='$id' SORT BY $order $sort";
       // }
       // else
         // $sql = "SELECT * FROM hotel_availibility WHERE hotel_id='$id'";


        //$result = mysqli_query($connect, $sql) or die("Could not search rooms");
        //$numResults=mysqli_num_rows($result);
        if( $count > 0){

          while($roomAvailable = $hotelQuery->fetch_array(MYSQLI_ASSOC)) {
              //print_r($roomAvailable);
              $record = array(
                "num_rooms"=>$hotelDetails['rooms'],
                "hotel_id"=>$roomAvailable["hotel_id"],
                "hotel_name"=>$roomAvailable["name"],
                "hotel_address"=>$roomAvailable["address"],
                "room_id"=>$roomAvailable["room_id"],
        		    "hotel_check_in"=>$hotelDetails['check_in'],
                "hotel_check_out"=>$hotelDetails['check_out'],
                "guests" => $hotelDetails['guests'],
                "price"=>$roomAvailable["price"],
                "star" =>$roomAvailable["star"]
              );
              array_push($hotels, $record);
            }
          }

        //}
        $_SESSION["hotels"] = $hotels;
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
<!--Hotel Search ==================================================================================-->
      <div class="tab-content">
        <div id="hotels" class="tab-pane fade in active">
          <div class="panel panel-default home-panel">
            <div class="panel-body">
              <div class="page-header" style="margin-top:5px;">
                <center><b><font id="formhead">SEARCH FOR A HOTEL</font></b><i class="fa fa-plane fa-3x" style="margin-left: 20px"></i></center>
              </div>
              <div class="panel body">
                <form name="hotelResults" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <br>
                  <div class="row padding-top-10">
                    <div class="col-md-12"  style="overflow-x:auto;">
                      <?php
                        $hotelCount = 1;
                        $sessionHotels = $_SESSION["hotels"];
                        $sort = 'DESC';

                        if(isset($_GET['sort'])){
                          $sort = $_GET['sort'];
                         if($sort == 'DESC')
                            $sort = 'ASC';
                         else if($sort == 'ASC')
                            $sort = 'DESC';
                         else if($sort != "DESC" && $sort != "ASC")
                            $sort = 'DESC';
                      }
                        
                        echo '<h1>Hotels</h1>';
                        foreach($sessionHotels as $hotelRecord){
                          //Departing Flight Display-----------------------------------------------------------------------------
                          echo "<table border=\"3\" height = \"120\">";
                          if($hotelCount == 1)
                            echo "<label style='font-size:20px;'><input type=\"radio\" id='hotel' name='hotel'  checked='checked' style='margin-right: 5px;' value='$hotelCount'>Hotel-$hotelCount </label>";
                          else
                            echo "<label style='font-size:20px;'><input type=\"radio\" id='hotel' name='hotel' style='margin-right: 5px;' value='$hotelCount'>Hotel-$hotelCount </label>";
                          echo "<span style='margin-left: 20px;'>" . "<strong><span style='color:#59f442; font-size:20px;'>Price: $" . $hotelRecord['price'] ."<span style='margin-left:20px'>"  . "</strong></span></span></span>";
                          echo "<input type='radio' id='hotel' name='hotel' style='display: none;' value=''>";
                          echo "<tbody>";
                          echo "<tr>";
            							echo '<td align = "center" style="color: white;"><p><strong>Rooms</strong></p></td>';
            							echo "<td align = \"center\" style=\"color: white;\"><a href=\"hotelSearch.php?sort=$sort&&order=name&&sortRequest=1\"><strong>Hotel</strong></a</td>";
            							echo '<td align = "center" style="color: white;"><strong>Room Type</strong></td>';
            							echo '<td align = "center" style="color: white;"><strong>Check-in</strong></td>';
            							echo '<td align = "center" style="color: white;"><strong>Check-out</strong></td>';
            							echo "<td align = \"center\" style=\"color: white;\"><a href=\"hotelSearch.php?sort=$sort&&order=price&&sortRequest=1\"><strong>Per Night</strong></a</td>";
                          echo "<td align = \"center\" style=\"color: white;\"><a href=\"hotelSearch.php?sort=$sort&&order=star&&sortRequest=1\"><strong>Star Rating</strong></a></td>";
            							echo '</tr>';

                          echo "<tr>";
            							echo "<td align = \"center\" style=\"color: white;\">" . $hotelRecord["num_rooms"] . "</td>"; 	/*<!-- Number Travelers	-->*/
            							echo "<td align = \"center\" style=\"color: white;\">" . $hotelRecord["hotel_name"] . " at " . $hotelRecord["hotel_address"]. "</td>"; 		/*<!-- Hotel Name    	-->*/
            							echo "<td align = \"center\" style=\"color: white;\">" . $hotelRecord["room_id"] . "</td>";
            							echo "<td align = \"center\" style=\"color: white;\">" . $hotelRecord["hotel_check_in"] . "</td>"; 	/*<!-- Hotel Check-in      -->*/
            							echo "<td align = \"center\" style=\"color: white;\">" . $hotelRecord["hotel_check_out"] . "</td>"; /*<!-- Hotel Check-out   -->*/
            							echo "<td align = \"center\" style=\"color: white;\">" . "$" . $hotelRecord["price"] . "</td>";
                          echo "<td align = \"center\" style=\"color: white;\">" .  $hotelRecord["star"] . "</td>";
            							echo "</tr>";
                          echo "<tr></tr>";
                          echo "</table>";
                          echo "</tbody>";
                          echo "<br>";

                          $hotelCount++;
                        }


                      ?>
                    </div>
                  </div>
                  <br><br>
                <div class="row padding-top-10">
                  <input type="hidden" name="selected-hotel" value="true">
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
