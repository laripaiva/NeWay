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
    	<link rel="stylesheet" href="css/cad.css">
    </head>
    <body class="register">
      <header>
    		<nav>
    			<div class="nav-wrapper">
    				<a href="#!" class="brand-logo">NeWay</a>
    				<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    				<ul class="right hide-on-med-and-down">
    					<li><a href="index.php">Home</a></li>
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
          <form class="form z-depth-5" name="UserRegisterForm" action="" method="post">
            <div class="container">

              <div class="input-field ">
                <i class="material-icons prefix">assignment_ind</i>
    						<input name="name" id="icon_prefix" type="text" class="validate">
    						<label for="icon_prefix">Nome</label>
    					</div>
                <!--<input type="name" name="name" id="name"/>-->

                <div class="input-field ">
      						<i class="material-icons prefix">assignment_ind</i>
      						<input type="text" name="final_name" id="icon_prefix"  class="validate">
      						<label for="icon_prefix">Sobrenome</label>
      					</div>

                <!-- <input type="last_name" name="final_name" id="final_name"/> -->

                <div class="input-field ">
      						<i class="material-icons prefix">mail</i>
      						<input type="email" name="email" id="icon_prefix" type="text" class="validate">
      						<label for="icon_prefix">E-mail</label>
      					</div>

                <!--<input type="email" name="email" id="email"/> -->
                <div class="input-field ">
      						<i class="material-icons prefix">lock_outline</i>
      						<input  type="password" name="pass" id="icon_telephone" type="tel" class="validate">
      						<label for="icon_telephone">Senha</label>
      					</div>

                <!--<input type="password" name="pass" id="pass"/> -->
                <div class="input-field ">
                  <i class="material-icons prefix">lock_outline</i>
                  <input type="password" name="pass2" id="icon_telephone" type="tel" class="validate">
                  <label for="icon_telephone">Confirmar Senha</label>
                </div>
                <!--
                <button class="waves-effect waves-light btn center-align" type="submit" name="UserRegister">Cadastrar
                  <i class="material-icons right">send</i>
                </button> -->
            <!-- <a id="logar" type="submit" name="UserRegister" class="waves-effect waves-light btn center-align"><i class="material-icons right">person_add</i>Cadastrar</a> -->
            <input type="submit" name="UserRegister" value="Cadastrar" class="waves-effect waves-light btn center-align"/>
            </form>
          </div>
            <?php
                $register = new Register;
                $dataRegister = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                //var_dump ($dataRegister);

                if (!empty($dataRegister['UserRegister'])){
                  if (strlen($dataRegister['name']) < 2){
                    frontErro("Nome muito pequeno", E_USER_WARNING);
                    die();
                    }
                  if (strlen($dataRegister['pass']) < 6){
                    frontErro("Senha muito curta", E_USER_WARNING);
                    die();
                    }
                  if ($dataRegister['pass'] != $dataRegister['pass2'] ){
                    frontErro("Confirmação da senha incorreta", E_USER_WARNING);
                    die();
                    }
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
                <form class="form z-depth-5" name="ConfirmForm" action="..\_app\Models\boleto_itau.php" method="post">
                  <div class="container">
                      <p>Confirme os dados a seguir: </p>
                    <div class="input-field ">
                      <input  value="<?php echo $print['nome'];?>" name="name" id="icon_prefix" type="text" class="validate">
                      <label for="icon_prefix">Nome</label>
                    </div>

                    <div class="input-field ">
                      <input name="nome_final" value="<?php echo $print['nome_final'];?>" name="name" id="icon_prefix" type="text" class="validate">
                      <label for="icon_prefix">Sobrenome:</label>
                    </div>

                <p>Informe os dados para gerar o boleto: </p>
                <div class="input-field ">
                  <input  type="text" name="CEP" id="cep" value="" size="10" maxlength="9"
                         onblur="pesquisacep(this.value);"class="validate"/>
                  <label for="icon_prefix">CEP:</label>
                </div>

                <div class="input-field ">
                  <input  type="text" type="text" name="endereco" id="rua" value=""
                         class="validate"/>
                  <label for="icon_prefix">RUA:</label>
                </div>

                <div class="input-field ">
                  <input  type="text" type="text" name="bairro" id="bairro" value=""
                         class="validate"/>
                  <label for="icon_prefix">Bairro:</label>
                </div>

                <div class="input-field ">
                  <input  type="text" type="text"  value=""
                         class="validate"/>
                  <label for="icon_prefix">Numero:</label>
                </div>

                <div class="input-field ">
                  <input  name="cidade" id="cidade"  type="text"  value=""
                         class="validate"/>
                  <label for="icon_prefix">Cidade:</label>
                </div>

                <div class="input-field ">
                  <input name="estado" id="uf" type="text"  value=""
                         class="validate"/>
                  <label for="icon_prefix">Estado:</label>
                </div>

                <input type="submit" name="UserRegister" value="Imprimir boleto"/>
                </form>
              </div>
            <?php
            }
            ?>
        </main>
        <footer>


        </footer>

        <script src="JS/jquery-3.3.1.js" type="text/javascript" charset="utf-8" async defer></script>
        <script src="JS/materialize.js"></script>
        <script src="JS/cad.js"></script>
        <script src="JS/cep.js"></script>
    </body>
</html>
