<?php
 /**
  * AdminCursos.class [MODEL]
  * Descrição: Responsável por gerenciar as categorias do sistema no administrador
  * Classe capaz de criar, editar, deletar cursos 
  */
    class AdminCursos{

        private $data;
        private $courseId;
        private $error;
        private $result;
        private $countModules;

        //Nome da tabela no banco de dados 
        const Entity = 'courses';

        public function ExeCreateCursos(array $data){
            $this->data = $data;

            //Verificar se há campos em branco no array, se houver retorna erro
            if (in_array('', $this->data)){
                $this->result = false;
                $this->error = ['<b>Erro ao cadastrar</b>, preencha todos os campos.',  E_USER_WARNING];
            }else{
                $this->setTitleCreate();            
            }
        }

        public function ExeUpdateCursos($cursoId, array $data){
            $this->courseId = (int) $cursoId;
            $this->data = $data;

            //Verificar se há campos em branco no array, se houver retorna erro
            if (in_array('', $this->data)){
                $this->result = false;
                $this->error = ['<b>Erro ao atualizar</b>, preencha todos os campos.',  E_USER_WARNING];
            }else{
                //Fazer validação dos dados
                // $this->setData();
                //Verificar se há outro curso com o mesmo nome
                $this->setTitleUpdate(); 
                }   
        }

        public function getResult(){
            return $this->result;
        }

        public function getError(){
            return $this->error;
        }

        // public function getCount(){
        //     return $this->countModules;
        // }

        /******************
         * MÉTODOS PRIVADOS
         ******************/

        //Função que irá contar a quantidade de módulos de cada curso
        // public function count(){
        //     // $this->countModules = exeReadCountModules ("modules","id_courses","WHERE id_courses = {$this->$courseId}");
        //     $this->countModules = 1;
        // }

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

            /**
             * CASO EXISTA UM courseId SIGNIFICA QUE VOCÊ ESTÁ EDITANDO E NÃO CRIANDO UM NOVO CURSO
             */
            if (!empty($this->courseId)){
                $where = "id !={$this->courseId} AND";
            }else{
                $where= '';
            }
             
            $readName = new Read;
            $readName->ExeRead(self::Entity, "WHERE {$where} titulo = :t AND categoria = :c", "t={$this->data['titulo']}&c={$this->data['categoria']}"); 
            
            
            //Caso exista um curso já cadastrado com esse nome será retornado um erro
            if ($readName->getResult()){
                $this->error = ['<b>Erro ao cadastrar</b>, nome de curso já existente nesse mesmo módulo.',  E_USER_WARNING];
            }else{
                self::Create();
            }
        }

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
            $readName->ExeRead(self::Entity, "WHERE {$where} titulo = :t AND categoria = :c", "t={$this->data['titulo']}&c={$this->data['categoria']}"); 
            
            
            //Caso exista um curso já cadastrado com esse nome será retornado um erro
            if ($readName->getResult()){
                $this->error = ['<b>Erro ao atualizar</b>, nome de curso já existente no mesmo módulo.',  E_USER_WARNING];
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
            $update->exeUpdate (self::Entity, $this->data, "WHERE id = :i", "i={$this->courseId}");

            if ($update->getResult()){
                $this->result = true;
                $this->error = ["<b>Sucesso:</b> O curso <b>{$this->data['titulo']}</b> foi atualizado no sistema.", ACCEPT];
            }
           
        }
    }   
?>