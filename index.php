<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Clínica Veterinária</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de Clínica Veterinária</h1>

        <!-- Caixa de Login e Cadastro -->
        <div class="form-box" id="formBox">
            <!-- Formulário de Login -->
            <div id="loginForm" class="form-container" style="display: <?php echo isset($_SESSION['erro_login']) ? 'block' : 'none'; ?>;">
                <h2>Login</h2>
                <form action="autenticar.php" method="POST">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                    <button type="submit">Entrar</button>
                </form>
                <!-- Exibição de erro de login -->
                <?php if (isset($_SESSION['erro_login'])): ?>
                    <p class="error"><?php echo $_SESSION['erro_login']; unset($_SESSION['erro_login']); ?></p>
                <?php endif; ?>
                <!-- Exibição de sucesso após login -->
                <?php if (isset($_SESSION['login_sucesso'])): ?>
                    <p class="success"><?php echo $_SESSION['login_sucesso']; unset($_SESSION['login_sucesso']); ?></p>
                <?php endif; ?>
            </div>

            <!-- Formulário de Cadastro -->
            <div id="registerForm" class="form-container" style="display: <?php echo isset($_SESSION['erro_registro']) || isset($_SESSION['registro_sucesso']) ? 'block' : 'none'; ?>;">
                <h2>Cadastro</h2>
                <form action="registrar.php" method="POST">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                    <label for="tipo">Tipo de usuário:</label>
                    <select name="tipo" id="tipo" required>
                        <option value="usuario">Usuário</option>
                        <option value="admin">Administrador</option>
                    </select>
                    <button type="submit">Cadastrar</button>
                </form>
                <!-- Exibição de erro de cadastro -->
                <?php if (isset($_SESSION['erro_registro'])): ?>
                    <p class="error"><?php echo $_SESSION['erro_registro']; unset($_SESSION['erro_registro']); ?></p>
                <?php endif; ?>
                <!-- Exibição de sucesso de cadastro -->
                <?php if (isset($_SESSION['registro_sucesso'])): ?>
                    <p class="success"><?php echo $_SESSION['registro_sucesso']; unset($_SESSION['registro_sucesso']); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="actions">
            <!-- Botões para alternar entre login e cadastro -->
            <button id="showLogin" onclick="showLogin()">Já tem conta? Faça login</button>
            <button id="showRegister" onclick="showRegister()">Não tem conta? Cadastre-se</button>
        </div>
    </div>

    <script>
        // Função para exibir o formulário de login
        function showLogin() {
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('registerForm').style.display = 'none';
            document.getElementById('showLogin').style.display = 'none';
            document.getElementById('showRegister').style.display = 'inline-block';
        }

        // Função para exibir o formulário de cadastro
        function showRegister() {
            document.getElementById('registerForm').style.display = 'block';
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('showRegister').style.display = 'none';
            document.getElementById('showLogin').style.display = 'inline-block';
        }

        // Exibe o login por padrão quando a página é carregada
        window.onload = function() {
            showLogin();
        }
    </script>
</body>
</html>
