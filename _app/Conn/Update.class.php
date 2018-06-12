<?php
    /**
     * Classe UPDATE responsável por atualizações no banco de dados;
     * Classe UPDATE é filha da classe CONN;
    */
    class Update extends Conn{

        /**
         * É necessário trabalhar com atributos que permitam a realização de um update seguro
        */
        private $table; // tabela do BD
        private $data; // dados do BD
        private $terms; //Condição de atualização
        private $places; // Poder utilizar o prepared statements
        private $result; //resultado

        /**@var PDOStatement */
        private $update;

        /**@var PDO */
        private $conn;

        /**
         * MÉTODO FACILITADOR
         * PREPARED STATEMENTS
         * Atributo $terms é null, pois PODE OU NÃO ser requisitado
         * $parseString faz a substitução no prepared statements
         */
        public function exeUpdate ($table, array $data, $terms,  $parseString){

            $this->table = $table;
            $this->data = $data;
            $this->terms = (string) $terms;

            /**
             * Função que transforma uma string em array
             */
            parse_str($parseString, $this->places); 
            $this->getSyntax();
            $this->Execute();
        }
        
        public function getResult(){
            return $this->result;
        }

        /**
         * Verificar quantos resultados a query obteve
         */
        public function getRowCount(){
            return $this->update->RowCount();
        }

        /**
         * Método para acessar a query manualmente
         */

        public function fullRead($query, $parseString=null){

            $this->select = (string) $query;
            if(!empty($parseString)){
                /**
                 * parse_str -> FUNÇÃO QUE TRANSFORMA UMA STRING EM UM ARRAY
                 */
                parse_str($parseString, $this->places); 
            }
            $this->Execute();

        }

        public function setPlaces ($parseString){
            parse_str($parseString, $this->places); 
            $this->getSyntax();
            $this->Execute();
        }
        /** 
         * MÉTODOS DE APOIO A CLASSE
         * ****************************************
         * ***********MÉTODOS PRIVADOS*************
         * ****************************************
         */

        private function connect2(){
            $this->conn = parent:: getConn();
            $this->update = $this->conn->prepare ($this->update);

        }

        /**
         * Cria a sintaxe da query para Prepared Statements
         */
        private function getSyntax(){
            foreach ($this->data as $field => $value){
                $places [] = $field  . '= :' . $field;
            }

            $places = implode (', ', $places);
            $this->update = "UPDATE {$this->table} SET {$places} {$this->terms} ";
        }
        /**
         * Obtém a conexão e a syntax, executa a query
         */
        public function Execute(){
            $this->connect2();
            try{
                $this->update->execute(array_merge($this->data, $this->places));
                $this->result = true;
            }catch (PDOException $e){
                $this->result = null;
                frontErro ("<b>Erro ao ler: </b> {$e->getMessage()}", $e->getCode());
            }
        }

        
    }
?>