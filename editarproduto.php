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
    <link rel="stylesheet" href="editarproduto.css">
   <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
   <title>Gerenciamento de Transação</title>
</head>
<body>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
        $tipo_transacao = $_GET['id'];

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
        echo "";
        

        // Consultar o produto pelo id
        $sql = "SELECT * FROM transacoes_financeiras WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tipo_transacao);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar se o produto foi encontrado
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
    <div class="container">
        
    <div class="text-center my-4">
    <img src="img/logo.png" alt="Logo" width="300px">
</div>
    <form action="atualizar_produto.php" method="POST">

    <h1>Editar</h1>

<form method="POST" action="atualizar_produto.php">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

    <label for="nome"><strong>Nome:</strong></label>
    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($row['nome']); ?>" required><br>

    <label for="tipo_transacao"><strong>Tipo de Transação:</strong></label>
    <select class="form-control" id="tipo_transacao" name="tipo_transacao" required>
        <option value="receita" <?php echo ($row['tipo_transacao'] == 'receita') ? 'selected' : ''; ?>>Receita</option>
        <option value="despesa" <?php echo ($row['tipo_transacao'] == 'despesa') ? 'selected' : ''; ?>>Despesa</option>
    </select><br>

    <label for="categoria"><strong>Categoria:</strong></label>
    <select class="form-control" id="categoria" name="categoria" required>
        <option value="outros" <?php echo ($row['categoria'] == 'outros') ? 'selected' : ''; ?>>Outros</option>
        <option value="aluguel" <?php echo ($row['categoria'] == 'aluguel') ? 'selected' : ''; ?>>Aluguel</option>
        <option value="pagamento" <?php echo ($row['categoria'] == 'pagamento') ? 'selected' : ''; ?>>Pagamento</option>
        <option value="prolabore" <?php echo ($row['categoria'] == 'prolabore') ? 'selected' : ''; ?>>Prolabore</option>
        <option value="luz" <?php echo ($row['categoria'] == 'luz') ? 'selected' : ''; ?>>Luz</option>
        <option value="agua" <?php echo ($row['categoria'] == 'agua') ? 'selected' : ''; ?>>Água</option>
        <option value="escola" <?php echo ($row['categoria'] == 'escola') ? 'selected' : ''; ?>>Escola</option>
        <option value="internet" <?php echo ($row['categoria'] == 'internet') ? 'selected' : ''; ?>>Internet</option>
       
    </select><br>

    <label for="outros"><strong>Outros:</strong></label>
    <input type="text" class="form-control" id="outros" name="outros" value="<?php echo htmlspecialchars($row['outros']); ?>" required><br>

    <label for="valor"><strong>Valor (R$):</strong></label>
    <input type="text" class="form-control" id="valor" name="valor" value="<?php echo number_format($row['valor'], 2, ',', '.'); ?>" required><br>

    <label for="data"><strong>Data:</strong></label>
    <input type="datetime-local" class="form-control" id="data" name="data_criacao" value="<?php echo date('Y-m-d\TH:i:s', strtotime($row['data_criacao'])); ?>" required><br>

    <input type="submit" id="butao" value="Salvar Alterações">
</form>



        <p><a href="javascript:history.go(-1)">Voltar</a></p>
    </form>
    <?php
        } else {
            echo "<p>Produto não encontrado.</p>";
        }

        // Fechar conexão
        $conn->close();
    } else {
        echo "<p>Produto não especificado.</p>";
    }
    
    ?>
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
