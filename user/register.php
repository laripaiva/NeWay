<?php
session_start();
require('../_app/Config.inc.php');

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/admin.css" />
        <link rel="stylesheet" type="text/css" href="css\style.css" />
        <script type="text/javascript" src="./js/cep.js"></script>
    </head>
    <body class="register">
        <div id="register">
            <h1>Cadastro</h1>
            <form name="UserRegisterForm" action="" method="post">
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
            <label>
                <span>E-mail:</span>
                <input type="email" name="email" id="email"/>
            </label>
            <br><br>
            <label>
                <span>Senha:</span>
                <input type="password" name="pass" id="pass"/>
            </label>
            <input type="submit" name="UserRegister" value="Cadastrar"/>
            </form>
            <?php
                $register = new Register;
                $dataRegister = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                var_dump ($dataRegister);

                if (!empty($dataRegister['UserRegister'])){
                    $register->exeRegister($dataRegister);
                    frontErro($register->getError()[0], $register->getError()[1]);
                    if (!$register->getResult()){
                        frontErro($register->getError()[0], $register->getError()[1]);
                    }
                }
            ?>
            <?php
                if ($register->getResult()){
                    $search = new Read;
                    $search->exeRead ("users", "WHERE id = :id", "id={$register->getResult()}");
                    $print = $search->getResult()[0];
                    var_dump($print);

            ?>
                <form name="ConfirmForm" action="..\_app\Models\boleto_itau.php" method="post">
                <p>Confirme os dados a seguir: </p>
                <label>
                    <span>Nome: </span>
                    <input type="text" name="nome" value="<?php echo $print['nome'];?>"/>
                </label>
                <br><br>
                <label>
                    <span>Nome Final:</span>
                    <input type="text" name="nome_final" value="<?php echo $print['nome_final'];?>"/>
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
            <?php
            }
            ?>
        </div>
    </body>
</html>
