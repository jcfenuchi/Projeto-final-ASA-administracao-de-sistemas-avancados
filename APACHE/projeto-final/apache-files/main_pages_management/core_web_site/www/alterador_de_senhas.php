<?php
include("protect.php");
include('conexao.php');

if(isset($_POST['who_reset']) OR isset($_POST['new_password'])){
    if(strlen($_POST['who_reset']) == 0 ) {
        echo "preencha seu e-mail!";
    }
    # analise se o tamanho da senha é 0
    elseif(strlen($_POST['new_password']) == 0 ){
        echo "preencha sua senha!";
    }
    else {
        # limpando caracteres especiais 
        $email = $mysqli->real_escape_string($_POST['who_reset']);
        $senha = $mysqli->real_escape_string($_POST['new_password']);

        #se for alterar senha de root 
        if ($_SESSION['type'] == "root"){
            if ($email == $_SESSION['name']){
                $sql_command = "UPDATE root_users SET senha = '$senha' WHERE Login_root = '$email'";
                $nova_senha = "a Senha sua senha foi Alterada com sucesso para $senha";
            }
            else {
                $domains = explode(",",$_SESSION['domains']);
                foreach ($domains as $domain) {
                    if ($email == $domain) {
                        $have_domain = "TRUE";
                        $sql_command = "UPDATE ftpusers SET senha = '$senha' WHERE email = 'root@$email'";
                        $nova_senha = "a Senha de root@$email foi alterada para $senha";
                    }
                }
            }
            $sql_query = $mysqli->query($sql_command) or die("falha no sql:" . $mysqli->error);
        } 

        #se for alterar senha de admin 
        if ($_SESSION['type'] == "admin"){
            $splited_email_passwd = explode("@",$email);
            $split_admin_email = explode("@",$_SESSION['email']);
            if (($email == $_SESSION['email']) OR ($splited_email_passwd[1] == $split_admin_email[1])) {
                $sql_command = "UPDATE ftpusers SET senha = '$senha' WHERE email = '$email'";
                $sql_query = $mysqli->query($sql_command) or die("falha no sql:" . $mysqli->error);
                echo $splited_email_passwd[0];
                echo "<br>";
                echo $split_admin_email[0];
                if ($splited_email_passwd[0] == $split_admin_email[0]) {
                    $nova_senha = "a Sua Senha foi Alterada com sucesso para $senha";
                }
                else {
                    $nova_senha = "a Senha de $email foi alterada para $senha";

                }
            }
            else {
                echo "ERRO ao Tenta se conectar !";
            }
        }

        #se for alterar senha de usuario 
        if ($_SESSION['type'] == "usuario"){ 
            $sql_command = "UPDATE ftpusers SET senha = '$senha' WHERE email = '$email'";
            $sql_query = $mysqli->query($sql_command) or die("falha no sql:" . $mysqli->error);
            $nova_senha = "a Sua Senha foi Alterada com sucesso para $senha";
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

    <title>Alterar senhas</title>
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
  width: 400px
}

#title_selec_domain {
    text-align: center;
    font-size: 30px;
}

#botao_enviar {
    height: 25px;
    width: 100px
}

</style>







<body>
<div>
    <img src="./images/Domain_manager_mini.png" id="logo_img" alt="Logo of Domains manager"><br><br>
</div>
<form action="alterador_de_senhas.php" method="post">
    <div>
    <label for="fname" id=title_selec_domain>selecione o dominio</label><br>
    <select id="select_menu" name="who_reset">
        <option value="" disabled selected>Choose option</option>
        <?php
        if ((isset($_POST['who_reset'])) OR (!isset($_POST['who_reset']))){

        if ($_SESSION['type'] == "root"){
            $self_account = $_SESSION['name'];
            echo "<option value=$self_account>$self_account</option>";
            $my_options = explode(",",$_SESSION['domains']);
            foreach ($my_options as $option) {
                echo "<option value=$option>root@$option</option>";
            }
        }
        if ($_SESSION['type'] == "admin"){
            $self_email = $_SESSION['email'];
            $admin_domain = explode("@",$self_email);
            $select_domains = "SELECT * FROM ftpusers WHERE email LIKE '%@$admin_domain[1]'";
            $sql_query_domains = $mysqli->query($select_domains) or die("falha no sql:" . $mysqli->error);
            echo "<option value=$self_email>$self_email</option>";
            if ($sql_query_domains->num_rows > 0 ){
                while ($row = $sql_query_domains->fetch_assoc()) {
                    $dominio = $row['email'];
                    if ($dominio != $self_email) {
                        echo "<option value=$dominio>$dominio</option>";
                    }
                }
            }
        }
	if ($_SESSION['type'] == "usuario"){
		$self_email = $_SESSION['email'];
		echo "<option value=$self_email>$self_email</option>";
	}
    }
            ?>
    </select>
    </div>
    <br>
    <label for="fname">nova senha:</label>
    <input type="password" id="new_password" name="new_password">
    <div id="retorno_da_senha">
        <?php 
            if(isset($nova_senha)){
                echo "<br>";
                echo "$nova_senha";
                echo "<br><br>";
                unset($nova_senha);
            }
            else {
                echo "<br><br><br>";
            }
        ?>
    </div>
    <button type="submit" formaction="./painel.php">Voltar ao Painel </button>
    <input type="submit" id=botao_enviar name="submit" value="Enviar">
</form>




</body>
</html>
