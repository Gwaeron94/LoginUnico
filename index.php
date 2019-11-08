<?php
    session_start();
    require 'config.php';

    // Verifica se existe uma sessão logada.
    if(empty($_SESSION['lg'])) {
        header("Location: login.php");
        exit;
    } else {

        // Se existir, o id e o ip do usuário são salvos.
        $id = $_SESSION['lg'];
        $ip = $_SERVER['REMOTE_ADDR'];

        // Verificando se o ip é o mesmo do último login realizado.
        $sql = "SELECT * FROM usuarios WHERE id = :id AND ip = :ip";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":ip", $ip);
        $sql->execute();

        // Se não for o mesmo ip, o usuário é redirecionado à página de login.
        if($sql->rowCount() == 0) {
            header("Location: login.php");
        }
    }
?>
<meta charset="utf-8"/>
<h1>Conteúdo Confidencial</h1>