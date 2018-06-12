<?php

/**
 * Conn.Class [Conexao]
 * Classe abstrata de conexão. Padrão SingleTon
 * Retorna um objeto PDO pelo método estático getConn()
*/
    class Conn{
        


        private static $host = HOST;
        private static $user = USER;
        private static $pass = PASS;
        private static $dbsa = DBSA;

        /** @var PDO */

        private static $connect = null;

        /**
         * Conecta com o banco de dados com o pattern singleton.
         * Retorna um objeto PDO
         * Conexão só será executada se não existir outra instância do objeto
         * Singleton só permite um objeto instânciado no servidor 
         * O PDO permite a conexão a vários tipos de BD, e permite a manipulação das querys
         * O que muda é o dsn
         * Quando for usar PostGre, procurar por dsn do POSTGRE
        */

        private static function connect(){
            try{
                if(self::$connect == null){
                    $dsn= 'mysql:host=' . self::$host . ';dbname=' . self::$dbsa;
                    $options= [PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES UTF8'];                    
                    self:: $connect = new PDO ($dsn, self:: $user, self:: $pass, $options);
                }

            }
            //Classe de Excessão do PDO
            catch (PDOException $e){
                endError($e->getCode(), $e->getMessage, $e->getFile(), $e->getLine);
                die;
            }

            self::$connect-> setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$connect;
        }//Conecta com o BD, retorna um objeto PDO
        

        /**
        * Retorna um objeto PDO SingleTon 
        */
        public static function getConn(){
            return self:: connect();
        }
    }