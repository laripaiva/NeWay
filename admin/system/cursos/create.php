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
        <p class="title center-align">Cadastrar Curso</p>
    </div>
  
    <?php
        $cat = filter_input (INPUT_GET, 'categoria');
        $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
        if (!empty($data['SendPostForm'])){
            unset ($data['SendPostForm']);      

            $data['categoria'] = (int) $cat;
            require('_models\AdminCursos.class.php');
            $cadastra = new AdminCursos;
            $cadastra->ExeCreateCursos($data);
    ?>
   
    <?php       
        
            if($cadastra->getResult()){
                $readData = new Read;
                $readData->exeRead("courses", "WHERE titulo = :t AND categoria = :c", "t={$data['titulo']}&c={$data['categoria']}");
                $cursos = $readData->getResult()[0];
                header ('Location: painel.php?exe=cursos/upload&create=true&curso=' . $cursos['id']);
            }else{
                frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
            }
        }
    ?>

        <section class="container">
			<div class="row">
                <form name="CursoForm" action="" method="post">
					<div class="row">
						<div class="input-field col s12">
                        <textarea id="textarea1" class="materialize-textarea" name="titulo" value="<?php if (isset($data)) echo $data['titulo']; ?>"></textarea>
							<label id="textarea1">Título do Curso</label>
						</div>
						<div class="input-field col s12">
							<textarea id="textarea1" class="materialize-textarea" name="descricao" value="<?php if (isset($data)) echo $data['descricao']; ?>"></textarea>
							<label for="textarea1">Descrição</label>
						</div>
						<div class="input-field col s12">
							<input type="time" id="textarea1" class="materialize-textarea" name="carga_horaria" value="<?php if (isset($data)) echo $data['carga_horaria']; ?>"/>
							<label for="textarea1">Carga Horária</label>
						</div>
					</div>	
                    <input type="submit" class="btn waves-effect waves-light sub" value="Cadastrar Curso" name="SendPostForm" />
				</form>
			</div>
	    </section>
</div> 