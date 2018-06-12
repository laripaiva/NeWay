<div class="content cat_list">

    <section>

        <h1>Cursos:</h1>
        <li><a href="painel.php?exe=cursos/categoria">Criar curso</a></li>
        <?php
            /************************************************************************************************
            * VERIFICAR SE ERROS E SUCESSOS NO CADASTRAMENTO  E ATUALIZAÇÃO DE CURSOS
            ************************************************************************************************/
            $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
            $create = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
            $upload = filter_input(INPUT_GET, 'upload', FILTER_VALIDATE_BOOLEAN);
            $update = filter_input(INPUT_GET, 'update', FILTER_VALIDATE_BOOLEAN);
            $course = filter_input (INPUT_GET, 'curso', FILTER_VALIDATE_INT);        
            
            if ($create &&  $upload && $course){
                $readCourse = new Read;
                $readCourse->exeRead("courses", "WHERE id = :id", "id={$course}");
                $nomeCourse= $readCourse->getResult()[0];
                frontErro("O curso <b>{$nomeCourse['titulo']} </b>foi atualizado com sucesso.", ACCEPT);
            }
            // elseif ($update &&  $catId){
            //     $readCat = new Read;
            //     $readCat->exeRead("categorys", "WHERE id = :id", "id={$catId}");
            //     $nomeCat= $readCat->getResult()[0];
            //     frontErro("A categoria <b>{$nomeCat['nome']} </b>foi atualizada com sucesso.", ACCEPT);
            // }
            // elseif($empty){
            //     frontErro("<b> Erro </b>, você tentou atualizar uma categoria que não existe.", E_USER_WARNING);
            // }
        ?>
        <?php
            $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
            if ($empty){
                frontErro("Você tentou editar uma categoria que não existe no sistema.", E_USER_NOTICE);
            }   
            $readData = new Read;
            $readData->exeRead("courses", "WHERE id != :d", "d=0");

            foreach ($readData->getResult() as $ses){
                extract($ses);
            
        ?>
            <section>
                <header>
                    <h1><?=$titulo; ?></h1><br>
                    <embed height="200" src="<?=$foto; ?>" width="200"></embed>
                    <p class="tagline"><b>Categoria:</b><?=$categoria?></p> 
                    <p class="tagline"><b>Número de módulos:</b></p> 
                    <p class="tagline"><b>Descrição: </b><?=$descricao; ?></p>
                    <ul>
                        <li><a class="act_edit" href="painel.php?exe=cursos/updatecat&courseId=<?=$id?>" title="Editar">Editar</a></li>
                        <li><a class="act_delete" href="painel.php?exe=modulos/index&courseId=<?=$id?>&nome=<?=$titulo; ?>" title="Modulos">Gerenciar Módulos</a></li>
                    </ul>
                </header>
            </section>
        <?php 
          }
        ?>
    </section>
</div> <!-- content home -->