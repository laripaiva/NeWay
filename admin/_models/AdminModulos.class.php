<?php
 /**
  * AdminModulos.class [MODEL]
  * Descrição: Responsável por gerenciar as categorias do sistema no administrador
  * Classe capaz de criar, editar, deletar módulos 
  */
    class AdminModulos{

        private $data;
        private $moduleId;
        private $courseId;
        private $error;
        private $result;

        //Nome da tabela no banco de dados 
        const Entity = 'modules';

        public function ExeCreateModulos(array $data, $courseId){
            $this->data = $data;
            $this->courseId = (int) $courseId;

            //Verificar se há campos em branco no array, se houver retorna erro
            if (in_array('', $this->data)){
                $this->result = false;
                $this->error = ['<b>Erro ao cadastrar</b>, preencha todos os campos.',  E_USER_WARNING];
            }else{
                $this->setTitleCreate();                
            }
        }

        public function ExeUpdateModulos($moduleId, array $data, $idCourse){
            $this->moduleId = (int) $moduleId;
            $this->data = $data;
            $this->courseId = (int) $idCourse;

            //Verificar se há campos em branco no array, se houver retorna erro
            if (in_array('', $this->data)){
                $this->result = false;
                $this->error = ['<b>Erro ao atualizar</b>, preencha todos os campos.',  E_USER_WARNING];
            }else{
                self::setTitleUpdate();
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

        private function setData(){
            /**
             * array_map() -> Função que retorna um array1 depois de aplicada uma determinada função
             * Funções aplicadas: strip_tags, trim
             */
            $this->data = array_map('strip_tags', $this->data);
            $this->data = array_map('trim', $this->data);
            /**
             * Validando o nome do curso de acordo com a função VALIDATENAME na classe CHECK dentro da pasta HELPERS
             */
            $this->data['titulo'] = Check:: validateName($this->data['titulo']);
        }

        /**
         * Método será usado para cadastrar e para deletar
         */

        private function setTitleCreate(){

            //INSERINDO ID_COURSES NO ARRAY -> OBJETIVO: APARECER NA QUERY
            $this->data['id_courses'] = (int) $this->courseId;

            /**
             * CASO EXISTA UM moduleId SIGNIFICA QUE VOCÊ ESTÁ EDITANDO E NÃO CRIANDO UM NOVO MODULO
             */
            if (!empty($this->courseId)){
                $where = "id_courses = {$this->courseId}";
            }else{
                $where= '';
            } 
           
            $readName = new Read;
            $readName->exeRead(self::Entity, "WHERE {$where} AND titulo = :t", "t={$this->data['titulo']}"); 

            // Caso exista um curso já cadastrado com esse nome será retornado um erro
            if ($readName->getResult()){
                $this->error = ['<b>Erro ao cadastrar</b>, nome de módulo já existente.',  E_USER_WARNING];
            }
            else{
                self::Create();
            }
        }

        private function setTitleUpdate(){

            /**
             * CASO EXISTA UM courseId SIGNIFICA QUE VOCÊ ESTÁ EDITANDO E NÃO CRIANDO UM NOVO CURSO
             */
            if (!empty($this->moduleId)){
                $where = "id !={$this->moduleId} AND id_courses ={$this->courseId} AND";
            }else{
                $where= '';
            }
             
            $readName = new Read;
            $readName->ExeRead(self::Entity, "WHERE {$where} titulo = :t ", "t={$this->data['titulo']}"); 
            
            //Caso exista um curso já cadastrado com esse nome será retornado um erro
            if ($readName->getResult()){
                $this->error = ['<b>Erro ao atualizar</b>, nome de modulo já existente no mesmo curso.',  E_USER_WARNING];
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
                $this->error = ["<b>Sucesso:</b> O modulo {$this->data['titulo']} foi cadastrado no sistema.", E_USER_NOTICE];
            }   
        }

        private function Update(){
            $update = new Update;
            //entity -> variável com nome da tabela no BD
            $update->exeUpdate (self::Entity, $this->data, "WHERE id = :i", "i={$this->moduleId}");

            if ($update->getResult()){
                $this->result = true;
                $this->error = ["<b>Sucesso:</b> O módulo <b>{$this->data['titulo']}</b> foi atualizado no sistema.", ACCEPT];
            }
           
        }
    }   
?>