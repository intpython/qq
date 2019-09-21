<?php
$conn = mysqli_connect("localhost", "phpmyadmin", "12345678");

$dbname = "phpmyadmin";

mysqli_select_db($conn, $dbname);

if(!empty($_POST['user'])){
        $user = $_POST['user'];
	$pass1=$_POST['pass1'];
	$pass2=$_POST['pass2'];


        $sele = "SELECT username FROM test where username='$user'";
        $result = mysqli_query($conn,$sele);
        if(mysqli_num_rows($result)>0)
        {
		 header("location: /otp/userfail");
		 exit;
//                print("USERNAME already exists!");
        } else  {
		if(!empty($pass1)){
			if($pass1===$pass2){
                        	$pass = $_POST['pass1'];
                        	$inse = "INSERT INTO test(username,passwd,twover) VALUES ('$user','$pass',0)";
                        	if($result = mysqli_query($conn,$inse))
                        	{
                               		mysqli_close($conn);
                               		header("location: usersuc");
                                	exit;
                        	} else {
                                print("register error");
                        	}
			} else {
				echo '<script type="text/javascript">alert("密碼不一致，請重新輸入!")</script>';
			        header("Refresh:0;sign");
        			exit;

			}
                } else {
                       // print("ENPTY PASS or NOT the SAME");
			 echo '<script type="text/javascript">alert("請輸入密碼!")</script>';
                   header("Refresh:0;sign");
                   exit;
                }
        }
} else {
	echo '<script type="text/javascript">alert("請輸入帳號!")</script>';
        header("Refresh:0;sign");
        exit;
}
mysqli_close($conn);
?>

