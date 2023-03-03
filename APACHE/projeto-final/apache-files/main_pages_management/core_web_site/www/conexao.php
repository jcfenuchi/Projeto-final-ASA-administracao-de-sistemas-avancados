<?php
$user = "usuario";
$password = "senha";
$database = "base_de_dados";
$host = "mysql"; # mysql vai ser substituido pelo ip do sql 
$mysqli = new mysqli($host,$user,$password,$database);
if($mysqli->error) {
    die("erro in connec witch db" . $mysqli->error);
}

?>