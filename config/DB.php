<?php
$SERVER = "localhost";
$USER_NAME = "root";
$PASSWORD = "";
$tblNAME = "ecom";


$conn = new mysqli($SERVER, $USER_NAME, $PASSWORD, $tblNAME);

if($conn->connect_error){
    echo "got error".$conn->connect_error;
}else{
    echo "Connect successfully";
}
?>