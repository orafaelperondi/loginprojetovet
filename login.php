<?php
$erro = $_GET['erro'] ?? '';
?>

<h2>Login</h2>
<form action="autenticar.php" method="POST">
  Email: <input type="email" name="email" required><br>
  Senha: <input type="password" name="senha" required><br>
  <input type="submit" value="Entrar">
</form>

<?php
if ($erro === 'senha_incorreta') {
    echo "<p style='color:red;'>Senha incorreta. Tente novamente.</p>";
} elseif ($erro === 'usuario_nao_encontrado') {
    echo "<p style='color:red;'>Usuário não encontrado. Verifique o email.</p>";
}
?>
