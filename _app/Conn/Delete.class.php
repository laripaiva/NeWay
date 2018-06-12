<?php
    /**
     * Classe Delete responsável por deletar dados no banco de dados;
     * Classe Delete é filha da classe CONN;
    */
    //Todas as classes que irão manipular o banco são filhas da classe Conn
    class Delete extends Conn{
        //Atributos privados pois a própria classe será responsável por manipular os próprios atributos
        private $table; // tabela
        private $terms;
        private $data; // dados
        private $result; //resultado

        /**@var PDOStatement 
        * Esse atributos deve sempre ter o nome da classe
        */
        private $delete;

        /**@var PDO */
        private $conn;

        /**
         * ExeCreate: executa um cadastro no banco de dados utilizando prepared statements 
         * @param STRING $table = Nome da tabela no banco
         * @param ARRAY $date = Array atribuitivo: 'Nome da coluna' => 'valor'
         */
        public function ExeDelete ($table, $terms, $parseString){
            $this->table = (string) $table;
            $this->terms = (string) $terms;

            parse_str($parseString, $this->places);
            $this->getSyntax();
            $this->Execute();
        }
        
        public function getResult(){
            return $this->result;
        }

        public function getRowCount(){
            return $this->delete->rowCount();
        }

        public function setPlaces ($parseString){
            parse_str($parseString, $this->places); 
            $this->getSyntax();
            $this->Execute();
        }

        /** 
         * ****************************************
         * ***********Private Methods *************
         * ****************************************
         */

         /**
          * Função de conexão
          */
        private function connect2(){
            $this->conn= parent:: getConn();
            $this->delete = $this->conn->prepare($this->delete);
        }

        private function getSyntax(){
            $this->delete = "DELETE FROM {$this->table} {$this->terms}";
        }

        public function Execute(){
            $this->connect2();

            try{
                $this->delete->execute($this->places);
                $this->result = true;
            }catch (PDOException $e){
                $this->result = null;
                frontErro ("<b>Erro ao deletar: </b> {$e->getMessage()}", $e->getCode());
            }
        }
    }

?>