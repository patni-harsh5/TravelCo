<?php
  include 'utility.php';
  unset($_SESSION['flightandhotel']);
  unset($_SESSION['deptFlightSelection']);
  unset($_SESSION['returnFlightSelection']);
  unset($_SESSION['hotelSelection']);
   unset($_SESSION['deals']);
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
</head>
<style>
</style>
  <script type="text/Javascript">
    function validateFlight()
    {
      if(document.flightForm.source.value == "")
      {
        alert("Please select a source!");
        return false;
      }

      if(document.flightForm.destination.value == "")
      {
        alert("Please select a destination!");
        return false;
      }

      if(document.flightForm.departureDate.value == "")
       {
         alert("Please select a departure date!");
         return false;
       }

      if(document.flightForm.returnDate.value != "")
       {
        if(document.flightForm.returnDate.value < document.flightForm.departureDate.value){
         alert("Please select a return date after your departure!");
         return false;
        }
       }

      if(document.flightForm.airline.value == "")
       {
         alert("Please select an airline!");
         return false;
       }

      if(document.flightForm.class.value == "")
       {
         alert("Please select a cabin class!");
         return false;
       }
      if(document.flightForm.travelers.value == 0)
       {
         alert("Please enter number of passengers!");
         return false;
       }

    }
  </script>

    <script type="text/Javascript">
    function validateDeal()
    {
      if(document.dealForm.source.value == "")
      {
        alert("Please select a source!");
        return false;
      }

      if(document.dealForm.destination.value == "")
      {
        alert("Please select a destination!");
        return false;
      }

      if(document.dealForm.startingDate.value == "")
       {
         alert("Please select a starting date!");
         return false;
       }

       if(document.dealForm.endingDate.value == "")
       {
         alert("Please select an ending date!");
         return false;
       }      

      if(document.dealForm.endingDate.value != "")
       {
        if(document.dealForm.endingDate.value < document.dealForm.startingDate.value){
         alert("Please select an ending date after the starting date!");
         return false;
        }
       }

      if(document.dealForm.travelers.value == 0)
       {
         alert("Please enter number of travelers!");
         return false;
       }

      if(document.dealForm.rooms.value == 0)
       {
         alert("Please enter number of rooms!");
         return false;
       }
    }
  </script>

  <script type="text/Javascript">
    function validateFlightHotel()
    {
      if(document.flightHotelForm.source.value == "")
      {
        alert("Please select a source!");
        return false;
      }

      if(document.flightHotelForm.fdestination.value == "")
      {
        alert("Please select a destination!");
        return false;
      }

      if(document.flightHotelForm.departureDate.value == "")
       {
         alert("Please select a departure date!");
         return false;
       }

      if(document.flightHotelForm.returnDate.value != "")
       {
        if(document.flightHotelForm.returnDate.value < document.flightHotelForm.departureDate.value){
         alert("Please select a return date after your departure!");
         return false;
        }
       }

      if(document.flightHotelForm.airline.value == "")
       {
         alert("Please select an airline!");
         return false;
       }

      if(document.flightHotelForm.class.value == "")
       {
         alert("Please select a cabin class!");
         return false;
       }
      if(document.flightHotelForm.travelers.value == 0)
       {
         alert("Please enter number of passengers!");
         return false;
       }
      if(document.flightHotelForm.destination.value == "")
       {
         alert("Please enter hotel destination!");
         return false;
       }
      if(document.flightHotelForm.checkIn.value == "")
       {
         alert("Please enter check-in date!");
         return false;
       }

      if(document.flightHotelForm.checkOut.value == "")
       {
         alert("Please enter check-out date!");
         return false;
       }

      if(document.flightHotelForm.checkOut.value < document.flightHotelForm.checkIn.value){
        alert("Please select a check-out date after your check-in date!");
        return false;
      }
       

      if(document.flightHotelForm.rooms.value == 0)
       {
         alert("Please enter number of rooms!");
         return false;
       }

      if(document.flightHotelForm.guests.value == 0)
       {
         alert("Please enter number of guests!");
         return false;
       }

    }
  </script>

  <script type="text/Javascript">
    function validateHotel()
    {
      if(document.hotelForm.destination.value == "")
       {
         alert("Please enter hotel destination!");
         return false;
       }
      if(document.hotelForm.checkIn.value == "")
       {
         alert("Please enter check-in date!");
         return false;
       }

      if(document.hotelForm.checkOut.value == "")
       {
         alert("Please enter check-out date!");
         return false;
       }
      if(document.hotelForm.checkOut.value < document.hotelForm.checkIn.value){
        alert("Please select a check-out date after your check-in date!");
        return false;
      }
      if(document.hotelForm.guests.value == 0)
       {
         alert("Please enter number of guests!");
         return false;
       }
      if(document.hotelForm.rooms.value == 0)
       {
         alert("Please enter number of rooms!");
         return false;
       }
    }
  </script>
</head>
<body>
  <?php echo(get_header());?>


<div id="background-home">
  <div id="search" class="container-fluid">
    <div class="container">
      <ul class="nav nav-pills">
        <li class="active"><a data-toggle="pill" href="#flights">Flights</a></li>
         <li><a data-toggle="pill" href="#hotel">Hotel</a></li>
        <li><a data-toggle="pill" href="#flight-hotel">Flight + Hotel</a></li>
        <li><a data-toggle="pill" href="#deals">Deals</a></li>
      </ul>
<!--Flight Search ==================================================================================-->
      <div class="tab-content">
          <div id="flights" class="tab-pane fade in active">
            <div class="panel panel-default home-panel">
              <div class="panel-body">
                <div class="page-header" style="margin-top:5px;">
                  <center><b><font id="formhead">SEARCH FOR A FLIGHT</font></b><i class="fa fa-plane fa-3x" style="margin-left: 20px"></i><center>
                </div>
                <form class="form-inline" name="flightForm" id="flightForm" method="post" action="flightsearch.php" onsubmit="return validateFlight()">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="source">Source</label>
                            <select class="form-control" id="source" name="source">
                              <option value=""  selected disabled>Enter Departure City</option>
                              <option>Austin</option>
                              <option>Houston</option>
                              <option>Las Vegas</option>
                              <option>Honolulu</option>
                              <option>Tampa</option>
                              <option>Los Angeles</option>
                              <option>Pittsburgh</option>
                              <option>London</option>
                            </select>
                     </div>
                    </div>

                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="">Destination</label>
                        <select id="fdestination" name="fdestination" class="form-control" placeholder="">
                          <option value="" id="fdestination" name="fdestination" selected disabled>Enter Destination City</option>
                          <option>Austin</option>
                          <option>Houston</option>
                          <option>Las Vegas</option>
                          <option>Honolulu</option>
                          <option>Tampa</option>
                          <option>Los Angeles</option>
                          <option>Pittsburgh</option>
                          <option>London</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Departure Date</label>
                        <input type="Date" id="departureDate" class="form-control" name="departureDate">
                      </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Return Date</label>
                        <input type="Date" id="returnDate" class="form-control" name="returnDate">
                      </div>
                    </div>
                  </div>
                  </br>
                  <div class="row">
                    <div class=" col-md-3">
                      <div class="form-group">
                        <label for="">Select Your Airline</label>
                        <select id="airline" name="airline" class="form-control" placeholder="">
                          <option value=""id="airline" name="airline" selected disabled>Select Your Airline</option>
                          <option>Delta</option>
                          <option>United</option>
                          <option>Southwest</option>
                          <option>Frontier</option>
                        </select>
                      </div>
                    </div> 
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="">Cabin Class</label>
                        <label class="radio-inline">
                          <input type="radio" name="class" id="class" value="economy">  Economy
                        </label>
                        <br>
                        <label class="radio-inline" style="margin-left: 0">
                         <input type="radio" name="class" id="class"  value="first">First
                        </label>
                      </div>
                    </div> 

                    <div class="col-sm-offset-1 col-md-2">
                      <div class="form-group">
                        <label for="At">Number of Travelers</label>
                       <input name="travelers" id="travelers" type="number" step="any" value="0" style="color: black;"> 
                      </div>
                    </div>
                  </div>
                  <br><br><br><br><br><br><br>
                  <div class="row">
                    <div class="col-sm-offset-5 col-sm-10">
                      <input type="hidden" name="flight-submit" value="true">
                        <button type="submit" data-toggle="tooltip" data-placement="right" title="Search Flights" class="btn btn-primary">Search Flights</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
 <!--Flight + Hotel Search =============================================================================================-->
          <div id="flight-hotel" class="tab-pane fade">
            <div class="panel panel-default home-panel">
              <div class="panel-body">
                <div class="page-header" style="margin-top:5px;">
                  <center><b><font id="formhead">SEARCH FOR A FLIGHT + HOTEL</font></b></center>
                  <center><i class="fa fa-plane fa-3x" style="margin-left: 20px"></i><i class="fa fa-plus fa-2x" style="margin-left: 20px"></i> <i class="fa fa-hotel fa-3x" style="margin-left: 20px"></i></center>
                </div>
                <form class="form-inline" name="flightHotelForm" id="flightHotelForm" method="post" action="flightsearch.php" onsubmit="return validateFlightHotel()">
                <h3>Flight Information:</h3>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="source">Source</label>
                            <select class="form-control" id="source" name="source">
                              <option value=""  selected disabled>Enter Departure City</option>
                              <option>Austin</option>
                              <option>Houston</option>
                              <option>Las Vegas</option>
                              <option>Honolulu</option>
                              <option>Tampa</option>
                              <option>Los Angeles</option>
                              <option>Pittsburgh</option>
                              <option>London</option>
                            </select>
                     </div>
                    </div>

                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="">Destination</label>
                        <select id="fdestination" name="fdestination" class="form-control" placeholder="">
                          <option value = "" selected disabled>Enter Destination City</option>
                          <option>Austin</option>
                          <option>Houston</option>
                          <option>Las Vegas</option>
                          <option>Honolulu</option>
                          <option>Tampa</option>
                          <option>Los Angeles</option>
                          <option>Pittsburgh</option>
                          <option>London</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Departure Date</label>
                        <input type="Date" id="departureDate" class="form-control" name="departureDate">
                      </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Return Date</label>
                        <input type="Date" id="returnDate" class="form-control" name="returnDate">
                      </div>
                    </div>
                  </div>
                  </br>
                  <div class="row">
                    <div class=" col-md-3">
                      <div class="form-group">
                        <label for="">Select Your Airline</label>
                        <select id="flight" name="airline" class="form-control" placeholder="">
                          <option value="" id="airline" name="airline" selected disabled>Select Your Airline</option>
                          <option>Delta</option>
                          <option>United</option>
                          <option>Southwest</option>
                          <option>Frontier</option>
                        </select>
                      </div>
                    </div> 
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="">Cabin Class</label>
                        <label class="radio-inline">
                          <input type="radio" name="class" id="class" value="economy">Economy
                        </label>
                        <br>
                        <label class="radio-inline" style="margin-left: 0">
                         <input type="radio" name="class" id="class"  value="first">First
                        </label>
                      </div>
                    </div> 

                    <div class="col-sm-offset-1 col-md-2">
                      <div class="form-group">
                        <label for="At">Number of Travelers</label>
                       <input type="number" step="any" value="0" id="travelers" name ="travelers" style="color: black;"> 
                      </div>
                    </div>
                  </div>
                  <br><br>
                  <h3>Hotel Information:</h3>  
                  <br>   
                   <div class="row">
                    <div class=" col-md-2">
                      <div class="form-group">
                        <label for="">Destination</label>
                          <select id="destination" name="destination" class="form-control" placeholder="">
                            <option value="" id="destination" name="destination" selected disabled>Enter Destination City</option>
                            <option>Austin</option>
                            <option>Houston</option>
                            <option>Las Vegas</option>
                            <option>Honolulu</option>
                            <option>Tampa</option>
                            <option>Los Angeles</option>
                            <option>Pittsburgh</option>
                            <option>London</option>

                          </select>
                      </div>
                   </div>
                   <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Check-In</label>
                        <input type="Date" id="checkIn" class="form-control" name="checkIn">
                      </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Check-Out</label>
                        <input type="Date" id="checkOut" class="form-control" name="checkOut">
                      </div>
                    </div>
                  </div> 
                  <br>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="At">Number of Guests</label>
                       <input type="number" id="guests" name="guests" step="any" value="0" style="color: black;"> 
                      </div>
                    </div>
                    <div class="col-sm-offset-1 col-md-2">
                      <div class="form-group">
                        <label for="At">Number of Rooms</label>
                       <input type="number" id="rooms" name="rooms" step="any" value="0" style="color: black;"> 
                      </div>
                    </div>
                  </div>
                  <br><br><br><br>
                  <div class="row">
                    <div class="col-sm-offset-5 col-sm-10">
                      <input type="hidden" name="hotel-flight-submit" value="true">
                        <button type="submit" data-toggle="tooltip" data-placement="right" title="Search Flight + Hotel" class="btn btn-primary">Search Flight + Hotel</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

<!--Hotel Search ===================================================================================================-->
          <div id="hotel" class="tab-pane fade">
            <div class="panel panel-default home-panel">
              <div class="panel-body">
                <div class="page-header" style="margin-top:5px;">
                  <center><b><font id="formhead">SEARCH FOR A HOTEL</font></b><i class="fa fa-hotel fa-3x" style="margin-left: 20px"></i></center>
                </div>
                <form class="form-inline" name="hotelForm" id="hotelForm" method="post" action="hotelsearch.php" onsubmit="return validateHotel()">
                   <div class="row">
                    <div class=" col-md-2">
                      <div class="form-group">
                        <label for="">Destination</label>
                          <select id="destination" name="destination" class="form-control" placeholder="">
                            <option value="" id="destination" name="destination" selected disabled>Enter Destination City</option>
                            <option>Austin</option>
                            <option>Houston</option>
                            <option>Las Vegas</option>
                            <option>Honolulu</option>
                            <option>Tampa</option>
                            <option>Los Angeles</option>
                            <option>Pittsburgh</option>
                            <option>London</option>

                          </select>
                      </div>
                   </div>
                   <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Check-In</label>
                        <input type="Date" id="checkIn" class="form-control" name="checkIn">
                      </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Check-Out</label>
                        <input type="Date" id="checkOut" class="form-control" name="checkOut">
                      </div>
                    </div>
                  </div> 
                  <br>     
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="At">Number of Guests</label>
                       <input type="number" id="guests" name="guests" step="any" value="0" style="color: black;"> 
                      </div>
                    </div>
                    <div class="col-sm-offset-1 col-md-2">
                      <div class="form-group">
                        <label for="At">Number of Rooms</label>
                       <input type="number" id="rooms" name="rooms" step="any" value="0" style="color: black;"> 
                      </div>
                    </div>
                  </div>
                  <br><br><br><br>
                  <div class="row">
                    <div class="col-sm-offset-5 col-sm-10">
                      <input type="hidden" name="hotels-submit" value="true">
                        <button type="submit" data-toggle="tooltip" data-placement="right" title="Search Hotels" class="btn btn-primary">Search Hotels</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
<!--Deals Search =========================================================================================-->

          <div id="deals" class="tab-pane fade">
            <div class="panel panel-default home-panel">
              <div class="panel-body">
                <div class="page-header" style="margin-top:5px;">
                  <center><b><font id="formhead">SEARCH OUR DEALS</font></b><i class="fa fa-dollar-sign fa-3x" style="margin-left: 20px"></i></center>
                </div>
                <form class="form-inline" name="dealForm" id="dealForm" method="post" action="deals.php" onsubmit="return validateDeal()">
                   <div class="row">
                    <div class="col-md-1">
                      <div class="form-group">
                        <label for="source">Source</label>
                          <select class="form-control" id="source" name="source">
                            <option value=""  selected disabled>Source</option>
                            <option>Austin</option>
                            <option>Houston</option>
                            <option>Las Vegas</option>
                            <option>Honolulu</option>
                            <option>Tampa</option>
                            <option>Los Angeles</option>
                            <option>Pittsburgh</option>
                            <option>London</option>
                          </select>
                     </div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class=" col-md-2">
                      <div class="form-group">
                        <label for="">Destination</label>
                          <select id="destination" name="destination" class="form-control" placeholder="">
                            <option value="" id="destination" name="destination" selected disabled>Destination</option>
                            <option>Austin</option>
                            <option>Houston</option>
                            <option>Las Vegas</option>
                            <option>Honolulu</option>
                            <option>Tampa</option>
                            <option>Los Angeles</option>
                            <option>Pittsburgh</option>
                            <option>London</option>
                          </select>
                      </div>
                   </div>
                   <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Starting Date</label>
                        <input type="Date" id="startingDate" class="form-control" name="startingDate">
                      </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Ending Date</label>
                        <input type="Date" id="endingDate" class="form-control" name="endingDate">
                      </div>
                    </div>
                  </div> 
                  <br>     
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="At">Number of Travelers</label>
                       <input type="number" id="travelers" name="travelers" step="any" value="0" style="color: black;"> 
                      </div>
                    </div>
                    <div class="col-sm-offset-1 col-md-2">
                      <div class="form-group">
                        <label for="At">Number of Rooms</label>
                       <input type="number" id="rooms" name="rooms" step="any" value="0" style="color: black;"> 
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Price Range(Low)</label>
                        <input type="range" name="lowslider" min="0" max="10000" value="0" step ="100" oninput="this.form.low.value=this.value" />
                        <br>
                        <input type="number" id="low" name="low" min="0" max="10000" value="0" oninput="this.form.lowslider.value=this.value" />
                      </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Price Range(High)</label>
                        <input type="range" name="highslider" min="0" max="10000" value="0" step ="100" oninput="this.form.high.value=this.value" />
                        <br>
                        <input type="number" id="high" name="high" min="0" max="10000" value="0" oninput="this.form.highslider.value=this.value" />
                      </div>
                    </div>
                  </div>
                  <br><br><br><br>
                  <div class="row">
                    <div class="col-sm-offset-5 col-sm-10">
                      <input type="hidden" name="deals-submit" value="true">
                        <button type="submit" data-toggle="tooltip" data-placement="right" title="Search Hotels" class="btn btn-primary">Search Deals</button>
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
  <?php echo get_footer();?>
</body>
</html> 