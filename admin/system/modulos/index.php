<?php
            //Pega o id e nome do curso da URL
            
            $courseId = filter_input (INPUT_GET, 'course', FILTER_VALIDATE_INT);
            $moduleId = filter_input (INPUT_GET, 'modulo', FILTER_VALIDATE_INT);
            $update = filter_input(INPUT_GET, 'update', FILTER_VALIDATE_BOOLEAN);
            if ($courseId){
                $readCourse = new Read;
                $readCourse->exeRead("courses", "WHERE id = :id", "id={$courseId}");
                $dataCourse = $readCourse->getResult()[0];
            }elseif( $moduleId && $update){
                $readModule = new Read;
                $readModule->exeRead ("modules", "WHERE id = :id", "id={$moduleId}");
                $modulos = $readModule->getResult()[0];
                $readCourse = new Read;
                $readCourse->exeRead("courses", "WHERE id = :id", "id={$modulos['id_courses']}");
                $dataCourse = $readCourse->getResult()[0];
            }
        ?>
    <div class="neway z-depth-5">
       <p class="title center-align">Gerenciar Módulos do curso <?php echo $dataCourse['titulo'];?></p>
    </div>  

    <section id="" class="categoria container">
        <?php 
            if ($moduleId && $update){
               frontErro("Módulo <b>{$modulos['titulo']}</b> atualizado com sucesso.", ACCEPT);
            }
        ?>
        <div class="cads">
            <?php   
                $readModule = new Read;
                $readModule->exeRead("modules", "WHERE id_courses = :idc", "idc={$dataCourse['id']}");
            
                foreach ($readModule->getResult() as $ses){
                    extract($ses);
            ?>
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4"><?=$titulo;?><i class="material-icons right">more_vert</i></span>
                            <p><a href="painel.php?exe=modulos/update&modulo=<?=$id?>">Editar</a></p>
                            <p><a href="painel.php?exe=textos/index&modulo=<?=$id?>">Gerenciar Textos</a></p>
                            <p><a href="painel.php?exe=videos/index&modulo=<?=$id?>">Gerenciar Vídeos</a></p>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4"><?=$titulo;?><i class="material-icons right">close</i></span>
                            <p><?=$descricao;?></p>
                        </div>
                    </div>
            <?php
                    }
            ?>
        </div> 
    </section>
</div>