<?php
session_start();
require('../_app/Config.inc.php');

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Site Admin</title>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/admin.css" />
        <link rel="stylesheet" type="text/css" href="css\style.css" />

    </head>
    <body class="login">
        <div id="login">
            <div class="boxin">
                <h1>Administrar Site</h1>
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
                    <input type="submit" name="AdminLogin" value="Logar" class="btn blue" />
                    
                </form>
            </div>
        </div>

    </body>
</html>