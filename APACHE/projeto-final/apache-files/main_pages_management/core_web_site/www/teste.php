<?php
        $my_email = "jcfenuchi@admin";
        $my_password = "12345";
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
        }
?>