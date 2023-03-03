<?php
if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['email'])) {
    die("Voce não está logado, por favor faça o login. <p><a href=\"index.php\">Entrar</a></p>");
}

?>