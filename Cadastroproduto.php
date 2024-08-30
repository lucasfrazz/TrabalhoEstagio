<?php
// Exibir mensagens com base no parâmetro de query
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        echo '<div class="alert alert-success">Transação cadastrada com sucesso!</div>';
    } elseif ($_GET['status'] == 'error') {
        echo '<div class="alert alert-danger">Erro ao cadastrar a transação. Tente novamente.</div>';
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="cadastroProduto.css">
    <title>Gerenciamento de Transação</title>
</head>

<body>
<div class="container">
        
    <div class="text-center my-4">
    <img src="img/logo.png" alt="Logo" width="300px">
   
        <form id="cadastroForm" action="cadastro.php" method="post">

            <h1>Cadastro Financeiro</h1>

            <label for="nome"><strong>Nome:</strong></label>
            <input type="text" class="form-control" id="nome" name="nome" placeholder="" required><br>

            <label for="tipo_transacao"><strong>Tipo de Transação:</strong></label>
            <select class="form-control" id="tipo_transacao" name="tipo_transacao" required>
                <option value="receita">Receita</option>
                <option value="despesa">Despesa</option>
            </select><br>

            <label for="categoria"><strong>Categoria:</strong></label>
            <select class="form-control" id="categoria" name="categoria" required>
            <option value="outros">Outros</option>
                <option value="aluguel">Aluguel</option>
                <option value="pagamento">Pagamento</option>
                <option value="prolabore">Prolabore</option>
                <option value="luz">Luz</option>
                <option value="agua">Água</option>
                <option value="escola">Escola</option>
                <option value="internet">Internet</option>
                       <!-- Adicione mais opções conforme necessário -->
            </select><br>

            <label for="Outros"><strong>Outra Categoria</strong></label>
            <input type="text" class="form-control" id="Outros" name="Outros" placeholder="Outros" ><br>

            <label for="preco_produto"><strong>Valor (R$):</strong></label>
            <input type="text" class="form-control" id="preco_produto" name="preco_produto" placeholder="Valor" required><br>

            <label for="descricao"><strong>Descrição:</strong></label>
            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição do Produto (OPCIONAL)"><br>

            <input type="submit" id="butao" class="btn btn-primary" value="Salvar Transação">

         
            <p class="text-center mt-3"><a href="gerenciamento.php">Voltar</a></p>

        </form>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#cadastroForm').submit(function(e) {
        var tipoTransacao = $('#tipo_transacao').val();
        var precoProduto = $('#preco_produto').val();

        if (!isValidNumber(precoProduto)) {
            alert('Por favor, insira valores numéricos válidos no campo de valor.');
            e.preventDefault();
        } else {
            // Se for uma despesa, o valor deve ser salvo como negativo
            if (tipoTransacao === 'despesa') {
                $('#preco_produto').val('-' + precoProduto);
            }
        }
    });

    // Função para validar números com vírgula
    function isValidNumber(value) {
        return /^-?\d{1,3}(?:\.?\d{3})*(?:,\d{1,2})?$/.test(value);
    }
});
</script>

</body>

</html>
