<?php

// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Se não estiver logado, redirecionar para a página de login
    header("Location: index.php");
    exit();
}

// Verificar se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    // Obter os dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $tipo_transacao = $_POST['tipo_transacao'];
    $categoria = $_POST['categoria'];
    $outros = $_POST['outros'];
    $descricao = $_POST['descricao'];  // Certifique-se de que o campo "descricao" existe no formulário
    $valor = str_replace(',', '.', $_POST['valor']); 
    $data_criacao = date('Y-m-d H:i:s', strtotime($_POST['data_criacao']));  // Converte o formato da data para o padrão MySQL

    // Atualizar o produto no banco de dados usando consulta preparada
    $sql = "UPDATE transacoes_financeiras SET 
            nome = ?, 
            tipo_transacao = ?, 
            categoria = ?, 
            outros = ?, 
            descricao = ?, 
            valor = ?, 
            data_criacao = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssdsi", $nome, $tipo_transacao, $categoria, $outros, $descricao, $valor, $data_criacao, $id);

    if ($stmt->execute() === TRUE) {
        echo "<script>alert('Produto atualizado com sucesso.'); window.location.replace('gerenciamento.php');</script>";
    } else {
        echo "Erro ao atualizar o produto: " . $stmt->error;
    }

    // Fechar conexão
    $stmt->close();
    $conn->close();
}
?>
