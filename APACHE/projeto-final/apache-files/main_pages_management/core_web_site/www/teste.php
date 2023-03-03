<?php
include("conexao.php");

$sql_cmd = "select * from root_users";
$sql_query = $mysqli->query($sql_cmd) or die("falha no sql:" . $mysqli->error);    
if ($sql_query->num_rows > 0 ){
    while ($row = $sql_query->fetch_assoc()) {
        echo $row['root_user'];   
        echo "\n";
    }
}







?>