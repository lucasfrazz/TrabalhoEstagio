<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Se não estiver logado, redirecionar para a página de login
    header("Location: index.php");
    exit();
}

// Conexão com o banco de dados
$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "trabalhoestagio"; 

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Filtrar por tipo de transação
$tipo = isset($_GET['tipo_transacao']) ? $_GET['tipo_transacao'] : '';
$consulta = "SELECT * FROM transacoes_financeiras";

// Filtra por tipo, se especificado
if ($tipo) {
    $consulta .= " WHERE tipo_transacao = ?";
    $stmt = $conn->prepare($consulta);
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $tipo);
} else {
    $stmt = $conn->prepare($consulta);
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }
}

$stmt->execute();
$resultado = $stmt->get_result();

$transacoes = [];
while ($row = $resultado->fetch_assoc()) {
    $transacoes[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="listagem.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <style>
      
    </style>
    <title>Listagem de Transações</title>
</head>
<body>
    <div class="container">
        <div class="text-center my-4">
        <img src="img/logo.png" alt="Logo" width="300px">
        </div>
   
        <div class="form-container">
          

              <!-- Exibir Transações -->
            <div class='product-list'>
                <?php if (!empty($transacoes)): ?>
                    <?php foreach ($transacoes as $transacao): ?>
                        <div class='product-card'>
                            <h2 class='product-title'><?php echo htmlspecialchars($transacao['nome']); ?></h2>
                            <p><strong>Categoria:</strong> <?php echo htmlspecialchars($transacao['categoria']); ?></p>
                            <p><strong>Tipo:</strong> <?php echo htmlspecialchars($transacao['tipo_transacao']); ?></p>
                            <p><strong>Outros:</strong> <?php echo htmlspecialchars($transacao['outros']); ?></p>
                            <p><strong>Valor:</strong> <?php echo htmlspecialchars($transacao['valor']); ?></p>
                            <p><strong>Descrição:</strong> <?php echo htmlspecialchars($transacao['descricao']); ?></p>
                            <p><strong>Data:</strong> <?php echo htmlspecialchars($transacao['data_criacao']); ?></p>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-product">Nenhuma transação encontrada.</div>
                    <?php endif; ?>
                </div>
            </div>
          
            <p><a href="javascript:history.go(-1)">Voltar</a></p>
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
