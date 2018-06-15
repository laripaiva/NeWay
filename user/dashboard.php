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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title></title>
        <link rel="shortcut icon" href="" type="image/x-icon"/>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="js/gerenciarCategoria.js"></script>
        <script src="js/jquery-3.3.1.js" type="text/javascript" charset="utf-8" async defer></script>
	    <script src="js/materialize.js"></script>
	    <script src="js/dash.js"></script>
        <script src="js/home.js"></script>
        <script src="js/visu.js"></script>
        <link rel="stylesheet" href="css/dashboard.css">
        <link rel="stylesheet" href="css/usus.css">
        <!-- <link rel="stylesheet" href="css/gerenciarUsuario.css">  -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/home.css">
        <!-- <link rel="stylesheet" href="css/visu.css"> -->
        <!-- <link rel="stylesheet" href="CSS/cadCurso.css">
        <script src="js/cadCurso.js"></script> -->
        <script type="text/javascript">//<![CDATA[
            window.onload=function(){
            $(document).ready(function() {
                $('select').material_select();
            });
            }//]]>

        </script>
        <script type="text/javascript">//<![CDATA[
            // Tabs => módulos
            $(document).ready(function(){
   	        $('.tabs').tabs();
            });
        </script>
    </head>

    <body class="painel">
        <header>
            <nav>
            <div class="nav-wrapper">
                <a href="dashboard.php?exe=index" class="brand-logo">NeWay</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="dashboard.php?exe=index">Home</a></li>
                    <li><a href="dashboard.php?exe=cInscritos">Cursos Inscritos</a></li>
                    <li><a  href="dashboard.php?logoff=true">Sair</a></li>
                </ul>
            </div>
            <?php
                //ATIVA MENU
                if (isset($getexe)):
                    $linkto = explode('/', $getexe);
                else:
                    $linkto = array();
                endif;
            ?>
            </nav>
        </header>
        <div id="painel">
            <?php
            //QUERY STRING
            /**
             * Padrão de projeto Front-Controller
             * Decide qual controlador será executado e carregado no sistema
             * Sistema não entra em pastas, apenas inclui o caminho
             */

            if (!empty($getexe)){
                $includepatch = __DIR__ . '\\system\\'. strip_tags(trim($getexe) . '.php');
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
