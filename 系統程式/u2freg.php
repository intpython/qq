<?php

require_once('U2F.php');

$temp = "N";

$conn = mysqli_connect("localhost", "phpmyadmin", "12345678");
$dbname = "phpmyadmin";
mysqli_select_db($conn, $dbname);

session_start();
$player=$_SESSION["user"];

$sele = "select * from test where username='$player'";
$result = mysqli_query($conn,$sele);
$row = mysqli_fetch_array($result);


$pdo = new PDO('mysql:host=localhost;dbname=phpmyadmin','phpmyadmin','32654189');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$pdo->exec("create table if not exists users (id integer primary key auto_increment, name varchar(255))");
$pdo->exec("create table if not exists registrations (id integer primary key auto_increment, user_id integer, keyHandle varchar(255), publicKey varchar(255), certificate text, counter integer)");

$scheme = isset($_SERVER['HTTPS']) ? "https://" : "http://";
$u2f = new u2flib_server\U2F($scheme . $_SERVER['HTTP_HOST']);



function createAndGetUser($name) {
    global $pdo;
    $sel = $pdo->prepare("select * from users where name = ?");
    $sel->execute(array($name));
    $user = $sel->fetch();
    if(!$user) {
        $ins = $pdo->prepare("insert into users (name) values(?)");
        $ins->execute(array($name));
        $sel->execute(array($name));
        $user = $sel->fetch();
    }
    else
    return $user;
}

function getRegs($user_id) {
    global $pdo;
    $sel = $pdo->prepare("select * from registrations where user_id = ?");
    $sel->execute(array($user_id));
    return $sel->fetchAll();
}

function addReg($user_id, $reg) {
    global $pdo;
    $ins = $pdo->prepare("insert into registrations (user_id, keyHandle, publicKey, certificate, counter) values (?, ?, ?, ?, ?)");
    $ins->execute(array($user_id, $reg->keyHandle, $reg->publicKey, $reg->certificate, $reg->counter));
}

function updateReg($reg) {
    global $pdo;
    $upd = $pdo->prepare("update registrations set counter = ? where keyHandle = ?");
    $upd->execute(array($reg->counter, $reg->keyHandle));
}

?>

<html>
<head>
    <title>ITE 會員系統</title>

    <script src="u2f-api.js"></script>

    <script>
	<?php

	if(!$_POST['username']) {
		echo "alert('無使用者帳號!');";
          }
	else {
		$user = createAndGetUser($_POST['username']);

	     if($_SERVER['REQUEST_METHOD'] === 'POST') {
              	if(isset($_POST['startReg'])){
 		    echo "alert('請觸碰U2F設備!');";


                    $data = $u2f->getRegisterData(getRegs($user->id));

                    list($req,$sigs) = $data;
                    $_SESSION['regReq'] = json_encode($req);
                    echo "var req = " . json_encode($req) . ";";
                    echo "var sigs = " . json_encode($sigs) . ";";
                    echo "var username = '" . $user->name . "';";
        ?>
        setTimeout(function() {
            console.log("Register: ", req);
	    var appId = req.appId;
            var registerRequests = [{version: req.version, challenge: req.challenge, attestation: 'direct'}];


	    u2f.register(appId, registerRequests, [], function(data){
                var form = document.getElementById('form');
                var reg = document.getElementById('register2');
                var user = document.getElementById('username');
                console.log("Register callback", data);
                if(data.errorCode && errorCode != 0) {
                    alert("registration failed with errror: " + data.errorCode);
                    return;
                }
                reg.value = JSON.stringify(data);
/*
<?php
		echo "alert(reg.value);";
?>
*/
                user.value = username;
                form.submit();
            });
        }, 1000);
        <?php
	  } else if($_POST['register2']) {
              try {

                $reg = $u2f->doRegister(json_decode($_SESSION['regReq']), json_decode($_POST['register2']));
                addReg($user->id, $reg);

		echo "alert('註冊成功!')";
		$upd = "update test set twover=2,basecode='NULL' where username = '$player'";
		mysqli_query($conn,$upd);
		$temp = "Y";
              } catch( Exception $e ) {
                echo "alert('error: " . $e->getMessage() . "');";
              } finally {
                $_SESSION['regReq'] = null;
              }
	    }
	 }
       }
        ?>

    </script>

</head>
<body background="http://s3.amazonaws.com/caself/products/photos/000/001/413/original/concretia_6.jpg?1509412229">

<form method="POST" id="form">

    <input type="hidden" name="username" id="username" value= '<?php echo $player ?>'/><br/>


    <input type="hidden" name="register2" id="register2"/>

    <button type="submit" name="startReg" >註&nbsp;&nbsp;&nbsp;&nbsp;&nbsp冊</button>

	 <button type="button" onclick="location.href='two'" >
	 上一頁

</form>

	<?php
                if($temp=="Y"){
                        echo '<script type = "text/javascript">form.action="iteshop2.php";</script>';
                        echo '<script type = "text/javascript">form.submit();</script>';
                }
        ?>



</body>
</html>
