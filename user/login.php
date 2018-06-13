<?php
session_start();
require('../_app/Config.inc.php');

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
    	<link rel="stylesheet" href="css/login.css">
      <link rel="stylesheet" href="css/reset.css" />
      <link rel="stylesheet" href="css/admin.css" />
      <link rel="stylesheet" type="text/css" href="css/style.css" />

    </head>
    <body>
    <header>
  		<nav>
  			<div class="nav-wrapper">
  				<a href="../index.php" class="brand-logo">NeWay</a>
  				<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
  				<ul class="right hide-on-med-and-down">
  					<li><a href="../index.php">Home</a></li>
  					<li><a href="register.php">Cadastre-se</a></li>
  				</ul>
  			</div>
  		</nav>
  		<ul class="sidenav" id="mobile-demo">
  			<li><a href="badges.html">Home</a></li>
  			<li><a href="sass.html">Cadastre-se</a></li>
  		</ul>
  	</header>

	   <main class="main">
        <form class="form z-depth-5" name="UserLoginForm" action="" method="post">
          <div class="container">

  					  <div class="input-field ">
              <i class="material-icons prefix">assignment_ind</i>
              <input type="email" name="email" id="icon_prefix" type="text" class="validate">
              <label for="icon_prefix">Login</label>
              <!--<input type="email" name="email" id="email"/> -->
            </div>

            <div class="input-field ">
              <i class="material-icons prefix">lock_outline</i>
              <input id="icon_telephone" type="password" name="pass" id="pass" class="validate">
              <label for="icon_telephone">Password</label>
              <!--<input type="password" name="pass" id="pass"/> -->
              <!--<a id="logar" type="submit" name="UserLogin" value="Logar" class="waves-effect waves-light btn center-align"><i class="material-icons right">cloud</i>Logar</a> -->
    				</div>
            <input type="submit" name="UserLogin" class="waves-effect waves-light btn center-align" value="Entrar"/>

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
                    frontErro("<div class='alerta info'>Seu pagamento ainda não foi identificado. Envie o comprovante para o email @exemplo.</div>", E_USER_WARNING);
                    $userId = $login->getId();
                    $readUser = new Read;
                    $readUser->exeRead("users", "WHERE id = :id", "id={$userId}");
                    $user = $readUser->getResult()[0];
        ?>
          <div class='alerta atencao'>Clique <a href="segunda-via.php?aluno=<?php echo $user['id'];?>&nome=<?php echo $user['nome'];?>&sobrenome=<?php echo $user['nome_final'];?>">aqui</a> para imprimir a segunda via do boleto.</div>
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
        <!--<input type="submit" name="UserLogin" value="Logar"/>-->
      </div>
      </form>
  </main>
  <script src="./js/jquery-3.3.1.js" type="text/javascript" charset="utf-8" async defer></script>
  <script src="./js/materialize.js"></script>
  <script src="./js/login.js"></script>
</body>
</html>
