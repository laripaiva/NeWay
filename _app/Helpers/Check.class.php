<?php

    /**
     * CLASSE RESPONSÁVEL POR MANIPULAR E VALIDAR DADOS DO SISTEMA
     * TODOS OS MÉTODOS SERÃO ESTÁTICOS
     */
    class Check{
        private static $data;
        private static $format;

        /**
         * FUNÇÃO ESTÁTICA RESPONSÁVEL PELA VALIDAÇÃO DO EMAIL
         */
        public static function validateEmail($email){
            self::$data = (string) $email;
            self::$format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

            /**
             * FUNÇÃO QUE VERIFICA SE O DADO ENVIADO ESTÁ NO FORMATO DESEJADO
             * TRUE= EMAIL VÁLIDO, FALSE= EMAIL INVÁLIDO
             */
            if (preg_match(self::$format, self::$data)){
                return true;
            }else{
                return false;
            }
        }

        /**
         * FUNÇÃO ESTÁTICA RESPONSÁVEL POR FORMAR UMA URL AMIGÁVEL
         * O OBJETIVO É TIRAR TODOS OS ACENTOS E ESPAÇOS DA STRING
         * $format vira um array, pois possui mais de 1 string de validação
         * tá com um pequeno erro
         */
        public static function validateName($name){
            
            self::$format = array();
            self::$format ['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
            self::$format ['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
            
            /**
             * strtr -> função nativa do php para traduzir strings
             * utf8_decode -> Converte uma string codificada com UTF-8 para single-byte
             * utf8_encode -> Converte uma string para UTF-8
             * strtr (parametro/string que vai ser traduzida, onde vai comparar os caracteres para traduzir,
             * por qual caracter vamos substituir)
             *  strip_tags -> Retira as tags HTML e PHP de uma string
             * str_replace -> Substitui todas as ocorrências da string de procura com a string de substituição
             */

            self::$data = strtr(utf8_decode($name), utf8_decode(self::$format['a']), self::$format['b']);

            self::$data = strip_tags(trim(self::$data));

            self::$data = str_replace(' ', '-', self::$data);

            // return strtolower (utf8_encode(self::$data));
            return self::$data;
        }

        /**
         * FUNÇÂO PARA VALIDAR DATAS E PODER SALVAR NO BANCO DE DADOS
         */
        public static function validateDate($date){
            //Objetivo de separar a data do tempo
            self::$format = explode(' ', $date);
            //Objetivo de tirar a / da data
            //O array fica 0, pois ao separar é como se tivesse 2 arrays na string $date
            self::$data = explode ('/', self::$format[0]);


            if (empty(self::$format[1])){
                self::$format[1] = date ('H:i:s');
            }

            //Concatenando 
            self::$data = self::$data[2] . '-' . self::$data[1] . '-' . self::$data[0];

            return self::$data;
        }

        /**
         * FUNÇÃO PARA LIMITAR CARACTERES DE UMA STRING
         */

         public static function validateWords ($string, $limit, $pointer= null){
             //Limpa código e tira os espaços
            self::$data = (strip_tags(trim($string)));
            self::$format = (int) $limit;

            //Cada espaço na string vira um índice novo
            $arrWords = explode (' ', self::$data);
            $numWords = count ($arrWords);
            $newWords = implode (' ', array_slice ($arrWords, 0, self::$format));

            if (empty ($pointer)){
                $pointer= '...';
            }else{
                $pointer= ' ' . $pointer;
            }

            if (self::$format< $numWords){
                $result = $newWords . $pointer ;
            }else{
               $result = self::$data;
            }
            return $result;

         }
    }

?>