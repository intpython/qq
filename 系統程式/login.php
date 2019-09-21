<?php
$conn = mysqli_connect('localhost','phpmyadmin','12345678');
$dbname = "phpmyadmin";
mysqli_select_db($conn, $dbname);

if(!empty($_POST['account'])){
        $user = $_POST['account'];
        $pass = $_POST['password'];
        session_start();
        $_SESSION["user"] = $user;

        $sele = "SELECT * FROM test where username='$user'";
        $result = mysqli_query($conn,$sele);

        $row = mysqli_fetch_array($result);
        if(!$row){
		echo '<script type="text/javascript">alert("帳號未註冊!")</script>';
	        header("Refresh:0;login");
	        exit;


        } else {
                if(!empty($_POST['password']) && $pass===$row['passwd']){
                        if($row["twover"]==1){
//                              session_start();
//                              $_SESSION["user"] = $user;
                                header("Location:twoverga.php");
                                exit;
                        } else if($row["twover"]==2){
				header("Location:u2fauth.php");
                                exit;
			} else if($row["twover"]==3){
                                header("Location:chose.php");
                                exit;
                        } else {
				header("Location:iteshop2.php");
                                exit;
			}
                } else {
			echo '<script type="text/javascript">alert("密碼錯誤!")</script>';
                        //print("password error");
			header("Refresh:0;login");
        		exit;
                }
        }
} else {
	echo '<script type="text/javascript">alert("請輸入帳號!")</script>';
	//echo "alert('Please touch you U2F device!');";
        //print ("PLEASE input user");
	header("Refresh:0;login");
        exit;
}

mysqli_close($conn);
?>
