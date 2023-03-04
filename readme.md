<!DOCTYPE html>
<html lang="en">
<head>
</head>

<body>
    <h1>☆ pagina de explicação do projeto ☆</h1><br>
    <div id="texto">
        
<h3 style="text-align:center" >Olá Saudações, sou julio cesar. </a></h3>  
        <img class="hi" src="APACHE/projeto-final/apache-files/welcome/www/images/hi.gif" width="300" heigth="300" />      
        <p>&emsp;&emsp;esse resultado é fruto do meu projeto da disciplica que chamamos de ASA( Administração de Sistemas Abertos ) da grade de Redes de computadores.
        onde aprendemos sobre DNS, DHCP, APACHE, FTP, serviço de email(Postfix/dovecot), basico de Banco de dados e PhP.
        </p>

<img src="APACHE/projeto-final/apache-files/welcome/www/images/php.png" alt="php" style="width:20%">
<img src="APACHE/projeto-final/apache-files/welcome/www/images/apache.png" alt="apache" style="width:20%">
<img src="APACHE/projeto-final/apache-files/welcome/www/images/MySQL-Logo.png" alt="mysql" style="width:20%">
<img src="APACHE/projeto-final/apache-files/welcome/www/images/docker.png" alt="docker" style="width:20%">

<p>no processo desenvolvimento foi dado um ambiente pelo professor com tudo instalado para cada aluno.
        após o termino do semestre resolvi desenvolver o ambiente em docker( no qual estudei por fora da materia ), tal esse que eu poderia demostrar em poucos comandos um ambiente
        que pode ser usado internamente de fomas adaptativas de forma persistente ou não.
        </p>
        <p>o ambiente criado conta com um (Mozilla firefox, Bind9, apache e php) e uma imagem com Mysql para o banco de dados.
        após o inicios #docker-compose up --build ou pode ser usado docker stack ele vai fazer o deploy das imagens e vai abrir uma interface grafica do firefox apontando para localhost que vai ter 3 paginas, 
        uma para visualizar essa pagina, outra para visualizar as tabelas importantes do banco de dados, principal a pagina de login cuja eu chamei http://domains.manager. <br>OBS:só possui acesso aos sites caso seja usado o servidor de DNS 172.20.0.2 .
        </p> 
        <img src="APACHE/projeto-final/apache-files/welcome/www/images/pagina-de-login.png" alt="pagina domains" style="width:70%">
        <p>após o acesso a http://domains.manager voce deve fazer o login com o seu tipo de usuario da Hierarquia abaixo:
            
<p>↣tipo root -> localizados na tabela root_users o root pode criar/excluir dominios acessaveis, troca sua senha de login e dos administradores de dominio.</p>
            criando novo dominio MiraiNikki:<br>
            <img src="APACHE/projeto-final/apache-files/welcome/www/images/root_user.png" alt="pagina domains" style="width:70%">
            <img src="APACHE/projeto-final/apache-files/welcome/www/images/criando_mirai.png" alt="pagina domains" style="width:70%">
            <img src="APACHE/projeto-final/apache-files/welcome/www/images/new_painel.png" alt="pagina domains" style="width:70%">
            <p>↣tipo adminstrador -> localizado na tabela ftpusers o adminstrador pode criar/excluir usuarios, troca sua senha de login e dos usuarios </p>
            criação de um novo Usuario:<br>
            <img src="APACHE/projeto-final/apache-files/welcome/www/images/painel_of_mirai.png" alt="pagina domains" style="width:70%">
            <img src="APACHE/projeto-final/apache-files/welcome/www/images/create_user_in_mirai.png" alt="pagina domains" style="width:70%">
            <img src="APACHE/projeto-final/apache-files/welcome/www/images/after_create_user_in_mirai.png" alt="pagina domains" style="width:70%">
            <p>↣tipo usuario -> localizado na tabela ftpusers o usuario pode apenas trocar a propia senha.</p>
            logando com o usuario criado acima:<br>
            <img src="APACHE/projeto-final/apache-files/welcome/www/images/login_with_user.png" alt="pagina domains" style="width:70%"><br>
            lembrando que caso o root crie um dominio MirraiNikki voce poderar acessar ele atraves de http://MiraiNikki ou http://www.MiraiNikki no seu navegador e terar uma pagina padrão preparada para voce.<br>
            <img src="APACHE/projeto-final/apache-files/welcome/www/images/login_dm_mirai.png" alt="pagina domains" style="width:70%"><br>
            caso voce feche o firefox e precise executar novamente use o seguinte comando:<br> #docker exec -it dns-server firefox localhost<br><br>
            para editar arquivos em runtime:<br>#docker exec -it dns-server bash<br>
</p>

<img class="hi" src="APACHE/projeto-final/apache-files/welcome/www/images/pikachu-sad-goodbye-vtr16falxzf2u06f.gif" width="300" heigth="300" />
        <p>Observações: esse codigo não foi feito pensando em segurança, a logo usada é fictícia, o codigo pode ser aprimorado em alguns requisitos, sinta-se livre para entrar em contato ou aprimorar o codigo de acordo com sua preferencia.</p>

<p> se voce quiser aprender mais sobre DNS acesse <a href="https://www.zytrax.com/books/dns/">livro sobre DNS</a>.<p>
 
</div>
 
</body>
</html>
