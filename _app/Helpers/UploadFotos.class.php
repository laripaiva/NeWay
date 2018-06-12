<?php

/**
 * CLASSE ESPECIALIZADA EM REALIZAR UPLOADS DE IMAGENS 
 */

    class UploadFotos{

        private $file; 
        private $error;
        private $dir;
        private $folder;

        public function upload(array $file, $diretorio){
            $this->file = $file;
            $this->folder = (string) $diretorio;
            if (!$file){
                $this->error = ['Não há arquivo para fazer upload.', E_USER_WARNING];
            }else{
                $this->dir = $this->folder ."/".$file['name'];
                if (move_uploaded_file($file['tmp_name'],$this->dir)) {
                    $this->error = ['O upload do arquivo foi realizado.', ACCEPT];
                }else {
                    $this->error = ['O upload do arquivo não foi realizado.', E_USER_WARNING]; 
                }
            }
        }

        public function getDir(){
            return $this->dir;
        } 

        public function getError(){
            return $this->error;
        }

    }

?>