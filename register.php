<?php
	include 'utility.php';
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
			if(document.addUser.firstname.value=="")
			{
				alert("Please enter your Firstname");
				document.addUser.firstname.focus();
				return false;
			}
			if(document.addUser.lastname.value=="")
			{
				alert("Please enter your LastName");
				document.addUser.lastname.focus();
				return false;
			}
			if(document.addUser.username.value=="")
			{
				alert("Please enter your UserName");
				document.addUser.username.focus();
				return false;
			}
			if(document.addUser.username.value.length<8)
			{
				alert("Username Should be atleast 8 Characters");
				document.addUser.username.focus();
				return false;
			}
			if(document.addUser.password.value=="")
			{
				alert("Please enter valid Password");
				document.addUser.password.focus();
				return false;
			}
			if(document.addUser.password.value.length<8)
			{
				alert("Password Should be atleast 8 Characters");
				document.addUser.username.focus();
				return false;
			}
			if(!(document.addUser.password.value==document.addUser.password1.value))
			{
				alert("Password Not matching");
				document.addUser.password1.focus();
				return false;
			}
					
			if(document.addUser.email1.value=="")
			{
				alert("Please enter your Email");
				document.addUser.email1.focus();
				return false;
			}
			if(!(document.addUser.email1.value==document.addUser.email2.value))
			{
				alert("Email not matching");
				document.addUser.email2.focus();
				return false;
			}			
			if(document.addUser.phone.value.length>10)
			{
				alert("Please enter a valid phone number");
				document.addUser.phone.focus();
				return false;
			}
			if(isNaN(document.addUser.phone.value))
			{
				alert("Invalid Phone Number");
				document.addUser.phone.focus();
				return false;
			}
			if(document.addUser.address.value=="")
			{
				alert("Please enter your address");
				document.addUser.address.focus();
				return false;
			}
			if(document.addUser.creditcard.value=="")
			{
				alert("Please enter your creditcard");
				document.addUser.creditcard.focus();
				return false;
			}
			if(isNaN(document.addUser.creditcard.value))
			{
				alert("Invalid Creditcard Number");
				document.addUser.creditcard.focus();
				return false;
			}
			if(document.addUser.cardtype.value=="")
			{
				alert("Please enter your card type");
				document.addUser.cardtype.focus();
				return false;
			}
			if(document.addUser.cvc.value=="")
			{
				alert("Please enter your CVC");
				document.addUser.cvc.focus();
				return false;
			}
			if(isNaN(document.addUser.cvc.value))
			{
				alert("Invalid CVC Number");
				document.addUser.cvc.focus();
				return false;
			}
			if(document.addUser.expdate.value=="")
			{
				alert("Please enter your expiration date");
				document.addUser.expdate.focus();
				return false;
			}
		}
	</script>

	</head>

<body>
	<?php echo get_header();?>
	<div class="container-fluid" id="background-register">
	<div class="container padding-top-10"  id="register-form">
	  <div class="panel panel-default register-panel">
			<div class="panel-heading">
				<b><font size="8px" style="font-family: 'Josefin Sans', sans-serif;">SIGN UP</font><i class="fas fa-pencil-alt fa-3x" style="margin-left: 20px"></i></b>
			</div>
			<div class="panel body">
				<form name="addUser" action="addUser.php" onsubmit="return validate()" method="post">
					<label for="firstname" class="control-label">Name:</label>
					<div class="row padding-top-10">
						<div class="col-md-3">
							<input type="text" class="form-control" id="firstname" name="firstname" placeholder="First"/>
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle"/>
						</div>						
						<div class="col-md-3">
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last"/>
						</div>
					</div>
					<br>
					<label class="control-label padding-top-10">Username: (Min 8 Characters)</label>
					<div class="row padding-top-10">
						<div class="col-md-3">
							<input type="text" class="form-control" id="username" name="username" placeholder="Enter username (used for login)"/>
						</div>
					</div>
					<br>
					<label class="control-label padding-top-10">Password: (Min 8 Characters)</label>
					<div class="row">
						<div class="col-md-3">
							<input type="password" class="form-control" id="password" name="password" placeholder="Upto 8 characters"/>
						</div>
						<div class="col-md-3">
							<input type="password" class="form-control" id="password1" name="password1" placeholder="Confirm password"/>
						</div>
					</div>
					<br>
					<label for="email" class="control-label padding-top-10">Email:</label>
					<div class="row">
						<div class="col-md-3">
							<input  type="text" class="form-control" id="email1" name="email1" placeholder="Enter Email" data-toggle="tooltip" data-placement="right" title="Enter valid Email ID for Account Verification "/>
						</div>
						<div class="col-md-3">
							<input  type="text" class="form-control" id="email2" name="email2" placeholder="Confirm Email" />
						</div>						
					</div>
					<br>
					<label for="phone" class="control-label padding-top-10">Phone No:</label>
					<div class="row padding-top-10">
						<div class="col-md-3">
							<input  type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number"/>
						</div>
					</div>
					<br>	
					<label for="address" class="control-label padding-top-10">Address:</label>
					<div class="row padding-top-10">
						<div class="col-md-6">
							<input  type="text" class="form-control" id="address" name="address" placeholder="Enter Address"/>
						</div>
					</div>
					<br>
					<label for="creditcard" class="control-label padding-top-10">Credit Card:</label>
					<div class="row padding-top-10">
						<div class="col-md-3">
							<input  type="text" class="form-control" id="creditcard" name="creditcard" placeholder="Enter CC Number"/>
						</div>
						<div class="col-md-3">
							<input  type="text" class="form-control" id="cardtype" name="cardtype" placeholder="Enter Card Type"/>
						</div>
						<div class="col-md-3">
							<input  type="text" class="form-control" id="cvc" name="cvc" placeholder="Enter CVC Number"/>
						</div>		
						<div class="col-md-3">
							<input  type="text" class="form-control" id="expdate" name="expdate" placeholder="Enter Exp Date MM/YY"/>
						</div>
					</div>
					<br><br>
					<div class="row padding-top-10">
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