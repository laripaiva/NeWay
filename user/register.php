<?php
session_start();
require('../_app/Config.inc.php');

$login = new Login(2);
if ($login->checkLogin()){
    header('Location:./dashboard.php?exe=index');
    }
    $nome = '';
    $nome_final = '';
    $email = '';
    $senha = '';
    $senha2 = '';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    	<title>Cadastro</title>
    	<link rel="shortcut icon" href="media/neway2.png" type="image/x-icon"/>
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
    				<a href="../index.php" class="brand-logo">NeWay</a>
    				<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    				<ul class="right hide-on-med-and-down">
    					<li><a href="../index.php">Home</a></li>
    					<li><a href="login.php">Logar</a></li>
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
              <?php
                $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if (!empty($data['UserRegister'])){
                  unset($data['UserRegister']);
<<<<<<< HEAD
                }//estava no final do fomr
=======
                }
>>>>>>> a4f0464cdf44a727451e909eb0403f45c99688a6
              ?>

              <div class="input-field ">
                <i class="material-icons prefix">assignment_ind</i>
    						<input name="name" value="<?php if (isset($data)) echo $data['name'];?>" id="icon_prefix" type="text" class="validate">
    						<label class="active" for="icon_prefix">Nome</label>
    					</div>
                <!--<input type="name" name="name" id="name"/>-->

                <div class="input-field ">
      						<i class="material-icons prefix">assignment_ind</i>
      						<input type="text"  name="final_name" value="<?php if (isset($data)) echo $data['final_name'];?>" id="icon_prefix"  class="validate">
      						<label class="active" for="icon_prefix">Sobrenome</label>
      					</div>

                <!-- <input type="last_name" name="final_name" id="final_name"/> -->

                <div class="input-field ">
      						<i class="material-icons prefix">mail</i>
      						<input  name="email" value="<?php if (isset($data)) echo $data['email'];?>" type="email" id="icon_prefix" type="text" class="validate">
      						<label class="active" for="icon_prefix">E-mail</label>
      					</div>

                <!--<input type="email" name="email" id="email"/> -->
                <div class="input-field ">
      						<i class="material-icons prefix">lock_outline</i>
      						<input value="<?php if (isset($data)) echo $data['pass'];?>"  type="password" name="pass" id="icon_telephone" type="tel" class="validate">
      						<label class="active" for="icon_telephone">Senha</label>
      					</div>

                <!--<input type="password" name="pass" id="pass"/> -->
                <div class="input-field ">
                  <i class="material-icons prefix">lock_outline</i>
                  <input value="<?php if (isset($data)) echo $data['pass2'];?>" type="password" name="pass2" id="icon_telephone" type="tel" class="validate">
                  <label class="active" for="icon_telephone">Confirmar Senha</label>
                </div>
                <!--
                <button class="waves-effect waves-light btn center-align" type="submit" name="UserRegister">Cadastrar
                  <i class="material-icons right">send</i>
                </button> -->
            <!-- <a id="logar" type="submit" name="UserRegister" class="waves-effect waves-light btn center-align"><i class="material-icons right">person_add</i>Cadastrar</a> -->
            <center><input type="submit" name="UserRegister" value="Cadastrar" class="waves-effect light-blue darken-4 btn center-align"/></center>
            </form>
          <?php
<<<<<<< HEAD
        
=======

>>>>>>> a4f0464cdf44a727451e909eb0403f45c99688a6
            ?>
            <?php
                $register = new Register;
                $dataRegister = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                //var_dump ($dataRegister);

                if (!empty($dataRegister['UserRegister'])){
                  $nome = $_POST['name'];
                  $nome_final = $_POST['final_name'];
                  $email = $_POST['email'];
                  $senha = $_POST['pass'];
                  $senha2 = $_POST['pass2'];
                  $register->exeRegister($dataRegister);
                  //frontErro($register->getError()[0], $register->getError()[1]);
                  if (!$register->getResult()){
                    frontErro("<div class='alerta error'><center>".$register->getError()[0]."</center></div>", $register->getError()[1]);
                    return false;
                  }
                  if (strlen($dataRegister['name']) == 1 || strlen($dataRegister['name']) == 2 ){
                    frontErro("<div class='alerta error'><center>Nome muito pequeno</center></div>", E_USER_ERROR);
                    return false;
                    }
                  if (strlen($dataRegister['pass']) < 6 && strlen($dataRegister['pass']) != 0){
                    frontErro("<div class='alerta error'><center>Senha muito curta</center></div>", E_USER_ERROR);
                    return false;
                    }
                  if ($dataRegister['pass'] != $dataRegister['pass2'] ){
                    frontErro("<div class='alerta error'><center>Confirmação da senha incorreta </center></div>", E_USER_ERROR);
                    return false;
                    }
                  if(!filter_var($dataRegister['email'], FILTER_VALIDATE_EMAIL)){
                    frontErro("<div class='alerta error'><center>E-mail incorreto</center></div>", E_USER_ERROR);
                    return false;
                  }

                }
            ?>

            <?php

                if ($register->getResult()){
                    $search = new Read;
                    $search->exeRead ("users", "WHERE id = :id", "id={$register->getResult()}");
                    $print = $search->getResult()[0];
                    //var_dump($print);


            ?>
              </div>
              <br>
              <br>
                <form class="form z-depth-5" name="ConfirmForm" action="..\_app\Models\boleto_itau.php" method="post">
                  <div class="container">
                      <p>Confirme os dados a seguir: </p>
                    <div class="input-field ">
                      <i class="material-icons prefix">account_circle</i>
                      <input  value="<?php echo $print['nome'];?>" name="nome" id="icon_prefix" type="text" class="validate">
                      <label class="active" for="icon_prefix">Nome</label>
                    </div>

                    <div class="input-field ">
                      <i class="material-icons prefix">account_circle</i>
                      <input name="nome_final" value="<?php echo $print['nome_final'];?>" name="name" id="icon_prefix" type="text" class="validate">
                      <label class="active" for="icon_prefix">Sobrenome:</label>
                    </div>

                <p>Informe os dados para gerar o boleto: </p>
                <div class="input-field ">
                  <i class="material-icons prefix">my_location</i>
                  <input  type="text" name="CEP" id="cep" value="" size="10" maxlength="9"
                         onblur="pesquisacep(this.value);"class="validate"/>
                  <label class="active" for="icon_prefix">CEP:</label>
                </div>

                <div class="input-field ">
                  <i class="material-icons prefix">location_on</i>
                  <input  type="text" type="text" name="endereco" id="rua" value=""
                         class="validate"/>
                  <label class="active" for="icon_prefix">Rua:</label>
                </div>

                <div class="input-field ">
                  <i class="material-icons prefix">home</i>
                  <input class="active" type="text"  name="bairro" id="bairro" value=""
                         class="validate"/>
                  <label class="active" for="icon_prefix">Bairro:</label>
                </div>

                <div class="input-field ">
                  <i class="material-icons prefix">assistant_photo</i>
                  <input  type="number"  name="numero" value=""
                         class="validate"/>
                  <label class="active" for="icon_prefix">Numero:</label>
                </div>

                <div class="input-field ">
                  <i class="material-icons prefix">location_city</i>
                  <input class="active"  name="cidade" id="cidade"  type="text"  value=""
                         class="validate"/>
                  <label class="active" for="icon_prefix">Cidade:</label>
                </div>

                <div class="input-field ">
                  <i class="material-icons prefix">landscape</i>
                  <input name="estado" id="uf" type="text"  value=""
                         class="validate"/>
                  <label class="active" for="icon_prefix">Estado:</label>
                </div>

                <center><input type="submit" name="UserRegister" class="waves-effect light-blue darken-4 btn center-align" value="Imprimir boleto"/></center>
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
