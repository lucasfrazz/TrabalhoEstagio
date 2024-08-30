<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Se não estiver logado, redirecionar para a página de login
    header("Location: index.php");
    exit();
}

// Verificar se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificar se há transações selecionadas para exclusão
    if (isset($_POST['produtos']) && !empty($_POST['produtos'])) {

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

        // Preparar e executar a exclusão de cada transação selecionada
        $ids = $_POST['produtos'];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $conn->prepare("DELETE FROM transacoes_financeiras WHERE id IN ($placeholders)");

        // Bind dos parâmetros
        $types = str_repeat('i', count($ids));
        $stmt->bind_param($types, ...$ids);

        if ($stmt->execute() === TRUE) {
            echo "<script>alert('Transações excluídas com sucesso.'); window.location.replace('gerenciamento.php');</script>";
        } else {
            echo "Erro ao excluir as transações: " . $stmt->error;
        }

        // Fechar a declaração e a conexão
        $stmt->close();
        $conn->close();
    } else {
        echo "<script>alert('Nenhuma transação selecionada para exclusão.'); window.location.href = 'gerenciamento.php';</script>";
    }
} else {
    echo "<script>alert('Requisição inválida.'); window.location.href = 'gerenciamento.php';</script>";
}
?>
