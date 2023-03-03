<?php
include('conexao.php');
# verificando se existem email ou senha setadas 
if ((isset($_POST['email'])) OR (isset($_POST['senha']))) {
    #analise para ver se o email é 0
    if(strlen($_POST['email']) == 0 ) {
        echo "preencha seu e-mail!";
    }
    # analise se o tamanho da senha é 0
    elseif(strlen($_POST['senha']) == 0 ){
        echo "preencha sua senha!";
    }
     # caso tudo certo
    else {

        # limpando caracteres especiais 
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);
        
        #VAMOS fazer 2 consultas para descobrir se é root , admin ou user
        #fazendo select no mysql para pega login e senha 
        $sql_command = "select * from root_users where Login_root = '$email' and senha='$senha' ";
        $sql_query = $mysqli->query($sql_command) or die("falha no sql:" . $mysqli->error);        
        #verificando tamanho de linhas
        $tamanho = $sql_query->num_rows;
        if($tamanho == 1) {
            $usuario = $sql_query->fetch_assoc();
            #verificando sesao
            if(!isset($_SESSION)) {
                session_start();
            }
            #salvando user e name e retorno do db como variaveis de sesao
            $_SESSION['type'] = "root";
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            $_SESSION['user'] = $usuario['id'];
            $_SESSION['name'] = $usuario['Login_root'];
            $_SESSION['domains'] = $usuario['domains'];

            #Direcionar usuario para outra pagina
            header("Location: painel.php");
        } # se der consulta retorna + de 1 linha
        
        $sql_command1 = "select * from ftpusers where email = '$email' and senha='$senha' ";
        $sql_query1 = $mysqli->query($sql_command1) or die("falha no sql:" . $mysqli->error);        
        #verificando tamanho de linhas
        $tamanho1 = $sql_query1->num_rows;
        if($tamanho1 == 1) {
            $usuario = $sql_query1->fetch_assoc();
            #verificando sesao
            if(!isset($_SESSION)) {
                session_start();
            }
            #analisando type para proxima etapa
            $splited_email = explode("@",$email);
            if ($splited_email[0] == "root") {
                $_SESSION['type'] = "admin";
            }
            else {
                $_SESSION['type'] = "usuario";
            }
            #salvando user e name e retorno do db como variaveis de sesao
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            $_SESSION['user'] = $usuario['uid'];
            $_SESSION['name'] = $usuario['nome'];

            #Direcionar usuario para outra pagina
            header("Location: painel.php");
        } # se não achar é pq senha ou login invalido
        else {
            echo "email de login ou senha invalidos!";
        }
    } 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina De Login</title>
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

#login_button {
    height: 25px;
    width: 100px
}
</style>
<body>

    <form action="" method="POST">
        <div>
        <img src="./images/Domain_manager_mini.png" id="logo_img" alt="Logo of Domains manager"><br><br>
        </div>
        <label>E-mail:</label>
        <input type="text" name="email"><br>
        <label>Senha:</label>
        <input type="password" name="senha"><br><br>
        <button  type="submit" id="login_button">Login </button>

    </form>
</body>
</html>
