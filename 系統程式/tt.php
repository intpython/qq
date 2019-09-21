<?php
require_once 'twoverga.php';
$k=0;
$j=1;

if(!empty($_POST["cood"])){

        $cod = $_POST["cood"];
        while($k < 10){
                if($num[$k] == $cod){
                        header("Location:/otp/iteshop2.php");
                        exit;
                } else {
                        if($k==9){
                                print("verificate error \n");
                        }
                }
                $k = $k + $j;
        }
} else {
        print("Please input verification");
}
?>



