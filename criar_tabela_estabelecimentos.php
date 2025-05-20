<?php
include('conexao.php');

// Criar tabela estabelecimentos se não existir
$sql = "CREATE TABLE IF NOT EXISTS estabelecimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    cnpj VARCHAR(18) NOT NULL UNIQUE,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conexao->query($sql) === TRUE) {
    echo "Tabela 'estabelecimentos' criada com sucesso ou já existe!";
} else {
    echo "Erro ao criar tabela: " . $conexao->error;
}

$conexao->close();
?> 