<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];
    $cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : null;

    // Verificar comprimento da senha
    if (strlen($senha) < 6) {
        // Mensagem de erro de senha curta
        $_SESSION['erro_registro'] = "A senha precisa ter no mínimo 6 caracteres.";
        header("Location: registrar.php"); // Redireciona de volta para a página de registro
        exit();
    }

    // Verificar se é um cadastro de estabelecimento
    if ($tipo === 'estabelecimento') {
        // Verificar se o CNPJ foi fornecido para estabelecimentos
        if (empty($cnpj) || strlen($cnpj) < 14) {
            $_SESSION['erro_registro'] = "CNPJ é obrigatório para estabelecimentos e deve ter pelo menos 14 dígitos.";
            header("Location: registrar.php");
            exit();
        }

        // Verificar se o email já está registrado (em ambas as tabelas)
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $_SESSION['erro_registro'] = "Este email já está em uso. Por favor, escolha outro.";
            header("Location: registrar.php");
            exit();
        }

        $sql = "SELECT * FROM estabelecimentos WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $_SESSION['erro_registro'] = "Este email já está em uso. Por favor, escolha outro.";
            header("Location: registrar.php");
            exit();
        }

        // Verificar se o CNPJ já está registrado
        $sql = "SELECT * FROM estabelecimentos WHERE cnpj = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $cnpj);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $_SESSION['erro_registro'] = "Este CNPJ já está cadastrado.";
            header("Location: registrar.php");
            exit();
        }

        // Inserir o novo estabelecimento no banco de dados
        $sql = "INSERT INTO estabelecimentos (nome, email, senha, cnpj) VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss", $nome, $email, password_hash($senha, PASSWORD_DEFAULT), $cnpj);
    } else {
        // Verificar se o email já está registrado (em ambas as tabelas)
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $_SESSION['erro_registro'] = "Este email já está em uso. Por favor, escolha outro.";
            header("Location: registrar.php");
            exit();
        }

        $sql = "SELECT * FROM estabelecimentos WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $_SESSION['erro_registro'] = "Este email já está em uso. Por favor, escolha outro.";
            header("Location: registrar.php");
            exit();
        }

        // Inserir o novo usuário no banco de dados
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss", $nome, $email, password_hash($senha, PASSWORD_DEFAULT), $tipo);
    }

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
    <style>
        .title-spacing {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro - Sistema de Clínica Veterinária</h1>
        
        <div class="form-box">
            <h2 class="title-spacing">Cadastro</h2>
            
            <!-- Exibição de mensagem de sucesso -->
            <?php if (isset($_SESSION['registro_sucesso'])): ?>
                <p class="success"><?php echo $_SESSION['registro_sucesso']; unset($_SESSION['registro_sucesso']); ?></p>
                <p>Você pode <a href="index.php">fazer login</a> agora.</p>
            <?php else: ?>
            <form action="registrar.php" method="POST">
                <label for="tipo">Tipo de usuário:</label>
                <select name="tipo" id="tipo" required onchange="mostrarCamposCNPJ()">
                    <option value="usuario">Usuário</option>
                    <option value="estabelecimento">Estabelecimento</option>
                </select>
                
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
                <p class="form-hint">A senha deve ter no mínimo 6 caracteres.</p>
                
                <label for="cnpj" id="labelCNPJ" style="display: none;">CNPJ:</label>
                <input type="text" id="cnpj" name="cnpj" style="display: none;">
                
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

    <script>
        // Função para mostrar/ocultar campo CNPJ
        function mostrarCamposCNPJ() {
            var tipo = document.getElementById('tipo').value;
            var campoCNPJ = document.getElementById('cnpj');
            var labelCNPJ = document.getElementById('labelCNPJ');
            
            if (tipo === 'estabelecimento') {
                campoCNPJ.style.display = 'block';
                labelCNPJ.style.display = 'block';
                document.querySelector('label[for="nome"]').textContent = 'Nome da Clínica:';
            } else {
                campoCNPJ.style.display = 'none';
                labelCNPJ.style.display = 'none';
                document.querySelector('label[for="nome"]').textContent = 'Nome:';
            }
        }

        // Chama a função ao carregar a página para garantir que os campos corretos sejam exibidos
        window.onload = function() {
            mostrarCamposCNPJ();
        }
    </script>
</body>
</html>
<?php
}
?>
