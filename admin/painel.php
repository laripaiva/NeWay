<?php
session_start();
require('../_app/Config.inc.php');

$login = new Login(3);

$logoff = filter_input (INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input (INPUT_GET, 'exe', FILTER_DEFAULT);

if (!$login->checkLogin()){
    unset ($_SESSION['userlogin']);
    header('Location: index.php?exe=restrito');
    }else{
        $userlogin = $_SESSION['userlogin'];
    }
if ($logoff){
    unset ($_SESSION['userlogin']);
    header('Location: index.php?exe=logoff');
    die;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Área administrativa</title>
		<link rel="stylesheet" href="css/reset.css" />
		<link rel="stylesheet" href="css/admin.css" />   
    </head>

    <body class="painel">

        <header id="navadmin">
            <div class="content">
                <h1 class="logomarca"></h1>
                <ul>
                    <li class="username">Olá, <?= $userlogin['nome']; ?> <?= $userlogin['nome_final']; ?></li>
                    <li><a href="painel.php?logoff=true">Sair</a></li>
                </ul>
                <nav>
                    <h1><a href="painel.php?exe=index" title="Dasboard">Painel de Controle</a></h1>
                    <?php
                    //ATIVA MENU
                    if (isset($getexe)):
                        $linkto = explode('/', $getexe);
                    else:
                        $linkto = array();
                    endif;
                    ?>
                        <ul class="sub">
                            <li><a href="painel.php?exe=cursos/index">Gerenciar cursos</a></li>
                            <li><a href="painel.php?exe=usuarios/index">Gerenciar usuários</a></li>
                        </ul>
                    </li>
                </nav>
            </div><!--/CONTENT-->
        </header>
        <div id="painel">
            <?php
            //QUERY STRING
            /**
             * Padrão de projeto Front-Controller
             * Decide qual controlador será executado e carregado no sistema
             * Sistema não entra em pastas, apenas inclui o caminho
             */
            if (!empty($getexe)):
                $includepatch = __DIR__ . '\\system\\' . strip_tags(trim($getexe) . '.php');
            else:
                $includepatch = __DIR__ . '\\system\\home.php';
            endif;

            if (file_exists($includepatch)):
                require_once($includepatch);
            else:
                echo "<div class=\"content notfound\">";
                frontErro("<b>Erro ao incluir tela:</b>Erro ao incluir o controller /{$getexe}.php!", E_USER_ERROR);
                echo "</div>";
            endif;
            ?>
        </div> <!-- painel -->

    </body>
</html>