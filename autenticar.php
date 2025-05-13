<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 0) {
        $_SESSION['erro_login'] = "Email ou senha incorretos!";
        header("Location: index.php");
    } else {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['erro_login'] = null;
            $_SESSION['login_sucesso'] = "Login realizado com sucesso!";
            $_SESSION['usuario_id'] = $usuario['id']; // Armazenar ID do usuário para futuras sessões
            header("Location: index.php");
        } else {
            $_SESSION['erro_login'] = "Email ou senha incorretos!";
            header("Location: index.php");
        }
    }
}
?>
