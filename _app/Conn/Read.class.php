<?php
    /**
     * Classe READ responsável por leituras no banco de dados;
     * Classe READ é filha da classe CONN;
    */
    class Read extends Conn{

        /**
         * Atributos privados = Classes responsável por manipular os próprios atributos
        */
        private $select; // query de select 
        private $places; // variavel de substituição
        private $result; //resultado

        /**@var PDOStatement */
        private $create;

        /**@var PDO */
        private $conn;

        /**
         * MÉTODO FACILITADOR
         * PREPARED STATEMENTS
         * Atributo $terms é null, pois PODE OU NÃO ser requisitado
         * $parseString faz a substitução no prepared statements
         */
        public function exeRead ($table, $terms = null, $parseString = null){
            if(!empty($parseString)){
                /**
                 * parse_str -> FUNÇÃO QUE TRANSFORMA UMA STRING EM UM ARRAY
                 */
                parse_str($parseString, $this->places); 
            }
            /**
             * QUERY COM PREPARED STATEMENTS pegando os valores passados através do Stored procedures
             */
            $this->select = "SELECT * FROM {$table} {$terms}";
            $this->Execute();
        }

        // public function exeReadCountModules ($table, $place, $terms){
        //     /**
        //      * QUERY COM PREPARED STATEMENTS pegando os valores passados através do Stored procedures
        //      */
        //     // SELECT COUNT(id_courses) FROM modules WHERE id_courses=1
        //     $this->select = "SELECT COUNT ({$place}) FROM {$table} {$terms}";
        //     $this->Execute();
        // }
        
        public function getResult(){
            return $this->result;
        }

        /**
         * Verificar quantos resultados a query obteve
         */
        public function getRowCount(){
            return $this->read->RowCount();
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
            $this->Execute();
        }
        /** 
         * MÉTODOS DE APOIO A CLASSE
         * ****************************************
         * ***********MÉTODOS PRIVADOS*************
         * ****************************************
         */

        private function connect2(){
            $this->conn = parent::getConn();
            $this->read = $this->conn->prepare($this->select);
            $this->read->setFetchMode (PDO::FETCH_ASSOC);
        }

        /**
         * Cria a sintaxe da query para Prepared Statements
         */
        private function getSyntax(){
           if ($this->places){
               foreach ($this->places as $field => $value){
                   if ($field=='limit' || $field== 'offset'){
                       $value = (int) $value;
                   }
                   $this->read->bindValue(":{$field}", $value, (is_int($value) ? PDO:: PARAM_INT : PDO:: PARAM_STR));
               }
           }
        }
        /**
         * Obtém a conexão e a syntax, executa a query
         */
        public function Execute(){
            $this->connect2();

            try{
                $this->getSyntax();
                $this->read->execute();
                $this->result = $this->read->fetchAll();
            }catch (PDOException $e){
                $this->result = null;
                frontErro ("<b>Erro ao ler: </b> {$e->getMessage()}", $e->getCode());
            }

        }

    }
?>