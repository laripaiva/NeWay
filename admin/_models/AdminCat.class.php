<?php
 /**
  * AdminCursos.class [MODEL]
  * Descrição: Responsável por gerenciar as categorias do sistema no administrador
  * Classe capaz de criar, editar, deletar cursos 
  */
    class AdminCat{

        private $data;
        private $id;
        private $error;
        private $result;

        //Nome da tabela no banco de dados 
        const Entity = 'categorys';

        public function ExeCreateCat(array $data){
            $this->data = $data;

            //Verificar se há campos em branco no array, se houver retorna erro
            if (in_array('', $this->data)){
                $this->result = false;
                $this->error = ['<b>Erro ao cadastrar</b>, preencha o campo.',  E_USER_WARNING];
            }else{
                $this->setTitleCreate();                
            }
        }

        public function ExeUpdateCat($id, array $data){
            $this->id = (int) $id;
            $this->data = $data;

            //Verificar se há campos em branco no array, se houver retorna erro
            if (in_array('', $this->data)){
                $this->result = false;
                $this->error = ['<b>Erro ao atualizar</b>, preencha o campo.',  E_USER_WARNING];
            }else{
                $this->setTitleUpdate(); 
                }   
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

        private function setTitleCreate(){

            /**
             * CASO EXISTA UM courseId SIGNIFICA QUE VOCÊ ESTÁ EDITANDO E NÃO CRIANDO UM NOVO CURSO
             */
            if (!empty($this->id)){
                $where = "id !={$this->courseId} AND";
            }else{
                $where= '';
            }
             
            $readName = new Read;
            $readName->ExeRead(self::Entity, "WHERE {$where} nome = :n", "n={$this->data['nome']}"); 
            
            
            //Caso exista um curso já cadastrado com esse nome será retornado um erro
            if ($readName->getResult()){
                $this->error = ['<b>Erro ao cadastrar</b>, nome de categoria já existente.',  E_USER_WARNING];
            }else{
                self::Create();
            }
        }

        private function setTitleUpdate(){

            /**
             * CASO EXISTA UM courseId SIGNIFICA QUE VOCÊ ESTÁ EDITANDO E NÃO CRIANDO UM NOVO CURSO
             */
            if (!empty($this->id)){
                $where = "id !={$this->id} AND";
            }else{
                $where= '';
            }
             
            $readName = new Read;
            $readName->ExeRead(self::Entity, "WHERE {$where} nome = :n", "n={$this->data['nome']}"); 
            
            
            //Caso exista um curso já cadastrado com esse nome será retornado um erro
            if ($readName->getResult()){
                $this->error = ['<b>Erro ao atualizar</b>, nome de categoria já existente.',  E_USER_WARNING];
            }else{
                self:: Update();
            }
        }

        private function Create(){
            $create = new Create;
            //entity -> variável com nome da tabela no BD
            $create->ExeCreate (self::Entity, $this->data);

            if ($create->getResult()){
                //Obter ID do registro inserido
                $this->result = $create->getResult();
                $this->error = ["<b>Sucesso:</b> A categoria <b>{$this->data['nome']}</b> foi cadastrada no sistema.", ACCEPT];
            }      
        }

        private function Update(){
            $update = new Update;
            //entity -> variável com nome da tabela no BD
            $update->exeUpdate (self::Entity, $this->data, "WHERE id = :i", "i={$this->id}");

            if ($update->getResult()){
                $this->result = true;
                $this->error = ["<b>Sucesso:</b> A categoria <b>{$this->data['nome']}</b> foi atualizada no sistema.", ACCEPT];
            }
           
        }
    }   
?>