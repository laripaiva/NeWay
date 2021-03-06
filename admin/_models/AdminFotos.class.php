<?php
 /**
  * AdminModulos.class [MODEL]
  * Descrição: Responsável por gerenciar as categorias do sistema no administrador
  * Classe capaz de criar, editar, deletar vídeos 
  */
    class AdminFotos{

        private $courseId;
        private $error;
        private $result;
        private $dir;
        private $dados;

        //Nome da tabela no banco de dados 
        
        public function ExeUploadImg($courseId, $dir){
            $this->$courseId = (int) $courseId;
            $this->dir = $dir;

            $data = new Read;
            $data->exeRead("courses", "WHERE id= :id", "id={$this->$courseId}"); 

            (array)$this->data = $data->getResult()[0];

            $this->data['foto']=$this->dir;
            $update = new Update;
            $update->exeUpdate ("courses", $this->data, "WHERE id = :i", "i={$this->$courseId}");
            
            if ($update->getResult()){
                $this->result = true;
                $this->error = ["<b>Sucesso:</b> upload realizado.", ACCEPT];
            }else{
                $this->error = ["Upload não realizado. Tente novamente.", E_USER_WARNING];
            }
        }

        public function ExeUpdateUploadVideos(array $data){
            $this->data = $data;
            /**
             * PEGANDO ID DO MODULO
             */
            
            $readVideo = new Read;
            $readVideo->exeRead("videos", "WHERE id= :id", "id={$this->data['id']}");
            if ($readVideo->getResult()[0]){
                $update = new Update;
                $update->exeUpdate ("videos", $this->data, "WHERE id = :i", "i={$this->data['id']}");
                if ($update->getResult()){
                    $this->error = ["<b>Sucesso:</b> upload realizado.", ACCEPT];
                    $this->result = true;
                }
            }
        }

        public function ExeUpdateUploadFiles(array $data){
            $this->data = $data;
            /**
             * PEGANDO ID DO MODULO
             */
            
            $readVideo = new Read;
            $readVideo->exeRead("texts", "WHERE id= :id", "id={$this->data['id']}");
            if ($readVideo->getResult()[0]){
                $update = new Update;
                $update->exeUpdate ("texts", $this->data, "WHERE id = :i", "i={$this->data['id']}");
                if ($update->getResult()){
                    $this->error = ["<b>Sucesso:</b> upload realizado.", ACCEPT];
                    $this->result = true;
                }
            }
        }

        public function ExeUpdateVideos(array $data, $videoId, $dir = null){
            $this->data = $data;
            $this->videoId = (int) $videoId;
            $this->dir = $dir;

            var_dump($data);
            /**
             * PEGANDO ID DO MODULO
             */
            $readVideo = new Read;
            $readVideo->exeRead("videos", "WHERE id= :id", "id={$this->$videoId}");
            
            // if ($readVideo->getResult()){
            //     $this->setTitleUpdate(); 
            // }                     
        }
        
        public function getResult(){
            return $this->result;
        }

        public function getError(){
            return $this->error;
        }

        /******************
         * MÉTODOS PRIVADOS
         ******************/

        /**
         * Método será usado para cadastrar e para deletar
         */

        private function setTitleCreate(){

            //INSERINDO ID_COURSES NO ARRAY -> OBJETIVO: APARECER NA QUERY
            $this->data['id_modules'] = (int) $this->moduleId;
            // $this->data['diretorio'] = $this->dir;

            /**
             * CASO EXISTA UM moduleId SIGNIFICA QUE VOCÊ ESTÁ EDITANDO E NÃO CRIANDO UM NOVO MODULO
             */
            if (!empty($this->moduleId)){
                $where = "id_modules = {$this->moduleId}";
            }else{
                $where= '';
            } 
           
            $readName = new Read;
            $readName->exeRead(self::Entity, "WHERE {$where} AND titulo = :t", "t={$this->data['titulo']}"); 

            // Caso exista um curso já cadastrado com esse nome será retornado um erro
            if ($readName->getResult()){
                $this->error = ['<b>Erro ao cadastrar</b>, nome de vídeo já existente no módulo.',  E_USER_WARNING];
            }
            else{
                self::Create();
            }
        }

        private function setTitleUpdate(){

            /**
             * CASO EXISTA UM courseId SIGNIFICA QUE VOCÊ ESTÁ EDITANDO E NÃO CRIANDO UM NOVO CURSO
             */
            if (!empty($this->videoId)){
                $where = "id !={$this->videoId} AND id_modules = {$this->data['id_modules']} AND";
            }else{
                $where= '';
            }
            
            $readName = new Read;
            $readName->ExeRead(self::Entity, "WHERE {$where} titulo = :t", "t={$this->data['titulo']}"); 
            
            //Caso exista um curso já cadastrado com esse nome será retornado um erro
            if ($readName->getResult()){
                $this->error = ['<b>Erro ao atualizar</b>, nome de vídeo já existente no mesmo módulo.',  E_USER_WARNING];
            }else{
                self::Update();
            }
        }

        private function Create(){

            $create = new Create;
            //entity -> variável com nome da tabela no BD
            $create->ExeCreate (self::Entity, $this->data);

        
            if ($create->getResult()){
                //Obter ID do registro inserido
                $this->result = $create->getResult();
                $this->error = ["<b>Sucesso:</b> O vídeo {$this->data['titulo']} foi cadastrado no sistema.", E_USER_NOTICE];
            }   
        }


        private function Update(){
            $update = new Update;
            //entity -> variável com nome da tabela no BD
            $update->exeUpdate (self::Entity, $this->data, "WHERE id = :i", "i={$this->videoId}");
            if ($update->getResult()){
                $this->result = true;
                $this->error = ["<b>Sucesso:</b> O vídeo <b>{$this->data['titulo']}</b> foi atualizado no sistema.", ACCEPT];
            }
           
        }
    }   
?>