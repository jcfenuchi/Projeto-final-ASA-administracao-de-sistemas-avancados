<?php
include("protect.php");
include("conexao.php");
$MY_ADDRESS = "172.20.0.2";
$MY_PORT = "80";
$BINDER = $MY_ADDRESS.":".$MY_PORT;
$dns_file = fopen('/projeto-final/dns-files/arquivos_de_zonas','w');
$apache_file = fopen('/projeto-final/apache-files/apache.conf','w'); 
#
#the default.zone in end of file :)
#

#dados do First_dns_zone
$base_dns = <<<END
//-------- BLOCO PADRÃO DO DNS para gerenciar os Domains ---------------
zone "domains.manager" IN {
    type master;
    file "/projeto-final/dns-files/default.zone";
    allow-query { any; };
};

END;
#escrevendo o primeiro bloco do dns
fwrite($dns_file, $base_dns); 

#dados do First_virtual_host
$base_apache = <<<END
# ---------- BLOCO PADRÃO DO APACHE para gerenciar os Domains -------------------
<VirtualHost $BINDER>
        <Directory /projeto-final/apache-files/main_pages_management/core_web_site/>
          AllowOverride all
          Require all granted
          Options Indexes
          DirectoryIndex index.php index.hmtl
        </Directory>
        ServerAdmin root@jcfenuchi.web
        DocumentRoot "/projeto-final/apache-files/main_pages_management/core_web_site/www"
        ServerName domains.manager
        ServerAlias www.domains.manager
        ErrorLog "/projeto-final/apache-files/main_pages_management/core_web_site/logs/error-vp.log"
        CustomLog "/projeto-final/apache-files/main_pages_management/core_web_site/logs/acess-vp.log" common
</VirtualHost>

END;
#escrevendo o primeiro bloco do apache
fwrite($apache_file, $base_apache); 

$sql_command = "select * from domains";
$sql_query = $mysqli->query($sql_command) or die("falha no sql:" . $mysqli->error);
if ($sql_query->num_rows > 0 ){
    while ($row = $sql_query->fetch_assoc()) {
        $domain = $row['domain'];
        if (($domain != "mail62.local" and $domain != "f.mail62.local")) {
        #criando diretorios caso não exista
        $retval=null;
        $output=null;
        exec("ls -l /projeto-final/apache-files/roots/$domain 2>/dev/null", $output, $retval);
        if ($retval != 0 ) {
            exec("mkdir -p /projeto-final/apache-files/roots/$domain/www");
            exec("mkdir -p /projeto-final/apache-files/roots/$domain/www/images");
            exec("mkdir -p /projeto-final/apache-files/roots/$domain/logs");
            exec("cp /projeto-final/apache-files/main_pages_management/core_web_site/www/images/Domain_manager_mini.png /projeto-final/apache-files/roots/$domain/www/images");
            $caminho = "/projeto-final/apache-files/roots/$domain/www/index.html";
            exec("chmod 777 -R /projeto-final/apache-files/roots/$domain/");
            exec("/projeto-final/apache-files/main_pages_management/core_web_site/www/criar_fist_site.sh $domain $caminho");
        }
        $base_dns = <<<END
//----------------------  BASE DNS FILE -----------------
zone "$domain" IN {
    type master;
    file "/projeto-final/dns-files/default.zone";
    allow-query { any; };
};

END;
        fwrite($dns_file, $base_dns);
        $base_apache = <<<END
#----------- BLOCO PADRÃO DO APACHE para os Domains ---------------------
<VirtualHost $BINDER>
        <Directory /projeto-final/apache-files/roots/$domain>
            AllowOverride all
            Require all granted
            Options Indexes
            DirectoryIndex index.php index.html
        </Directory>
        ServerAdmin root@$domain
        DocumentRoot "/projeto-final/apache-files/roots/$domain/www"
        ServerName $domain
        ServerAlias www.$domain
        ErrorLog "/projeto-final/apache-files/roots/$domain/logs/error-vp.log"
        CustomLog "/projeto-final/apache-files/roots/$domain/logs/acess-vp.log" common
</VirtualHost>
        
END;
        fwrite($apache_file, $base_apache);

        }

    }
}

fclose($dns_file);
fclose($apache_file); 
exec("/projeto-final/apache-files/main_pages_management/reload_apps");
if ($_SESSION["foward"] == "criar"){
    header("Location: criador_de_usuarios.php");
}
elseif ($_SESSION["foward"] == "excluir"){
    header("Location: exclusor_de_usuarios.php");
}


//# THIS IS A FILE NAMED Default.zone
//$TTL 30
//@ 	IN	SOA	@ root (
//	2022112307 	;serial
//	120		;refresh
//	60		;retry
//	300		;expiry
//	30		; Minimum
//	)
//
//@	IN 	NS	@	
//@	IN 	MX	5 	mail
//@		IN	A	192.168.102.162
//mail		IN	A	192.168.102.162
//@		IN	A	192.168.102.162
//www		IN	CNAME	@	
?>


