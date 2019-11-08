<?php
    session_start();
    require 'config.php';

    // Seta como vazio o valor da sessão quando é deslogado.
    $_SESSION['lg'] = '';

    // Verifica se o email foi enviado pelo formulário e se ele não está vazio.
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        // Email e senha são salvos.
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Consulta no banco de dados.
        $sql = "SELECT * FROM usuarios WHERE email = :email AND senha = MD5(:senha)";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", $senha);
        $sql->execute();

        // Se existir o usuário no banco de dados, seu id e ip são salvos.
        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $id = $sql['id'];
            $ip = $_SERVER['REMOTE_ADDR'];

            // O id é setado como a sessão do usuário.
            $_SESSION['lg'] = $id;
            
            // O ip é atualizado no banco de dados e o usuário é redirecionado ao index.
            $sql = "UPDATE usuarios SET ip = :ip WHERE id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(":ip", $ip);
            $sql->bindValue(":id", $id);
            $sql->execute();

            header("Location: index.php");
            exit;
        }
    }
?>
<meta charset="utf-8"/>
<h1>Login</h1>
<form method="POST">
    E-mail:<br/>
    <input type="email" name="email" /> <br/><br/>

    Senha:<br/>
    <input type="password" name="senha" /> <br/><br/>

    <input type="submit" value="Entrar" />
</form>