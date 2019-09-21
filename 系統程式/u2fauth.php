<?php

require_once('U2F.php');

$temp = "N";

$pdo = new PDO('mysql:host=localhost;dbname=phpmyadmin','phpmyadmin','12345678');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$pdo->exec("create table if not exists users (id integer primary key auto_increment, name varchar(255))");
$pdo->exec("create table if not exists registrations (id integer primary key auto_increment, user_id integer, keyHandle varchar(255), publicKey varchar(255), certificate text, counter integer)");

$scheme = isset($_SERVER['HTTPS']) ? "https://" : "http://";
$u2f = new u2flib_server\U2F($scheme . $_SERVER['HTTP_HOST']);

session_start();
$player=$_SESSION["user"];

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
		   if(isset($_POST['startAuth'])){
			 echo "alert('請觸碰U2F設備!');";

                    $reqs = json_encode($u2f->getAuthenticateData(getRegs($user->id)));
                    $_SESSION['authReq'] = $reqs;
                    echo "var req = $reqs;";
                    echo "var username = '" . $user->name . "';";
        ?>
        setTimeout(function() {
            console.log("sign: ", req);
	    var appId = req[0].appId;
            var challenge = req[0].challenge;

	    console.log("appId: ", appId);
            console.log("challenge: ", challenge);
            console.log("registeredKeys: ", req);

	    u2f.sign(appId, challenge, req, function(data) {
                var form = document.getElementById('form');
                var auth = document.getElementById('authenticate2');
                var user = document.getElementById('username');
                console.log("Authenticate callback", data);
                auth.value=JSON.stringify(data);
/*
<?php
                echo "alert(auth.value);";
?>*/

                user.value = username;
                form.submit();
            });
        }, 1000);
        <?php
	  } else if($_POST['authenticate2']) {
              try {

                $reg = $u2f->doAuthenticate(json_decode($_SESSION['authReq']), getRegs($user->id), json_decode($_POST['authenticate2']));
                updateReg($reg);

                echo "alert('驗證成功: " . $reg->counter . "');";
		//header("Location:suc");
		$temp = "Y";

              } catch( Exception $e ) {
                echo "alert('error: " . $e->getMessage() . "');";
              } finally {
                $_SESSION['authReq'] = null;
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

    <input type="hidden" name="authenticate2" id="authenticate2"/>

    <button type="submit" name="startAuth" >驗&nbsp;&nbsp;&nbsp;&nbsp;&nbsp證</button>
    
    <p>

    <button type="button" onclick="location.href='iteshop'">
            返回首頁
    </button>

</form>

	<?php
		if($temp=="Y"){
			echo '<script type = "text/javascript">form.action="iteshop2.php";</script>';
			echo '<script type = "text/javascript">form.submit();</script>';
		}
	?>

</body>
</html>
