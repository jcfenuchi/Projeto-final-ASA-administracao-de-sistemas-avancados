<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar tables</title>
</head>
<style>
table,th,td{
  border:2px solid navy;
}
table{
  border-collapse:collapse;
  width:20%;
}
td{
  height:40px;
}
tr{
  background-color:white;
  color:black;
}
th{
  background-color:white;
  color:black;
    }
body {
  background-color: #1f1717;
  padding: 80px;
  text-align: center;
  font-size: 20px;
}

#aber {
  color: white;
}

#aber1 {
  color: white;
}

</style>
<body>

<h2 id="aber">as tabelas atualmente estão assim</h2>
<p id="aber1">evitei colocar muito style ou customizar as tabelas aqui pois ela sao para visualiza�ao na ausencia de um leitor de banco de dados como dbeaver ou outros.</p>

<?php
function selec_table($table) {
    include("/projeto-final/apache-files/main_pages_management/core_web_site/www/conexao.php");
    $query = "SELECT * FROM $table";
    $sql_query = $mysqli->query($query) or die("falha no sql:" . $mysqli->error);
    if ($table == "root_users"){
	    $size = "80";
	    $tam = "4";
    } elseif ($table == "ftpusers"){
	    $size = "120";
	    $tam = "9";
    } elseif ($table == "ftpgroups"){
	    $size = "60";
	    $tam = "3";
    } elseif ($table == 'domains'){
	    $size = "30";
	    $tam = "1";
    }
    
    echo "<table style=\"width:$size%\" >";
    echo "<tr><th colspan=\"$tam\">$table</th>";
    echo "</tr>";
    # aqui pegamos apenas as chaves :)
    $query_1_line = "SELECT * FROM $table LIMIT 1";
    $sql_query_1_line = $mysqli->query($query_1_line) or die("falha no sql:" . $mysqli->error);
    foreach($sql_query_1_line->fetch_assoc() as $x => $x_value){
        echo "<td>".$x."</td>";
    }
    # printamos todos itens da lista 
    while ($row = $sql_query->fetch_assoc()){
        echo "<tr>";
        foreach ($row as &$teste){
            echo "<td>".$teste."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";   
    }
selec_table("root_users");
echo "<br>";
selec_table("ftpusers");
echo "<br>";
selec_table("ftpgroups");
echo "<br>";
selec_table("domains");
?>

</body>
</html>
