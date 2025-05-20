<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Verificar se é um usuário
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        // É um usuário
        $usuario = $resultado->fetch_assoc();
        
        if (password_verify($senha, $usuario['senha'])) {
            // Login bem-sucedido como usuário
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nome_usuario'] = $usuario['nome'];
            $_SESSION['email_usuario'] = $usuario['email'];
            $_SESSION['tipo_usuario'] = $usuario['tipo'];
            $_SESSION['logado'] = true;
            
            header("Location: painel_usuario.php");
            exit();
        } else {
            // Senha incorreta
            $_SESSION['erro_login'] = "Email ou senha incorretos.";
            header("Location: index.php");
            exit();
        }
    } else {
        // Verificar se é um estabelecimento
        $sql = "SELECT * FROM estabelecimentos WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            // É um estabelecimento
            $estabelecimento = $resultado->fetch_assoc();
            
            if (password_verify($senha, $estabelecimento['senha'])) {
                // Login bem-sucedido como estabelecimento
                $_SESSION['id_estabelecimento'] = $estabelecimento['id'];
                $_SESSION['nome_estabelecimento'] = $estabelecimento['nome'];
                $_SESSION['email_estabelecimento'] = $estabelecimento['email'];
                $_SESSION['cnpj_estabelecimento'] = $estabelecimento['cnpj'];
                $_SESSION['logado'] = true;
                $_SESSION['tipo_usuario'] = 'estabelecimento';
                
                header("Location: painel_estabelecimento.php");
                exit();
            } else {
                // Senha incorreta
                $_SESSION['erro_login'] = "Email ou senha incorretos.";
                header("Location: index.php");
                exit();
            }
        } else {
            // Usuário não encontrado
            $_SESSION['erro_login'] = "Email ou senha incorretos.";
            header("Location: index.php");
            exit();
        }
    }
} else {
    // Acesso direto ao arquivo sem POST
    header("Location: index.php");
    exit();
}
?>
