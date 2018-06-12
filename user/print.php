<?php
/**
 * Caso aja tentativa de acessar essa página sem passar pelo painel, irá ser redirecionado para o painel
 * Método para previnir acessos inadequados ao sistema
 */
session_start();
require('../_app/Config.inc.php');

// $quan= $_GET["usuario"];
// echo $quantidade;
// $userId = filter_input (INPUT_GET, 'usuario', FILTER_VALIDATE_INT);
// var_dump ($userId);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Confirmar dados</title>

    </head>
    <?php
            $userId = filter_input (INPUT_GET, 'aluno');
            $create = filter_input (INPUT_GET, 'create');
            var_dump($create);  
            var_dump ($userId);
            // $quan= $_GET['usuario'];
            // var_dump($quan);
            // $readUser = new Read;
            // $readUser->exeRead("users", "WHERE id = :id", "id={$userId}");
            
            // var_dump($readUser->getResult());
        ?>
    <body class="register">
        oi caralho
        <!-- <div id="register">
            <h1>Cadastro</h1>
            <form name="UserRegisterForm" action="..\_app\Models\boleto_itau.php" method="post">
            <label>
                <span>Nome:</span>
                <input type="name" name="name" id="name"/>
            </label>
            <br><br>
            <label>
                <span>Nome Final:</span>
                <input type="last_name" name="final_name" id="final_name"/>
            </label>
            <br><br>
            <input type="submit" name="UserRegister" value="Logar"/>
                    
            </form>
        </div> -->
    </body>
</html>