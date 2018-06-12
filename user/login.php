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

    </head>
    <body class="login">
        <div id="login">
            <h1>Login</h1>
            <form name="UserLoginForm" action="" method="post">
            <label>
                <span>E-mail:</span>
                <input type="email" name="email" id="email"/>
            </label>
            <label>
                <span>Senha:</span>
                <input type="password" name="pass" id="pass"/>
            </label>

            <?php
                $login = new Login(2);

                if($login->checkLogin()){
                    header('Location: dashboard.php');
                }

                $dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if (!empty($dataLogin['UserLogin'])){
                    $login->exeLogin($dataLogin);   
                    if (!$login->getResult()){
                        frontErro($login->getError()[0], $login->getError()[1]);
                        frontErro("Seu pagamento ainda não foi identificado. Envie o comprovante para o email @exemplo.", E_USER_WARNING);
                        $userId = $login->getId();
                        $readUser = new Read;
                        $readUser->exeRead("users", "WHERE id = :id", "id={$userId}");
                        $user = $readUser->getResult()[0];
            ?>
                Clique <a href="segunda-via.php?aluno=<?php echo $user['id'];?>&nome=<?php echo $user['nome'];?>&sobrenome=<?php echo $user['nome_final'];?>">aqui</a> para imprimir a segunda via do boleto.
            <?php 
                    }else{
                        header('Location: dashboard.php?exe=index');
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
            <input type="submit" name="UserLogin" value="Logar"/>
                    
            </form>
        </div>
    </body>
</html>