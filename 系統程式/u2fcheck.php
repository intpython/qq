<?php
$conn = mysqli_connect("localhost", "phpmyadmin", "12345678");

$dbname = "phpmyadmin";

mysqli_select_db($conn, $dbname);

session_start();
$user=$_SESSION["user"];

$sele = "select * from test where username='$user'";
$result = mysqli_query($conn,$sele);
$row = mysqli_fetch_array($result);
//print($row['twover']);

if($row['twover']== 2 || $row['twover']== 3){
	 print("You already use it");
}
else{
	//header("location:https://192.168.43.177/u2freg.php?player=".$user);
	header("location:u2freg.php");
	//$upd = "update test set twover=2,basecode='NULL' where username = '$user'";
	//mysqli_query($conn,$upd);
}

?>


<html>
  <head>
    <meta charset="utf-8">
    <title>ITE 會員系統</title>
  </head>
  <body background="http://s3.amazonaws.com/caself/products/photos/000/001/413/original/concretia_6.jpg?1509412229">
  <p>

  <button type="button" onclick="location.href='iteshop2.php'">
  TURN BACK 

  </button>

  </FORM>
  </body>
</html>

