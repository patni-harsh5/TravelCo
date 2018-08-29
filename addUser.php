<?php

//Form Data
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$mname = $_POST['middlename'];
$user = $_POST['username'];
$pass = $_POST['password'];
$email = $_POST['email1'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$creditcard = $_POST['creditcard'];
$cardtype = $_POST['cardtype'];
$cvc = $_POST['cvc'];
$expdate= $_POST['expdate'];

//Database login information
$server = 'localhost';
$dbname = 'survey_db_2018';
$tbl_name = 'users';
$tbl_name2 = 'creditcard';
$username = 'root';
$password = '';
$conn = mysqli_connect($server,$username,$password,$dbname) or die('Something went wrong');

if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
mysqli_select_db($conn, $server);
$user_insert = "INSERT INTO $tbl_name(fname , mname , lname , user_id , password , email , phone, address) VALUES ('$fname' , '$mname' , '$lname' , '$user' , '$pass' , '$email' , '$phone' , '$address')";
$result = mysqli_query($conn,$user_insert);

$creditcard_insert = "INSERT INTO $tbl_name2(creditcard , creditcard_type , CVC , Exp_date , user_id) VALUES ('$creditcard' , '$cardtype' , '$cvc' , '$expdate' , '$user')";

if($result){
	$result2 = mysqli_query($conn,$creditcard_insert);
	if($result2)
	{
		echo "<script>alert('Successfully Registered!'); window.location.href='/team_project/login.php';</script>";
	}
	else 
	{
		$user_delete = "Delete FROM users where user_id = '$user'";
		$result = mysqli_query($conn,$user_delete);
		echo "<script>alert('Failed to add creditcard to account. Please try again!'); window.location.href='/team_project/register.php';</script>";
	}
}
else 
{
	echo "<script>alert('Username already exists! Please try again!'); window.location.href='/team_project/register.php';</script>";
}

mysqli_close($conn);
?>
