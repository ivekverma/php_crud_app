<?php

$server="localhost";
$username="root";
$password="";
$database="crud_app";

$connect = mysqli_connect($server,$username,$password,$database);
if(!$connect){
    die ("error".mysqli_connect_error());
}


?>