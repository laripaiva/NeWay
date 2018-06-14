<?php
/**
 * Caso aja tentativa de acessar essa página sem passar pelo painel, irá ser redirecionado para o painel
 * Método para previnir acessos inadequados ao sistema
 */
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;
?>

<div class="content form_create">
    <div class="neway z-depth-5">
        <p class="title center-align">Atualizar Módulo</p>
    </div>
        <?php
            // //PEGA ID DO MODULO PELA URL E FAZ LEITURA
            $moduleId = filter_input (INPUT_GET, 'modulo', FILTER_VALIDATE_INT);
            $courseId = filter_input (INPUT_GET, 'course', FILTER_VALIDATE_INT);
            
            if ($courseId){
                $readCourse = new Read;
                $readCourse->exeRead("courses", "WHERE id = :id", "id={$courseId}");
                $dataCourse = $readCourse->getResult()[0];
                if (!$dataCourse){
                    header ('Location: painel.php?exe=index&empty=true');
                }elseif($moduleId){
                    $readModule = new Read;
                    $readModule->exeRead("modules", "WHERE id = :id AND id_courses = :idc", "id={$moduleId}&idc={$courseId}");
                    if($readModule->getResult()){
                        $dataModule = $readModule->getResult()[0];
                    }elseif(!$readModule->getResult()){
                        header ('Location: painel.php?exe=index&empty=true');
                        //PRECISO CONSERTAR ISSO
                    }   
                }else{
                    header ('Location: painel.php?exe=index&empty=true');
                } 
            }else{
                header ('Location: painel.php?exe=index&empty=true');
            }
        ?>
        <section class="container">
        <?php
            $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
    
            if (!empty($data['SendPostForm'])){
                unset ($data['SendPostForm']);

                require('_models\AdminModulos.class.php');
                $cadastra = new AdminModulos;
                $cadastra->ExeUpdateModulos($moduleId, $data, $dataModule['id_courses']);
                
                if ($cadastra->getResult()){
                    header ('Location: painel.php?exe=modulos/index&update=true&modulo=' .  $moduleId);
                }else{
                    header ('Location: painel.php?exe=modulos/index&empty=true&curso=' . $dataModule['id_courses']);
                }
                
            }
            // else{
            //     $read = new Read;
            //     $read->exeRead("modules", "WHERE id = :id", "id={$moduleId}");
            //     if (!$read->getResult()){
            //         //Se for gerado update falso, quer dizer que tentamos atualizar algo que não existe
            //         header ('Location: painel.php?exe=cursos/index&empty=true');
            //     }else{
            //         $data = $read->getResult()[0];
            //     }
            // }
        ?>
			<div class="row">
                <form name="CursoForm" action="" method="post">
					<div class="row">
						<div class="input-field col s12">
                            <input type="text" id="textarea1" class="materialize-textarea" name="titulo" value="<?php if (isset($dataModule)) echo $dataModule['titulo']; ?>"></textarea>
							<label id="textarea1">Título do Módulo</label>
						</div>
						<div class="input-field col s12">
							<input type="text" id="textarea1" class="materialize-textarea" name="descricao" value="<?php if (isset($dataModule)) echo  $dataModule['descricao']; ?>"></textarea>
							<label for="textarea1">Descrição</label>
						</div>
					</div>	
                    <input type="submit" class="btn waves-effect waves-light sub" value="Atualizar Curso" name="SendPostForm" />
                    
				</form>
			</div>
	    </section>
</div> 