<?php

session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Se não estiver logado, redirecionar para a página de login
    header("Location: index.php");
    exit();
}
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "trabalhoestagio";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $nome = $_POST['nome']; // Nome da transação
    $tipo_transacao = $_POST['tipo_transacao']; // Tipo de transação (receita ou despesa)
    $categoria = $_POST['categoria']; // Categoria da transação
    $outros = $_POST['Outros']; // Campo "Outros"
    $valor = $_POST['preco_produto']; // Valor da transação
    $descricao = $_POST['descricao']; // Descrição opcional

    // Verifica se a transação é uma despesa e ajusta o valor para negativo
    if ($tipo_transacao == 'despesa') {
        $valor = -abs(floatval(str_replace(',', '.', str_replace('.', '', $valor))));
    } else {
        $valor = floatval(str_replace(',', '.', str_replace('.', '', $valor)));
    }

    // Prepara a instrução SQL
    $sql = "INSERT INTO transacoes_financeiras (nome, tipo_transacao, categoria, outros, valor, descricao)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Usa prepared statements para proteger contra SQL Injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssids", $nome, $tipo_transacao, $categoria, $outros, $valor, $descricao);

    // Executa a query e redireciona
    if ($stmt->execute()) {
        // Redireciona para cadastroproduto.php com uma mensagem de sucesso
        header("Location: cadastroproduto.php?status=success");
        exit();
    } else {
        // Redireciona para cadastroproduto.php com uma mensagem de erro
        header("Location: cadastroproduto.php?status=error");
        exit();
    }

    // Fecha o statement e a conexão
    $stmt->close();
    $conn->close();
}
?>
