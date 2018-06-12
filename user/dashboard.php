<?php
session_start();
require('../_app/Config.inc.php');

$login = new Login(2);

$logoff = filter_input (INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input (INPUT_GET, 'exe', FILTER_DEFAULT);

if (!$login->checkLogin()){
    unset ($_SESSION['userlogin']);
    header('Location: login.php?exe=restrito');
    }else{
        $userlogin = $_SESSION['userlogin'];
    }
if ($logoff){
    unset ($_SESSION['userlogin']);
    header('Location: login.php?exe=logoff');
    die;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
    </head>

    <body class="painel">
        <header id="navadmin">
            <ul>
                <li class="username">Olá <?= $userlogin['nome']; ?> <?= $userlogin['nome_final']; ?></li>
                <li><a href="dashboard.php?logoff=true">Sair</a></li>
            </ul>
            <nav>
                <h1><a href="dashboard.php?exe=index">Dashboard</a></h1>
                <?php
                //ATIVA MENU
                if (isset($getexe)):
                    $linkto = explode('/', $getexe);
                else:
                    $linkto = array();
                endif;
                ?>
                </li>
            </nav>
        </header>
        <div id="painel">
            <ul class="sub">
                <li><a href="dashboard.php?exe=matricula/index&aluno=<?php echo $userlogin['id']; ?>">Visualizar todos os cursos</a></li>
            </ul>
            <?php
            //QUERY STRING
            /**
             * Padrão de projeto Front-Controller
             * Decide qual controlador será executado e carregado no sistema
             * Sistema não entra em pastas, apenas inclui o caminho
             */
            if (!empty($getexe)){
                $includepatch = __DIR__ . '\\' . strip_tags(trim($getexe) . '.php');
            }else{
                $includepatch = __DIR__ . '\\dashboard.php';
            }
            if (file_exists($includepatch)):
                require_once($includepatch); 
            else:
                echo "<div class=\"content notfound\">";
                frontErro("<b>Erro ao incluir tela:</b>Erro ao incluir o controller /{$getexe}.php!", E_USER_ERROR);
                echo "</div>";
            endif;
            ?>
        </div>
    </body>
</html>