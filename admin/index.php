<?php
session_start();
require('../_app/Config.inc.php');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Neway - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="imagens/neway2.png" type="image/x-icon"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" href="css/admin.css" />
    <link rel="stylesheet" href="css/dashboard.css">


</head>
<style type="text/css">
    .log{background-color: #800000; color: white; margin-top: 10%; padding: 5%; border-radius: 35px;}
</style>
<body >
    <div class="container">
        <div class=" log container z-depth-3">
            <h1 class="center-align">Neway</h1>
            <div class="neway z-depth-3">
                <p class="title center-align">Login do Administrador</p>
            </div>

            <form name="AdminLoginForm" action="" method="post">
                <label>
                    <span>E-mail:</span>
                    <input type="email" name="email" id="email"/>
                </label>

                <label>
                    <span>Senha:</span>
                    <input type="password" name="pass" id="pass"/>
                </label>  
                <?php
                $login = new Login(3);

                if($login->checkLogin()){
                    header('Location: painel.php');
                }

                $dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if (!empty($dataLogin['AdminLogin'])){
                    $login->exeLogin($dataLogin);   
                    if (!$login->getResult()){
                        frontErro($login->getError()[0], $login->getError()[1]);
                    }else{
                        header('Location: painel.php?exe=index');
                    }
                }

                $get = filter_input (INPUT_GET, 'exe', FILTER_DEFAULT);
                if (!empty($get)){
                    if ($get=='restrito'){
                        frontErro("<b>Acesso negado!</b> Realize login para entrar no sistema!", E_USER_NOTICE); 
                    }elseif($get=='logoff'){
                        frontErro("<b>Deslogado com sucesso!</b> Sua sessão foi finalizada.", ACCEPT);
                    }
                }
                ?>
                <input type="submit" name="AdminLogin" value="Logar" class="btn blue darken-4 " />

            </form>
        </div>
    </div>

</body>
</html>