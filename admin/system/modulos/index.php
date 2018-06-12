<div class="content cat_list">
    <section>

        <?php
            $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
            //Pega o id e nome do curso da URL
           
            $courseId = filter_input (INPUT_GET, 'courseId', FILTER_VALIDATE_INT);
            $readCourse = new Read;
            $readCourse->exeRead("courses", "WHERE id = :id", "id={$courseId}");
            $nomeCourse = filter_input (INPUT_GET, 'nome');
            
            
            
        ?>
        <h1>Modulos do curso <?php echo $nomeCourse; ?></h1>
        <li><a class="act_delete" href="painel.php?exe=modulos/create&courseId=<?php echo $courseId;?>&nomeCourse=<?php echo $nomeCourse;?>" title="Excluir">Criar Modulos</a></li>
        <?php

            if (!empty($data['SendPostForm'])){
                unset ($data['SendPostForm']);

                require('_models\AdminCursos.class.php');
                $cadastra = new AdminCursos;
                $cadastra->ExeUpdateCursos($courseId, $data);
                frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
            }else{ 
                $readData = new Read;
                $readData->exeRead("modules", "WHERE id != :d AND id_courses= :idC", "d=0&idC={$courseId}");
                foreach ($readData->getResult() as $ses){
                    extract($ses);
            
        ?>
            <section>

                <header>
                    <h1><?=$titulo;?></h1><br> 
                    <p class="tagline"><b>Descrição: </b><?=$descricao; ?></p>
                    <ul>
                        <li><a class="act_view" target="_blank" href="painel.php?exe=posts/post&id=ID_DO_POST" title="Ver no site">Ver no site</a></li>
                        <li><a class="act_edit" href="painel.php?exe=modulos/update&moduleId=<?=$id?>&nameCourse=<?= $nomeCourse?>&idCourse=<?=$courseId?>" title="Editar">Editar</a></li>
                        <li><a class="act_delete" href="painel.php?exe=modulos/delete&moduleId=<?=$id?>" title="Excluir">Deletar</a></li>
                        <li><a class="act_delete" href="painel.php?exe=videos/index&module=<?=$id?>&name=<?=$titulo;?>" title="Excluir">Gerenciar Vídeos</a></li>
                        <li><a class="act_delete" href="painel.php?exe=textos/index&module=<?=$id?>&name=<?=$titulo;?>" title="Excluir">Gerenciar Textos</a></li>
                    </ul>
                </header>
                
               
                <?php 
                
                ?>

            </section>
        <?php 
          }
        }
        ?>

        <div class="clear"></div>
    </section>

    <div class="clear"></div>
</div> <!-- content home -->