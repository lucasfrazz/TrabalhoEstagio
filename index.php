<?php
// Iniciar a sessão
session_start();

// Verificar se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost"; 
    $username = "root";
    $password = ""; 
    $dbname = "trabalhoestagio"; 
 
    
    // Cria a conexão
    $conn = new mysqli($servername, $username, $password, $dbname,);
    
    // Verifica a conexão
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "";
    
    
    // Obter os dados do formulário
    $email_input = $_POST['email'];
    $password_input = $_POST['password'];
    $username_input =$_POST['username'];

    // Consulta SQL para verificar as credenciais
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email_input);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar se o resultado da consulta possui pelo menos uma linha
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password_input, $row['password'])) {
            // As credenciais estão corretas, então iniciar a sessão
            $_SESSION['username'] = $row['username'];
            $_SESSION['loggedin'] = true;
            // Redirecionar para a página principal
            header("Location: gerenciamento.php");
            exit();
        } else {
            // As credenciais estão incorretas, definir mensagem de erro
            $error = '<span style="color: white;">Usuário ou senha incorretos. Por favor, tente novamente.</span>';
        }
    } else {
        // O usuário não foi encontrado, definir mensagem de erro
        $error = '<span style="color: white;">Usuário ou senha incorretos. Por favor, tente novamente.</span>';
    }

    // Fechar conexão
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="login.css">
<ink rel="shortcut icon" href="img/logo.png" type="image/x-icon">

<title>Gerenciamento de Transação</title>
</head>
<body>
<div class="container">
        
        <div class="text-center my-4">
        <img src="img/logo.png" alt="Logo" width="300px">
    </div>
    
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h1>Área de acesso</h1>
    <?php if(isset($error)) echo '<p style="color: red;">'.$error.'</p>'; ?>
    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario; ?>">

    <label for=""><strong>Email:</strong></label>
    <input type="email" class="form-control" name="email" placeholder="Digite seu Email" required><br>

    <label for=""><strong>Senha:</strong></label>
    <input type="password" class="form-control" name="password" placeholder="Senha de acesso" required><br>

    <input type="submit" id="butao" value="Entrar">

    <p><a href="CadastrodeUsuário.html">Não tenho cadastro ainda </a></p>
</form>
</body>
</html>
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