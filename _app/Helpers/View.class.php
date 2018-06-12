<?php
    /**
     * Classe do tipo Helper MVC
     * É responsável por carregar o template, povoar e exibir a view, povoar e incluir arquivos PHP no sistema
     * Arquitetura MVC
     */

    class View {
        
        private static $data;
        private static $keys;
        private static $values;
        private static $template;

        public static function load ($template){
            self::$template = (string) $template;
            self::$template = file_get_contents(self::$template . '.tpl.html');
        }

        public static function show (array $data){
            self::setKeys($data);
            self::setValues();
            self::showView();
        }

        public static function request($file, array $data){
            extract($data);
            require ("{$file}.inc.php");
        }


        /**
         * MÉTODOS PRIVADOS
         */

        private static function setKeys($data){
            self::$data = $data;
            self::$keys = explode ('&', '#' . implode("#&#", array_keys(self::$data)) . '#');
        }

        private static function setValues(){
            self::$values = array_values(self::$data);
        }

        private static function showView(){
            echo str_replace(self::$keys, self::$values, self::$template);
        }

    }
?>