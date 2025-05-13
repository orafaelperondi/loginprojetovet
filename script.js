document.getElementById('btnLogin').addEventListener('click', function() {
    document.getElementById('formContainer').style.display = 'block';
    document.getElementById('loginForm').style.display = 'block';
    document.getElementById('cadastrarForm').style.display = 'none';
});

document.getElementById('btnCadastrar').addEventListener('click', function() {
    document.getElementById('formContainer').style.display = 'block';
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('cadastrarForm').style.display = 'block';
});

function fecharFormulario() {
    document.getElementById('formContainer').style.display = 'none';
}
