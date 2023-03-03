
<?php
include("protect.php");
include('conexao.php');
    #SE VOCE FOR ROOT
    if (($_SESSION['type'] == "root") AND (isset($_POST['name']))){
        $domain = $_POST['name'];
        # BLOCO RESPONSAVEL POR ADICIONAR DOMINIO NA TABELA root_users
        $my_email = $_SESSION['email'];
        $my_password = $_SESSION['senha'];
        $sql_command_select_domains = "select * from root_users where Login_root = '$my_email' and senha='$my_password'";
        $sql_query = $mysqli->query($sql_command_select_domains) or die("falha no sql:" . $mysqli->error);        
        $usuario = $sql_query->fetch_assoc();
        $splited_domains = explode(",",$usuario['domains']);
        if (in_array($domain,$splited_domains)){
            echo "Dominio $domain já existe no seu Dominio";
        }
        else {
            array_push($splited_domains,$domain);
            $domains = implode(",",$splited_domains);
        	echo $domains;
	    #FAZENDO O UPDATE NA TABELA DE DOMAINS DO ROOT
            $sql_command_update_roots_domains = "UPDATE root_users SET domains = \"$domains\" WHERE Login_root = '$my_email'";
            $sql_query_update = $mysqli->query($sql_command_update_roots_domains) or die("falha no sql:" . $mysqli->error);        

            # CRIANDO UM USUARIO PADRÃO PARA OS ADMIN
            $senha_aleatoria = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $sql_command_ftpusers_insert = "INSERT INTO ftpusers(nome,login,senha,gid,ativo,dir,shell,email) VALUES ('root of $domain','rooter $domain','$senha_aleatoria',16001,'s','/projeto-final/apache-files/roots/$domain/','/bin/bash','root@$domain')";      
            $sql_query_2 = $mysqli->query($sql_command_ftpusers_insert) or die("falha no sql:" . $mysqli->error);        

            # Adicionando Usuario padrão em FTPGROUPS no grupo 16001 criado para roots;
            $domain_root = "root@".$_POST['name'];
            $sql_command_select_ftpgroups = "select * from ftpgroups WHERE groupname = \"rooters\" or gid = 16001";
            $sql_select_ftpgroups = $mysqli->query($sql_command_select_ftpgroups) or die("falha no sql:" . $mysqli->error);        
            $usuario = $sql_select_ftpgroups->fetch_assoc();   
            $splited_groups = explode(",",$usuario['members']);
            array_push($splited_groups,$domain_root);
            $root_group = implode(",",$splited_groups);
            $sql_command_ftpgrops_insert = "UPDATE ftpgroups set members = '$root_group' WHERE groupname = \"rooters\" or gid = 16001";
            $sql_update_ftpgroups = $mysqli->query($sql_command_ftpgrops_insert) or die("falha no sql:" . $mysqli->error);        

            #ADICIONANDO NOVO DOMINIO EM Domains
            $sql_query_in_domains ="INSERT INTO domains (domain) VALUES ('$domain')";
            $sql_query_3 = $mysqli->query($sql_query_in_domains) or die("falha no sql:" . $mysqli->error);
            $_SESSION["foward"] = "criar";
            header("Location: criar_zonas_and_dns.php");
        }
    }
    #SE VOCE FOR ADMIN
    if (($_SESSION['type'] == "admin") AND (isset($_POST['name'])) AND (isset($_POST['email']))) {
        #para Adicionar um novo usuario com dominio igual
        $new_email = $_POST['email'];
        $user_name = $_POST['name'];
        
        $domain = explode("@",$_SESSION['email']);
        $email = $_POST['email']."@$domain[1]";
        $new_user = explode("@",$email);
        if ($domain[1] == $new_user[1]) {
            $senha_aleatoria = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $query1 = "INSERT INTO ftpusers(nome,login,senha,gid,ativo,dir,shell,email) VALUES ('$user_name','$user_name','$senha_aleatoria',16000,'n','/home/$email','/bin/bash','$email')";
            $sql_query1 = $mysqli->query($query1) or die("falha no sql:" . $mysqli->error);        
            # ALEM DE ADICIONAR É PRECISO FAZER UPDATE NO FTPGROUPS
            $query2 = "SELECT * FROM ftpgroups where groupname = 'default' ";
            $sql_query2 = $mysqli->query($query2) or die("falha no sql:" . $mysqli->error);      
            $usuario = $sql_query2->fetch_assoc();
            $members = explode(",",$usuario['members']);
            array_push($members,$email);
            $new_members = implode(",",$members);
            $query3 =  "UPDATE ftpgroups SET members = '$new_members' WHERE groupname = 'default'";
            $sql_query30 = $mysqli->query($query3) or die("falha no sql:" . $mysqli->error);
        } 
        else {
            echo "Voce só tem permissoes para criar no Dominio: $domain[1]";
        }    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
#p1 {
    height: 20px;
    width: 1200px;
}
#p2 {
    height: 20px;
    width: 1050px
}
#logo_img {
  height: 200px;
  width: 450px
}
</style>

<body>
    <?php 
     if ($_SESSION['type'] == "root"){
    $default_layout = <<<EOT
<form action="criador_de_usuarios.php" method="POST">
    <div>
    <img src="./images/Domain_manager_mini.png" id="logo_img" alt="Logo of Domains manager"><br><br>
    </div>
    <p>Criador de Dominios</p><br>
    <label>Digite o nome do Dominio:</label>
    <input type="text" name="name"><br>
    <button type="submit" formaction="./painel.php">Voltar ao Painel </button>
    <button  type="submit">Criar Zona</button>
</form>
EOT;
    echo $default_layout;    
     }
    if ($_SESSION['type'] == "admin"){
        $dominio = explode("@",$_SESSION['email']);
        $default_layout = <<<END
<form action="criador_de_usuarios.php" method="post">
    <div>
    <img src="./images/Domain_manager_mini.png" id="logo_img" alt="Logo of Domains manager"><br><br>
    </div>
    <p>Criador de usuarios</p>
    <p id="p1">Email : <input type="text" name="email" />@$dominio[1]</p>
    <p id="p2">Seu Nome: <input type="text" name="name" /></p><br>
    <button type="submit" formaction="./painel.php">Voltar ao Painel </button>
    <button type="submit" formaction="./criador_de_usuarios.php">Criar_usuario</button>
</form>
END;
    echo $default_layout;
    }
    ?>
</body>
</html>
