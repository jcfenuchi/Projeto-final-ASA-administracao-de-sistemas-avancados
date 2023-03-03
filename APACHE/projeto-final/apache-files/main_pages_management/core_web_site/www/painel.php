<?php
include("protect.php");
include("conexao.php")
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Principal</title>
</head>
<style>
/* Style the header */
body {
  background-color: #1f1717;
  padding: 80px;
  text-align: center;
  font-size: 20px;
  color: white;
}
#logo_img {
  height: 200px;
  width: 450px
}

#logout_button {
    height: 25px;
    width: 100px
}

#senhas_button {
    height: 25px;
    width: 175px
}
</style>


<?php
    if ($_SESSION['type'] == "root"){
	$name = $_SESSION['name'];
	 # Removendo Admin dos domains
        $my_root_email = $_SESSION['email'];
        $query = "SELECT * FROM root_users where Login_root = '$my_root_email' ";
        $sql_query = $mysqli->query($query) or die("falha no sql:" . $mysqli->error);      
        $usuario = $sql_query->fetch_assoc();
        $domains = explode(",",$usuario['domains']);
        $fist = <<<END
<div>
    <img src="./images/Domain_manager_mini.png" id="logo_img" alt="Logo of Domains manager"><br><br>
</div>
####### Seja Bem vindo $name ######<br>
------ Responsaveis pelo Seu Dominios ------<br>
<table border="1" align="center" width="600" height="100">
<tr align="center" >
    <th>Nome:</th>
    <td>senha:</td>
</tr>
END;
        echo $fist;
	foreach ($domains as $domain) {



	$query2 = "SELECT * FROM ftpusers where email = 'root@$domain'";
	$sql_query2 = $mysqli->query($query2) or die("falha no sql:" . $mysqli->error);
	$usuario2 = $sql_query2->fetch_assoc();
	$email = $usuario2['email'];
	$senha = $usuario2['senha'];
    $echoar = <<<END
    <tr>
        <th>$email:</th>
        <td>$senha</td>
    </tr> 
END;
	echo $echoar;
	}
    echo "</table>";

        $root_domain = <<<END
    <body>
        
        <p>
        
        <button id="creation_button" onclick="window.location.href='./criador_de_usuarios.php';">
          Criador de Dominios
        </button>
        </button>
        <button id="exclusion_button" onclick="window.location.href='./exclusor_de_usuarios.php';">
         Exclusor Dominios
        </button>
        <button id="senhas_button" onclick="window.location.href='./alterador_de_senhas.php';">
          Alterador de senhas
        </button><br><br>
        <button id="logout_button" onclick="window.location.href='./logout.php';">
          Logout
        </button>
        </p>
        </body>
    </html>
END;
        echo $root_domain;

    }
?>
<?php
    if ($_SESSION['type'] == "admin"){
        $name1 = $_SESSION['name'];
        $fist = <<<END
<div>
    <img src="./images/Domain_manager_mini.png" id="logo_img" alt="Logo of Domains manager"><br><br>
</div>
<div>
####### Seja Bem vindo $name1 ######<br>
------ Seus Usuarios  ------<br>
<table border="1" align="center" width="600" height="100">
<tr align="center" >
    <th>Nome:</th>
    <td>senha:</td>
</tr>
END;
        echo $fist;
        $self_email = $_SESSION['email'];
        $name = explode("@",$_SESSION['email']);
	    $query = "SELECT * FROM ftpusers WHERE email LIKE '%@$name[1]'";
        $sql_query = $mysqli->query($query) or die("falha no sql:" . $mysqli->error);      
        if ($sql_query->num_rows > 0 ){
            while ($row = $sql_query->fetch_assoc()) {
                $emailp = $row['email'];
                $senhap = $row['senha'];
                $echoar = <<<END
<tr>
    <th>$emailp</th>
    <td>$senhap</td>
</tr> 
END;

                echo $echoar;
                echo "</div>";
            }
        }
        

        

        $admin = <<<END
    <body>        
        <button id="creation_button" onclick="window.location.href='./criador_de_usuarios.php';">
         Criador de Usuarios
        </button>
        <button id="exclusion_button" onclick="window.location.href='./exclusor_de_usuarios.php';">
         Exclusor de Usuarios
        </button>
        <button id="senhas_button" onclick="window.location.href='./alterador_de_senhas.php';">
          Alterador de senhas
        </button><br><br>
        <button id="logout_button" onclick="window.location.href='./logout.php';">
         Logout
        </button>

        </p>
        </body>
    </html>
END;
        echo $admin;

        
    }
?>

<?php
    if ($_SESSION['type'] == "usuario"){
        $name = $_SESSION['name'];
        $user = <<<END
    <body>
        <div>
            <img src="./images/Domain_manager_mini.png" id="logo_img" alt="Logo of Domains manager"><br><br>
        </div>
        Seja Bem vindo $name
        <p>
        <button id="logout_button" onclick="window.location.href='./logout.php';">
          Logout
        </button>
        <button id="senhas_button" onclick="window.location.href='./alterador_de_senhas.php';">
          Alterador de senhas
        </button>
        </p>
        </body>
    </html>
END;
        echo $user;
    }
?>


