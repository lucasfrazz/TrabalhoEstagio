<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Se não estiver logado, redirecionar para a página de login
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="alteraproduto.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>Gerenciamento de Transação</title>
</head>
<body>
<div class="container">
        
        <div class="text-center my-4">
        <img src="img/logo.png" alt="Logo" width="300px">
    </div>

        <form action="resultadoeditar.php" method="GET">
            <h1>Editar Transação</h1>
            <label for="produto"><strong>Nome de Transação </strong> </label>
            <input type="text" class="form-control" id="tipo_transacao" name="tipo_transacao" placeholder="Digite o tipo de Transação" required><br>
            <input type="submit" id="butao" class="btn btn-primary" value="Alterar">
            <p><a href="javascript:history.go(-1)">Voltar</a></p>
        </form>
    </div>
    <script>
    // Função para destruir a sessão quando a página é fechada
    $(window).on('beforeunload', function() {
        $.ajax({
            url: 'logout.php',
            type: 'POST',
            async: false,
            success: function(response) {
                console.log('Sessão destruída');
            },
            error: function(xhr, status, error) {
                console.error('Erro ao destruir a sessão:', error);
            }
        });
    });
</script>
</body>
</html>
