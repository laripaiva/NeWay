<?php

    /**
     * Login.Class [MODEL]
     * Classe responsável por autenticar, validar, e checar usuário no sistema de login
     */
    class Login{

        private $id;
        private $level;
        private $email;
        private $pass;
        private $error;
        private $result;

        function __construct ($level){
            $this->level = (int) $level;
        }

        public function exeLogin(array $userData){
            //strip_tags -> Retira as tags HTML e PHP de uma string
            //trim —> Retira espaço no ínicio e final de uma string
            $this->email = (string) strip_tags(trim($userData['email']));
            $this->pass = (string)  strip_tags(trim($userData['pass']));
            $this->setLogin();
        }

        public function getResult(){
            return $this->result;
        }

        public function getError(){
            return $this->error; 
        }

        public function getId(){
            return $this->id;
        }
        public function checkLogin(){
            //Se você não estiver logado, ou sessão restrita
            if (empty ($_SESSION['userlogin']) || $_SESSION['userlogin']['level'] != $this->level){
                unset($_SESSION['userlogin']);
                return false;
            }else{
                return true;
            }
        }
        /**
         * MÉTODOS PRIVADOS
         * setLogin - > validar e verificar
         * getUser -> buscar usuário
         */

         private function setLogin(){

            if (!$this->email || !$this->pass || !Check::validateEmail($this->email)){
                $this->error = ['Informe seu e-mail e senha para efetuar login!', E_USER_WARNING];
                $this->result = false;
            }elseif(!$this->getUser()){
              $this->error = ['Os dados informados não são compatíveis.', E_USER_ERROR];
              $this->result = false;
            }
            elseif($this->result['level'] != $this->level){
                $this->error = ["{$this->result['nome']}, seu login não foi autorizado.", E_USER_ERROR];
                $this->id = (int) $this->result['id'];
                self::getId();
                $this->result = false;
               
            }
            else{
                //execute() já passa $result = true
                $this->execute();
            }
        }

        private function getUser(){
            
            //Criptografando a senha
            $this->pass = md5($this->pass);

            $read = new Read;
            $read->exeRead("users", "WHERE email = :e AND senha = :p", "e={$this->email}&p={$this->pass}");

            if ($read->getResult()){
                $this->result = $read->getResult()[0];
                return true;
            }else{
                return false;
            }
         }

         private function execute(){
             if (!session_id()){
                session_start();
             }

             $_SESSION['userlogin'] = $this->result;
             $this->error = ["Olá {$this->result['nome']}, seja bem-vindo(a). Aguarde redirecionamento.", ACCEPT];
             $this->result = true;
         }

    }
?>