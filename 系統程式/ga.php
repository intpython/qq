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


if($row['twover']==1 || $row['twover']==3){
	print("You already use it");
}
else{

        require_once 'GoogleAuthenticator.php';

        $ga = new PHPGangsta_GoogleAuthenticator();
        $secret = $ga->createSecret();
        echo "請輸入金鑰: ".$secret."<br><br>";

        $qrCodeUrl = $ga->getQRCodeGoogleUrl('Blog', $secret);
//      echo "Google Charts URL for the QR-Code: ".$qrCodeUrl."<br>";
        echo "<img src='$qrCodeUrl'.png><br><br>";

	if($row['twover']==0)
	        $upd = "update test set twover=1,basecode='$secret' where username = '$user'";
	else
		$upd = "update test set twover=3,basecode='$secret' where username = '$user'";
	mysqli_query($conn,$upd);
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
  返回
  </button>
  </body>
</html>

