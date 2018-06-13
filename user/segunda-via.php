<?php
session_start();
require('../_app/Config.inc.php');

$id = filter_input(INPUT_GET, 'aluno');
$nome = filter_input(INPUT_GET, 'nome');
$nomef = filter_input(INPUT_GET, 'sobrenome');

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Segunda Via</title>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/admin.css" />
        <link rel="stylesheet" type="text/css" href="css\style.css" />
        <script type="text/javascript" src="./js/cep.js"></script>

    </head>
    <body class="login">
    <form name="ConfirmForm" action="..\_app\Models\boleto_itau.php" method="post">
        <p>Confirme os dados a seguir: </p>
        <label>
            <span>Nome: </span>
            <input type="text" name="nome" value="<?php echo $nome;?>"/>
        </label>
        <br><br>
        <label>
            <span>Nome Final:</span>
            <input type="text" name="nome_final" value="<?php echo $nomef;?>"/>
        </label>
        <p>Informe os dados para gerar o boleto: </p>
        <label>
            <span>CEP:</span>
            <input type="text" name="CEP" id="cep" value="" size="10" maxlength="9"
                   onblur="pesquisacep(this.value);"/>
        </label>

        <label>
            <span>Rua:</span>
            <input type="text" name="endereco" id="rua"/>
        </label>
        <label>
            <span>Bairro:</span>
            <input type="text" name="bairro" id="bairro"/>
        </label>
        <label>
            <span>Numero:</span>
            <input type="number" name="numero" />
        </label>
        <label>
            <span>Cidade:</span>
            <input type="text" name="cidade" id="cidade"/>
        </label>
        <label>
            <span>Estado:</span>
            <input type="text" name="estado" id="uf"/>
        </label>
        <input type="submit" name="UserRegister" value="Imprimir boleto"/>
        </form>
    </body>
</html>
