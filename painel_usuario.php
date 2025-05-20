<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['tipo_usuario'] !== 'usuario') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário - Sistema de Clínica Veterinária</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Painel do Usuário</h1>
            <p>Bem-vindo(a), <?php echo $_SESSION['nome_usuario']; ?>!</p>
        </header>
        
        <div class="content">
            <div class="card">
                <h2>Meus Pets</h2>
                <p>Aqui você pode gerenciar seus animais de estimação.</p>
                <a href="#" class="button">Gerenciar Pets</a>
            </div>
            
            <div class="card">
                <h2>Agendar Consulta</h2>
                <p>Agende consultas para seus pets em clínicas veterinárias.</p>
                <a href="#" class="button">Agendar</a>
            </div>
            
            <div class="card">
                <h2>Minhas Consultas</h2>
                <p>Visualize suas consultas agendadas e histórico.</p>
                <a href="#" class="button">Ver Consultas</a>
            </div>
        </div>
        
        <footer>
            <a href="logout.php" class="button">Sair</a>
        </footer>
    </div>
</body>
</html> 