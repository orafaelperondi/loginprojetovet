<?php
session_start();

// Verificar se o estabelecimento está logado
if (!isset($_SESSION['logado']) || $_SESSION['tipo_usuario'] !== 'estabelecimento') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel da Clínica - Sistema de Clínica Veterinária</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Painel da Clínica</h1>
            <p>Bem-vindo(a), <?php echo $_SESSION['nome_estabelecimento']; ?>!</p>
            <p>CNPJ: <?php echo $_SESSION['cnpj_estabelecimento']; ?></p>
        </header>
        
        <div class="content">
            <div class="card">
                <h2>Agenda</h2>
                <p>Gerencie sua agenda de consultas e procedimentos.</p>
                <a href="#" class="button">Ver Agenda</a>
            </div>
            
            <div class="card">
                <h2>Pacientes</h2>
                <p>Visualize e gerencie os pacientes atendidos pela clínica.</p>
                <a href="#" class="button">Gerenciar Pacientes</a>
            </div>
            
            <div class="card">
                <h2>Serviços</h2>
                <p>Configure os serviços oferecidos pela sua clínica.</p>
                <a href="#" class="button">Gerenciar Serviços</a>
            </div>

            <div class="card">
                <h2>Perfil da Clínica</h2>
                <p>Atualize as informações da sua clínica.</p>
                <a href="#" class="button">Editar Perfil</a>
            </div>
        </div>
        
        <footer>
            <a href="logout.php" class="button">Sair</a>
        </footer>
    </div>
</body>
</html> 