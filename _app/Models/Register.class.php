<?php
  include("validate.php");

    /**
     * Register.Class [Register]
     */
    class Register{

        private $data;
        private $level;
        private $name;
        private $last_name;
        private $email;
        private $pass;
        private $pass2;
        private $error;
        private $result;

        public function exeRegister(array $userData){
            //strip_tags -> Retira as tags HTML e PHP de uma string
            //trim —> Retira espaço no ínicio e final de uma string
            $this->name = (string) strip_tags(trim($userData['name']));
            $this->last_name = (string)  strip_tags(trim($userData['final_name']));
            $this->email = (string) strip_tags(trim($userData['email']));
            $this->pass = (string)  strip_tags(trim($userData['pass']));
            $this->pass2 = (string)  strip_tags(trim($userData['pass2']));
            $this->setRegister();

        }

        public function getResult(){
            return $this->result;
        }

        public function getError(){
            return $this->error;
        }
        /**
         * MÉTODOS PRIVADOS
         * setLogin - > validar e verificar
         * getUser -> buscar usuário
         */

         private function setRegister(){
           if (!$this->name || !$this->last_name || !$this->email || !$this->pass || !Check::validateEmail($this->email)){
             $this->error = ['Informe todos os campos para efetuar cadastro!', E_USER_WARNING];
             $this->result = false;
           }
           else{
                 $readEmail = new Read;
                 $readEmail->exeRead("users", "WHERE email = :e", "e={$this->email}");
                 if ($readEmail->getResult()){
                     $this->error = ['Email já utilizado', E_USER_WARNING];
                 }else{
                     self::Create();
                 }

             }
        }
        private function Create(){
            $this->data['level']= 1;
            $this->data['nome']= $this->name;
            $this->data['nome_final']= $this->last_name;
            $this->data['email']= $this->email;
            $this->data['senha']= md5($this->pass);

            $create = new Create;
            $create->ExeCreate ("users", $this->data);

            if ($create->getResult()){
                //Obter ID do registro inserido
                $this->result = $create->getResult();
                $this->error = ["<b>Sucesso.", E_USER_NOTICE];
            }
        }

    }
?>
