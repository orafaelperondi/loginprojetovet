<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    // Verificar comprimento da senha
    if (strlen($senha) < 6) {
        // Mensagem de erro de senha curta
        $_SESSION['erro_registro'] = "A senha precisa ter no mínimo 6 caracteres.";
        header("Location: registrar.php"); // Redireciona de volta para a página de registro
        exit();
    }

    // Verificar se o email já está registrado
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Mensagem de erro de email duplicado
        $_SESSION['erro_registro'] = "Este email já está em uso. Por favor, escolha outro.";
        header("Location: registrar.php"); // Redireciona de volta para a página de registro
        exit();
    }

    // Inserir o novo usuário no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, password_hash($senha, PASSWORD_DEFAULT), $tipo);
    if ($stmt->execute()) {
        // Mensagem de sucesso
        $_SESSION['registro_sucesso'] = "Cadastro realizado com sucesso!";
        header("Location: registrar.php"); // Mantém na página de registro com mensagem de sucesso
        exit();
    } else {
        // Mensagem de erro genérico
        $_SESSION['erro_registro'] = "Erro ao cadastrar. Tente novamente.";
        header("Location: registrar.php"); // Redireciona de volta para a página de registro
        exit();
    }
}

// Se acessar diretamente esta página (GET), exibe o formulário
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Sistema de Clínica Veterinária</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Cadastro - Sistema de Clínica Veterinária</h1>
        
        <div class="form-box">
            <h2>Cadastro</h2>
            
            <!-- Exibição de mensagem de sucesso -->
            <?php if (isset($_SESSION['registro_sucesso'])): ?>
                <p class="success"><?php echo $_SESSION['registro_sucesso']; unset($_SESSION['registro_sucesso']); ?></p>
                <p>Você pode <a href="index.php">fazer login</a> agora.</p>
            <?php else: ?>
            <form action="registrar.php" method="POST">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
                <p class="form-hint">A senha deve ter no mínimo 6 caracteres.</p>
                <label for="tipo">Tipo de usuário:</label>
                <select name="tipo" id="tipo" required>
                    <option value="usuario">Usuário</option>
                    <option value="admin">Administrador</option>
                </select>
                <label for="senha_mestre">Senha Mestre (somente para admin):</label>
                <input type="password" id="senha_mestre" name="senha_mestre">
                <button type="submit">Cadastrar</button>
            </form>
            <?php endif; ?>
            
            <!-- Exibição de mensagens de erro -->
            <?php if (isset($_SESSION['erro_registro'])): ?>
                <p class="error"><?php echo $_SESSION['erro_registro']; unset($_SESSION['erro_registro']); ?></p>
            <?php endif; ?>
        </div>
        
        <div class="actions">
            <a href="index.php">Voltar para a página inicial</a>
        </div>
    </div>
</body>
</html>
<?php
}
?>
