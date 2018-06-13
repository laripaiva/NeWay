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
        <p class="title center-align">Atualizar Curso</p>
    </div>

    <?php
        $courseId= filter_input(INPUT_GET, 'courseId');
        $categoria = filter_input(INPUT_GET, 'categoria');
        
        $readCourse = new Read;
        $readCourse->exeRead("courses", "WHERE id = :id", "id={$courseId}");
        $dataCourse = $readCourse->getResult()[0];
        $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);

        $data['categoria'] = $categoria;

        if (!empty($data['SendPostForm'])){
            unset ($data['SendPostForm']);

            require('_models\AdminCursos.class.php');
            $cadastra = new AdminCursos;
            $cadastra->ExeUpdateCursos($courseId, $data);
            if ($cadastra->getResult()){
                header ('Location: painel.php?exe=cursos/upload&update=true&curso=' . $courseId);
            }else{
                frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
            }
            
        }else{
            $read = new Read;
            $read->exeRead("courses", "WHERE id = :id", "id={$courseId}");
            if (!$read->getResult()){
                //Se for gerado update falso, quer dizer que tentamos atualizar algo que não existe
                header ('Location: painel.php?exe=cursos/index&empty=true');
            }else{
                $data = $read->getResult()[0];
            }
        }
        // /**
        //  * Cadastrado -> Atualizar
        //  */
        // $checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
        // if ($checkCreate == 1){
        //     frontErro("O curso <b>{$data['titulo']}</b> foi cadastrado com sucesso. Continue atualizando.", ACCEPT);
        // }
    ?>
         <section class="container">
			<div class="row">
                <form name="CursoForm" action="" method="post">
					<div class="row">
						<div class="input-field col s12">
                            <input type="text" id="textarea1" class="materialize-textarea" name="titulo" value="<?php if (isset($dataCourse)) echo $dataCourse['titulo']; ?>"></textarea>
							<label id="textarea1">Título do Curso</label>
						</div>
						<div class="input-field col s12">
							<input type="text" id="textarea1" class="materialize-textarea" name="descricao" value="<?php if (isset($dataCourse)) echo  $dataCourse['descricao']; ?>"></textarea>
							<label for="textarea1">Descrição</label>
						</div>
						<div class="input-field col s12">
							<input type="time" id="textarea1" class="materialize-textarea" name="carga_horaria" value="<?php if (isset($dataCourse)) echo  $dataCourse['carga_horaria'];?>"/>
							<label for="textarea1">Carga Horária</label>
						</div>
					</div>	
                    <input type="submit" class="btn waves-effect waves-light sub" value="Atualizar Curso" name="SendPostForm" />
                    
					<!-- <button class="btn waves-effect waves-light sub" type="submit" name="SendPostForm">Cadastrar
						<i class="material-icons right">send</i>
					</button>		 -->
				</form>
			</div>
	    </section>
</div> 