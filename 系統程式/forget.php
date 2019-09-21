<?php

$conn = mysqli_connect('localhost','phpmyadmin','32654189');
$dbname = "phpmyadmin";
mysqli_select_db($conn, $dbname);

session_start();

$user=$_SESSION["user"];

	$sele = "SELECT * FROM test where username='$user'";
        $result = mysqli_query($conn,$sele);

        $row = mysqli_fetch_array($result);

        if(!$row){
                echo '<script type="text/javascript">alert("帳號未註冊!")</script>';
                header("Refresh:0;login");
                exit;
        }
	else{
		if($row["twover"]==0){
			echo '<script type="text/javascript">alert("未啟用兩階段驗證!")</script>';
			header("Refresh:0;iteshop2.php");
			exit;
		} else if (!empty($_POST['password']) && $_POST['password']===$row['passwd']){
			 if($row["twover"]==1){
                                $upd = "update test set twover=0,basecode='NULL' where username = '$user'";
                                mysqli_query($conn,$upd);
                                echo '<script type="text/javascript">alert("重製成功!")</script>';
                                header("Refresh:0;iteshop2.php");
                                exit;
                        } else if($row["twover"]==2){

                                $chose1 = "SELECT * FROM users where name='$user'";
                                $result1 = mysqli_query($conn,$chose1);
                                $row1 = mysqli_fetch_array($result1);
                                $userid=$row1["id"];
                                //echo $row1["id"];


                                $chose2 = "SELECT * FROM registrations where user_id = '$userid'";
                                $result2 = mysqli_query($conn,$chose2);
                                $row2 = mysqli_fetch_array($result2);

                                $upd = "delete FROM registrations where user_id = '$userid'";
                                mysqli_query($conn,$upd);

                                $upd = "delete FROM users where name  = '$user'";
                                mysqli_query($conn,$upd);

                                $upd = "update test set twover=0,basecode='NULL' where username = '$user'";
                                mysqli_query($conn,$upd);
                                echo '<script type="text/javascript">alert("重製成功!")</script>';
                                header("Refresh:0;iteshop2.php");
                                exit;
                        } else if(($row["twover"]==3)){
				$upd = "update test set twover=0,basecode='NULL' where username = '$user'";
                                mysqli_query($conn,$upd);

				$chose1 = "SELECT * FROM users where name='$user'";
                                $result1 = mysqli_query($conn,$chose1);
                                $row1 = mysqli_fetch_array($result1);
                                $userid=$row1["id"];

                                $upd = "delete FROM registrations where user_id = '$userid'";
                                mysqli_query($conn,$upd);

                                $upd = "delete FROM users where name  = '$user'";
                                mysqli_query($conn,$upd);

                                $upd = "update test set twover=0,basecode='NULL' where username = '$user'";
                                mysqli_query($conn,$upd);
                                echo '<script type="text/javascript">alert("重製成功!")</script>';
                                header("Refresh:0;iteshop2.php");
                                exit;
			}
			else {
                        echo '<script type="text/javascript">alert("密碼錯誤!")</script>';
                        //print("password error");
                        header("Refresh:0;iteshop2.php");
                        exit;
                        }

		}
	}

?>

<html>
 <head>
        <meta charset="utf-8">
  <title>ITE 會員系統</title>
 </head>
 <body background="http://s3.amazonaws.com/caself/products/photos/000/001/413/original/concretia_6.jpg?1509412229">

 <p>

<FORM METHOD=POST ACTION="forget.php">

 請再次輸入密碼: <INPUT TYPE="password" NAME="password" placeholder="輸入密碼" ><BR>
  <p>
  <INPUT TYPE="submit" value="重製兩階段驗證">

 </FORM>
 </body>
</html>

