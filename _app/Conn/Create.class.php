<?php

    //Todas as classes que irão manipular o banco são filhas da classe Conn
    class Create extends Conn{

        //Atributos privados pois a própria classe será responsável por manipular os próprios atributos
        private $table; // tabela
        private $data; // dados
        private $result; //resultado
        private $courseId; // Id do curso para criação de módulos

        /**@var PDOStatement 
        * Esse atributos deve sempre ter o nome da classe
        */
        private $read;

        /**@var PDO */
        private $conn;

        /**
         * ExeCreate: executa um cadastro no banco de dados utilizando prepared statements 
         * @param STRING $table = Nome da tabela no banco
         * @param ARRAY $date = Array atribuitivo: 'Nome da coluna' => 'valor'
         */
        public function ExeCreate ($table, array $data){
            $this->table = (string) $table;
            $this->data = $data;
            $this->getSyntax();
            $this->execute();
        }
        
        public function getResult(){
            return $this->result;
        }

        /** 
         * ****************************************
         * ***********Private Methods *************
         * ****************************************
         */

        private function connect2(){
            $this->conn= parent::getConn();
            $this->create = $this->conn->prepare ($this->create);
        }

        private function getSyntax(){
            $fields = implode (', ', array_keys($this->data));
            $places = ":" . implode (', :', array_keys($this->data));
            $this->create = "INSERT INTO {$this->table} ({$fields}) VALUES ({$places})";
        }

        public function execute(){
            $this->connect2();

            try{
                $this->create->execute($this->data);
                $this->result = $this->conn->lastInsertId();

            }catch (PDOException $e){
                $this->result = null;
                frontErro ("<b>Erro ao cadastrar: </b> {$e->getMessage()}", $e->getCode());
            }
        }

    }
?>