<?php
$acao = $_GET['acao'] ?? '';
if ($acao === 'login') {
    echo "<h2>Login efetuado com sucesso!</h2>";
} elseif ($acao === 'cadastro') {
    echo "<h2>Cadastro realizado com sucesso!</h2>";
}
echo '<a href="index.html">Voltar</a>';
?>
