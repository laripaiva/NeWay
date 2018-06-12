<?php
 /**
  * AdminCursos.class [MODEL]
  * Descrição: Responsável por gerenciar as categorias do sistema no administrador
  * Classe capaz de criar, editar, deletar cursos 
  */
    class AdminUsuarios{

        private $data;
        private $dataa;
        private $userId;
        private $error;
        private $result;

        //Nome da tabela no banco de dados 
        const Entity = 'users';

        public function readDesabilitados(){
            $readName = new Read;
            $readName->ExeRead(self::Entity, "WHERE level = :t", "t=1"); 

            if (!$readName->getResult()){
                $this->error = ['Não há usuários pendentes.',  E_USER_WARNING];
            }else{
                $this->error = ['Há usuários pendentes.',  E_USER_WARNING];
                $this->result = $readName;
            }
        }

        public function Desabilitar($id, $data){
            $this->userId = $id;
            $this->dataa= $data;
            $readName = new Read;
            $readName->ExeRead(self::Entity, "WHERE id = :id", "id={$this->userId}"); 
            $this->data = $readName->getResult()[0];
            $this->data['level'] = 1;
            $this->data['data_habilitacao'] = $this->dataa;

            $update = new Update;
            $update->exeUpdate (self::Entity, $this->data, "WHERE id = :i ", "i={$this->userId}");

            if ($update->getResult()){
                $this->result = true;
                $this->error = ["Usuário <b>{$this->data['nome']}</b> foi desabilitado.", ACCEPT];
            }else{
                $this->error = ["Erro.", _E_USER_NOTICE];
            }
        }

        public function Habilitar($id, $data){
            $this->userId = $id;
            $this->dataa= $data;
            $readName = new Read;
            $readName->ExeRead(self::Entity, "WHERE id = :id", "id={$this->userId}"); 
            $this->data = $readName->getResult()[0];
            $this->data['level'] = 2;
            $this->data['data_habilitacao'] = $this->dataa;
            $update = new Update;
            $update->exeUpdate (self::Entity, $this->data, "WHERE id = :i ", "i={$this->userId}");

            $dataPayment['data'] = $this->dataa;
            $dataPayment['id_user'] = $this->userId;
            $payment = new Create();
            $payment->ExeCreate ("payment", $dataPayment);

            if ($update->getResult()){
                $this->result = true;
                $this->error = ["Usuário <b>{$this->data['nome']}</b> foi habilitado.", ACCEPT];
            }else{
                $this->error = ["Não foi dessa vez", _E_USER_NOTICE];
            }
        }

        public function readHabilitados(){
            $readName = new Read;
            $readName->ExeRead(self::Entity, "WHERE level = :t", "t=2"); 

            if (!$readName->getResult()){
                $this->error = ['Não há usuários habilitados.',  E_USER_WARNING];
            }else{
                $this->error = ['Há usuários habilitados.',  E_USER_WARNING];
                $this->result = $readName;
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
        
        private function setTitleUpdate(){

            /**
             * CASO EXISTA UM courseId SIGNIFICA QUE VOCÊ ESTÁ EDITANDO E NÃO CRIANDO UM NOVO CURSO
             */
            if (!empty($this->courseId  )){
                $where = "id !={$this->courseId} AND";
            }else{
                $where= '';
            }
             
            $readName = new Read;
            $readName->ExeRead(self::Entity, "WHERE {$where} titulo = :t", "t={$this->data['titulo']}"); 
            
            
            //Caso exista um curso já cadastrado com esse nome será retornado um erro
            if ($readName->getResult()){
                $this->error = ['<b>Erro ao atualizar</b>, nome de curso já existente.',  E_USER_WARNING];
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
                $this->error = ["<b>Sucesso:</b> O curso <b>{$this->data['titulo']}</b> foi cadastrado no sistema.", E_USER_NOTICE];
            }      
        }

        private function Update(){
            $update = new Update;
            //entity -> variável com nome da tabela no BD
            $update->exeUpdate (self::Entity, $this->data, "WHERE id = :i", "i={$this->userId}");

            if ($update->getResult()){
                $this->result = true;
                $this->error = ["<b>Sucesso:</b> O curso <b>{$this->data['titulo']}</b> foi atualizado no sistema.", ACCEPT];
            }
           
        }
    }   
?>