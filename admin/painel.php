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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title></title>
        <link rel="shortcut icon" href="" type="image/x-icon"/> 
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <script src="admin/gerenciarCategoria.js"></script>
        <link rel="stylesheet" href="css/dashboard.css">
        <link rel="stylesheet" href="css/usus.css"> 
        <link rel="stylesheet" href="css/gerenciarUsuario.css"> 
        <link rel="stylesheet" href="CSS/style.css"> 
        <link rel="stylesheet" href="CSS/home.css">
    </head>

    <body>
        <header>
            <nav>
            <div class="nav-wrapper">
                <a href="painel.php?exe=index" class="brand-logo">NeWay - Administração</a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="painel.php?exe=index">Dashboard</a></li>
                    <li><a class="modal-trigger" href="painel.php?exe=categorias/index">Gerenciar Categorias</a></li>
                    <li><a href="painel.php?exe=cursos/create">Cadastrar Curso</a></li>
                    <li><a href="painel.php?exe=usuarios/index">Gerenciar Usuários</a></li>
                    <li><a  href="painel.php?logoff=true">Sair</a></li>
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
        <script src="JS/jquery-3.3.1.js" type="text/javascript" charset="utf-8" async defer></script>
	    <script src="JS/materialize.js"></script>
	    <script src="JS/dash.js"></script>
    </body>
    <footer>
		<footer class="page-footer">
			<div class="container">
				<div class="row">
					<div class="col l6 s12">
						<h5 class="white-text">Sobre Nós</h5>
						<p class="grey-text text-lighten-4">Moramos nas redondezas da UFRRJ, nosso país.</p>

					</div>
					<div class="col l4 offset-l2 s12">
						<h5 class="white-text">Links</h5>
						<ul>
							<li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
							<li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
							<li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
							<li><a class="grey-text text-lighten-3" href="#!">Em caso de dúvidas envie um email para: neway@gmail.com</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="footer-copyright">
				<div class="container">
					© 2018 Equipe Capivara: Ana, Lari e Gustavo
					<a class="grey-text text-lighten-4 right" href="#!">More Links</a>
				</div>
			</div>
		</footer>
	</footer>
</html>