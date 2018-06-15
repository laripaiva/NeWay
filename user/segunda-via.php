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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>NeWay - Boleto</title>
    <link rel="shortcut icon" href="media/neway2.png" type="image/x-icon"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/segundavia.css">
</head>

<body class="login">
    <div class="container">
        <div class="row"> 
            <div class="col l12">
                <h3 class="center-align "> 2ª Via de Boleto</h3>
                <form name="ConfirmForm" class="formu z-depth-5" action="..\_app\Models\boleto_itau.php" method="post">

                    <p>Confirme os dados a seguir: </p>
                    <div class="row"> 
                        <div class="col l6">
                            <div class="input-field ">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="name" type="text" name="nome" value="<?php echo $nome;?>"/>
                                <label for="name">Nome</label>
                            </div>
                        </div>

                        <div class="col l6">
                            <div class="input-field ">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="nmf" type="text" name="nome_final" value="<?php echo $nomef;?>"/>
                                <label for="nmf">Nome Final:</label>
                            </div>
                        </div>
                        <div class="col l12 m12 s12">
                            <p>Informe os dados para gerar o boleto: </p> 
                        </div>

                        <div class="col l6">
                            <div class="input-field ">
                                <i class="material-icons prefix">my_location</i>
                                <input type="text" name="CEP" id="cep" value="" size="10" maxlength="9" onblur="pesquisacep(this.value);"/>
                                <label for="cep">CEP:</label>
                            </div>
                            <div class="input-field ">
                                <i class="material-icons prefix">location_on</i>
                                <input type="text" name="endereco" id="rua"/>
                                <label for="rua">Rua:</label>
                            </div>
                            <div class="input-field ">
                                <i class="material-icons prefix">home</i>
                                <input type="text" name="bairro" id="bairro"/>
                                <label for="bairro">Bairro</label>
                            </div>

                        </div>
                        <div class="col l6">
                            <div class="input-field ">
                                <i class="material-icons prefix">assistant_photo</i>
                                <input type="number" name="numero" id="num" />
                                <label for="num">Número:</label>
                            </div>
                            <div class="input-field ">
                                <i class="material-icons prefix">location_city</i>
                                <input type="text" name="cidade" id="cidade"/>
                                <label for="cidade">Cidade</label>
                            </div>
                            <div class="input-field ">
                                <i class="material-icons prefix">landscape</i>
                                <input type="text" name="estado" id="uf"/>
                                <label for="uf">Estado</label>
                            </div>
                        </div>
                        <div class="col l12 m12 s12 center-align">
                        <input class="center-align btn-large  light-blue darken-4" type="submit" name="UserRegister" value="Imprimir boleto"/>
                    </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./js/cep.js"></script>
    <script src="js/jquery-3.3.1.js" type="text/javascript" charset="utf-8" async defer></script>
    <script src="js/materialize.js"></script>
</body>
</html>
