<?php
/**
 * Caso aja tentativa de acessar essa página sem passar pelo painel, irá ser redirecionado para o painel
 * Método para previnir acessos inadequados ao sistema
 */
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;

$courseId = filter_input (INPUT_GET, 'course', FILTER_VALIDATE_INT);
$readData = new Read;
$readData->exeRead("modules", "WHERE id_courses = :d", "d={$courseId}");
$nModulos = $readData->getRowCount();
?>

<?php
    //Pega o id e nome do curso da URL

    $courseId = filter_input (INPUT_GET, 'course', FILTER_VALIDATE_INT);
    $moduleId = filter_input (INPUT_GET, 'modulo', FILTER_VALIDATE_INT);
    $update = filter_input(INPUT_GET, 'update', FILTER_VALIDATE_BOOLEAN);
    $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);

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
       <p class="title center-align">Módulos do curso <?php echo $dataCourse['titulo'];?></p>
    </div>

    <section id="" class="categoria container">
        <?php
            if ($moduleId && $update){
               frontErro("Módulo <b>{$modulos['titulo']}</b> atualizado com sucesso.", ACCEPT);
            }elseif($empty){
                frontErro("<b>Erro:</b> o módulo não pode ser atualizado.", E_USER_WARNING);
            }
        ?>
        <div class="cads">
            <?php
            $certificado=0;
                $readModule = new Read;
                $readModule->exeRead("modules", "WHERE id_courses = :idc", "idc={$dataCourse['id']}");

                foreach ($readModule->getResult() as $ses){
                    extract($ses);
            ?>
                    <div class="card">
					<div class="card-content">
						<span class="card-title activator grey-text text-darken-4"><?=$titulo;?></span>
                        <p><b>Categoria:</b><?=$titulo;?></p>
                        <p><b>Descrição:</b><?=$titulo;?></p>
                        <?php

                            $readMatricula = new Read;
                            $readMatricula->exeRead("watch_courses", "WHERE id_user = :u AND id_courses = :c", "u={$userlogin['id']}&c={$courseId}");
                            $readMatricula = $readMatricula->getResult()[0];

                            $readProgress = new Read;
                            $readProgress->exeRead("historic", "WHERE id_watch_courses = :d", "d={$readMatricula['id']}");


                            if ($readMatricula){
                        ?>
                                <?php

                                    for ($i=0 ; $i < $readProgress->getRowCount(); $i++){
                                        $historico = $readProgress->getResult()[$i];
                                        if ($historico['id_module'] ==  $id){
                                            $result = "Assistido";
                                            $certificado++;
                                            // $certificado= $certificado + 1;
                                ?>
                                <p class="tagline"><b>Status: </b><?php echo $result; ?></p>
                                <?php

                                        }
                                    }
                                ?>
                                <p><a href="dashboard.php?exe=modulos/index&course=<?=$id?>">Visualizar Textos</a></p>
						        <p><a href="dashboard.php?exe=videos/index&modulo=<?=$id?>&aluno=<?php echo $userlogin['id']; ?>"> Visualizar Vídeos</a></p>
                        <?php
                            }

                        ?>

					</div>
                </div>
            <?php
                    }
            ?>
             <?php
                        if ($readModule->getRowCount() == $certificado){
                            $dados = new Read;
                            $dados->exeRead("users", "WHERE id = :id", "id={$userlogin['id']}");
                            $curso = new Read;
                            $curso->exeRead("courses", "WHERE id = :id", "id={$courseId}");
                            $dados= $dados->getResult()[0];
                            $curso =$curso->getResult()[0];
                    ?>
                        <a href="..\_app\Models\gerador.php?aluno=<?php echo $dados['id'];?>&curso=<?php echo $curso['titulo'];?>">Curso concluído. Imprima o certificado.</a> 
                    <?php
                        }
                    ?>
        </div>
    </section>
</div>
