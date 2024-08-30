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
<link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="gerenciamento.css">
    <ink rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>Gerenciar transações financeiras</title>
 
</head>
<body>
<?php
    

    // Verificar se o usuário está logado
    if(isset($_SESSION['username'])) {
        echo '<span style="color: white;">  Bem Vindo: ' . $_SESSION['username'] . '</span>';
    }
    ?>

<div class="container">
        
        <div class="text-center my-4">
        <img src="img/logo.png" alt="Logo" width="300px">
    </div>
    <div class="corner">
   
    
        <button class="logout-button" onclick="window.location.href='logout.php'">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16" alt="Logout">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
            </svg>
        </button>
    </div>
        <h1>Bem-vindo</h1>
        <p id="apresentacao">Este é o sistema Para Gerenciar suas Transações Financeiras.</p>
    </div>

   

    <main>

        <h1>Gerenciamento</h1>

        <p><a href='Cadastroproduto.php'><button>Cadastro Financeiro</button></a></p>
        <p><a href='pesquisa.php'><button>Listagem Financeira</button></a></p>
        <p><a href='alteraproduto.php'><button>Alterar Receitas e Despesas</button></a></p>
        
    </main>
    </style>
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
