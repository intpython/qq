<?php
$conn = mysqli_connect('localhost','phpmyadmin','12345678');
$dbname = "phpmyadmin";
mysqli_select_db($conn, $dbname);

require_once 'GoogleAuthenticator.php';
$ga = new PHPGangsta_GoogleAuthenticator();
session_start();
$user = $_SESSION["user"];


$sele = "SELECT * FROM test where username='$user'";
$result = mysqli_query($conn,$sele);
$row = mysqli_fetch_array($result);
$secret = $row['basecode'];
//print($secret);


$i= -9 ;
$j=1;
$num[10]=[''];

while($i<1){

        $oneCode = $ga->getCode($secret,$i);
        $num[$i]=$oneCode;
	$i = $i + $j;



//      print("i = $i &nbsp&nbsp&nbsp&nbsp");
//      echo "$oneCode <br>";
}
?>

<html>
 <body background="http://s3.amazonaws.com/caself/products/photos/000/001/413/original/concretia_6.jpg?1509412229">
  <title>ITE 會員系統</title>

 <form METHOD="POST" ACTION="tt.php">
  驗證碼:<input type="text" name="cood"/><p>


  <input type="submit" name='verification' values = 'verification'onclick="location.href='tt.php'">
  <p>
  <button type="button" onclick="location.href='iteshop'">
            返回首頁
    </button>



 <w/form>
 </body>
</html>
