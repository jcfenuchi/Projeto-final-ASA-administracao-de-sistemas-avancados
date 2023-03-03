<?php
include("protect.php");
	include('conexao.php');

if (($_POST['check_box'] == "on") AND (isset($_POST['who_delete']))){
    $email_to_remove = $_POST['who_delete'];

    if ($_SESSION['type'] == "root"){
        # Removendo Admin dos domains
        $my_root_email = $_SESSION['email'];
        $query = "SELECT * FROM root_users where Login_root = '$my_root_email' ";
        $sql_query = $mysqli->query($query) or die("falha no sql:" . $mysqli->error);      
        $usuario = $sql_query->fetch_assoc();
        $domain_to_delete = $_POST['who_delete'];
        $domains = explode(",",$usuario['domains']);
        $chave = array_search($domain_to_delete,$domains, true);
        if ($chave !== false) {
            unset($domains[$chave]);
        }
        $domains = implode(",",$domains);
        $update_domains = "UPDATE root_users set domains = '$domains' WHERE Login_root = '$my_root_email'";
        $sql_query = $mysqli->query($update_domains) or die("falha no sql:" . $mysqli->error);

        # Removendo adm Do Grupo rooters em ftpgroups
        $query = "SELECT * FROM ftpgroups where groupname = 'rooters' ";
        $sql_query = $mysqli->query($query) or die("falha no sql:" . $mysqli->error);      
        $usuario = $sql_query->fetch_assoc();
        $user_to_delete = "root@".$_POST['who_delete'];
        $mebros = explode(",",$usuario['members']);
        foreach ($mebros as $membro) {
            if (explode("@",$membro)[1] == $_POST['who_delete']){
            $chave = array_search($membro,$mebros, true);
            if ($chave !== false) {
                unset($mebros[$chave]);
                }
            }
        }
        $mebros = implode(",",$mebros);
        $update_groups = "UPDATE ftpgroups set members = '$mebros' WHERE groupname = 'rooters'";
        $sql_query = $mysqli->query($update_groups) or die("falha no sql:" . $mysqli->error);

        # Removendo root@ ------- USUARIO DE FTPUSERS
        $deleter_this_domain = $_POST['who_delete'];
        $delete_on_ftpusers = "DELETE FROM ftpusers WHERE email LIKE '%@$deleter_this_domain'";
        $sql_query = $mysqli->query($delete_on_ftpusers) or die("falha no sql:" . $mysqli->error);

        # Removendo DOminio de Domains 
        $delet_domains = "DELETE FROM domains WHERE domain = '$email_to_remove'";
        $sql_query = $mysqli->query($delet_domains) or die("falha no sql:" . $mysqli->error);
        exec("ls -l /projeto-final/apache-files/roots/$domain 2>/dev/null", $output, $retval);
        if ($retval == 0 ) {
            exec("rm -rf /projeto-final/apache-files/roots/$email_to_remove/");
        }

    }
    if ($_SESSION['type'] == "admin"){

        # Removendo USUARIO Do Grupo Default 
        $query = "SELECT * FROM ftpgroups where groupname = 'default' ";
        $sql_query = $mysqli->query($query) or die("falha no sql:" . $mysqli->error);      
        $usuario = $sql_query->fetch_assoc();
        $user_to_delete = $_POST['who_delete'];
        $mebros = explode(",",$usuario['members']);
        $chave = array_search($user_to_delete,$mebros, true);
        if ($chave !== false) {
            unset($mebros[$chave]);
        }
        $mebros = implode(",",$mebros);
        $update_groups = "UPDATE ftpgroups set members = '$mebros' WHERE groupname = 'default'";
        $sql_query = $mysqli->query($update_groups) or die("falha no sql:" . $mysqli->error);
        #-------------------------------------------- REMOVIDO DOS GRUPOS -----------------------

        # Removendo USUARIO DE FTPUSERS
        $delete_on_ftpusers = "DELETE FROM ftpusers WHERE email = '$user_to_delete'";
        $sql_query = $mysqli->query($delete_on_ftpusers) or die("falha no sql:" . $mysqli->error);
        $_SESSION["foward"] = "excluir";
        header("Location: criar_zonas_and_dns.php");
    }

}
elseif (($_POST['check_box'] == "on") OR (isset($_POST['who_delete']))) {
    echo "Por favor Selecione um campo é marque a caixinha para continuar.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Exclusão De Dominios e usuarios</title>
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

#title_selec_domain {
    text-align: center;
    font-size: 30px;
}

#botao_enviar {
    height: 40px;
    width: 150px
}

#botao_painel {
    height: 40px;
    width: 150px
}

#checkbox1 {
    font-size: 15px;
}

#select_menu {
    height: 35px;
    width: 250px;
}

</style>

<body>
<div>
    <img src="./images/Domain_manager_mini.png" id="logo_img" alt="Logo of Domains manager"><br><br>
</div>
<form action="exclusor_de_usuarios.php" method="post">
    <div>
    <label for="fname" id=title_selec_domain><?php 
        if ($_SESSION['type'] == "root"){
            echo "Excluir Dominio";
            $user_or_domain = "Dominio";
            }  
        else {
            echo "Excluir Usuario";
            $user_or_domain = "Usuario";
        }
        ?>
        </label><br>
    <select id="select_menu" name="who_delete">
        <option value="" disabled selected>Selecione uma opção</option>
        <?php
        if ((isset($_POST['who_delete'])) OR (!isset($_POST['who_delete']))){
        if ($_SESSION['type'] == "root"){
            $email = $_SESSION['email'];
            $senha = $_SESSION['senha'];
            $sql_command = "select * from root_users where Login_root = '$email' and senha='$senha' ";
            $sql_query = $mysqli->query($sql_command) or die("falha no sql:" . $mysqli->error); 
            $usuario = $sql_query->fetch_assoc();

            $self_account = $_SESSION['name'];
            $my_options = explode(",",$usuario['domains']);
            foreach ($my_options as $option) {
                echo "<option value=$option>root@$option</option>";
            }
        }
        if ($_SESSION['type'] == "admin"){
            $self_email = $_SESSION['email'];
            $admin_domain = explode("@",$self_email);
            $select_domains = "SELECT * FROM ftpusers WHERE email LIKE '%@$admin_domain[1]'";
            $sql_query_domains = $mysqli->query($select_domains) or die("falha no sql:" . $mysqli->error);
            if ($sql_query_domains->num_rows > 0 ){
                while ($row = $sql_query_domains->fetch_assoc()) {
                    $dominio = $row['email'];
                    if ($dominio != $self_email) {
                        echo "<option value=$dominio>$dominio</option>";
                    }
                }
            }
        }
        }
            ?>
    </select>
    </div>
    <p><input type="checkbox" id="checkbox1" name="check_box"> Eu Estou Ciente que ao <strong>Clicar em Excluir<br> o <?php echo $user_or_domain; ?> serar deletado permanentemente!</strong></p>
    <br>
    <button type="submit" id="botao_painel" formaction="./painel.php">Voltar ao Painel </button>
    <input type="submit" id="botao_enviar" name="submit" value="Excluir">
</form>
</body>
</html>
