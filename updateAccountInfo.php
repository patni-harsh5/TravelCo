<?php /*
$tbl_name = "userTable";
$uName = $_POST['UserName'];
$firstName = $_POST['FirstName'];
$middName = $_POST['MiddleName'];
$lastName = $_POST['LastName'];
$address = $_POST['Address'];
$email = $_POST['Email'];
 
$conn = mysqli_connect("localhost","root","","airlinefinal");
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db($dbname,$conn);
$sql = "INSERT INTO $tbl_name(UserName , FirstName , MiddleName , LastName , Address , Email) VALUES 
	('$uName' , '$firstName' , '$middName' , '$lastName' , '$address' , '$email')";
$result = mysql_query($sql,$conn);
if($result)
{
	echo "<script>";
	echo "alert('You have successfully updated your profile!')";
	header('location:userAccountPage.php');
}
else 
{
	echo "Error Updating Account";
}


mysql_close($conn);
*/?>