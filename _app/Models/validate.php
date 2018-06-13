<?php
  function setData($data){
    if($data == "" || $data == null){
        return true;
    } else {
      //echo "<script> alert('Campo e-mail ou senha vazio');window.location.href='./login.php'</script>";
      return false;
    }
}

  function equalData($pass,$pass2){
    if ($pass != $pass2){
      return true;
    } else{
      return false;
    }
  }

  function limiteMinimo($data){
    if (strlen($data) < 6){
      return true;
    } else{
      return false;
    }
  }
  function limiteMinimoNome($data){
    if (strlen($data) < 2){
      return true;
    } else{
      return false;
    }
  }

  function validateCpf($cpf){
    // Elimina possivel mascara
   $cpf = preg_replace('[^0-9]', '', $cpf);
   $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

   // Verifica se o numero de digitos informados é igual a 11
   if (strlen($cpf) != 11) {
       return true;
   }
   // Verifica se nenhuma das sequências invalidas abaixo
   // foi digitada. Caso afirmativo, retorna falso
   else if ($cpf == '00000000000' ||
       $cpf == '11111111111' ||
       $cpf == '22222222222' ||
       $cpf == '33333333333' ||
       $cpf == '44444444444' ||
       $cpf == '55555555555' ||
       $cpf == '66666666666' ||
       $cpf == '77777777777' ||
       $cpf == '88888888888' ||
       $cpf == '99999999999') {
       return true;
    // Calcula os digitos verificadores para verificar se o
    // CPF é válido
    } else {

       for ($t = 9; $t < 11; $t++) {

           for ($d = 0, $c = 0; $c < $t; $c++) {
               $d += $cpf{$c} * (($t + 1) - $c);
           }
           $d = ((10 * $d) % 11) % 10;
           if ($cpf{$c} != $d) {
               return true;
           }
       }

       return false;
   }
  }
  function validateTelefone($telefone){
    if (preg_match('#^\(\d{2}\) (9|)[6789]\d{3}-\d{4}$#', $telefone) > 0) {
     echo false;
    } else {
     echo true;
   }

  }
  function isLogged(){
		if(isset($_SESSION["email"]) AND ($_SESSION["email"]!="")){
		return true;
  }else{
    return false;
  }

}

?>
