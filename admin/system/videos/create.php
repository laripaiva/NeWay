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
        <p class="title center-align">Adicionar vídeo</p>
    </div>
  
    <?php
        $modulo = filter_input (INPUT_GET, 'module', FILTER_VALIDATE_INT);
        $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
        if (!empty($data['SendPostForm'])){
            unset ($data['SendPostForm']);      

            require('_models\AdminVideos.class.php');
            $cadastra = new AdminVideos;
            $cadastra->ExeCreateVideos($data, $modulo);
    ?>
   
   <section class="container">
    <?php       

        if($cadastra->getResult()){
            header ('Location: painel.php?exe=videos/upload&create=true&video=' . $cadastra->getResult());
        }else{
            frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
        }
    }
    ?>
    </section>  
        <section class="container">
			<div class="row">
                <form name="CursoForm" action="" method="post">
					<div class="row">
						<div class="input-field col s12">
                        <textarea id="textarea1" class="materialize-textarea" name="titulo" value="<?php if (isset($data)) echo $data['titulo']; ?>"></textarea>
							<label id="textarea1">Título do vídeo</label>
						</div>
						<div class="input-field col s12">
							<textarea id="textarea1" class="materialize-textarea" name="descricao" value="<?php if (isset($data)) echo $data['descricao']; ?>"></textarea>
							<label for="textarea1">Descrição</label>
						</div>
					</div>	
                    <input type="submit" class="btn waves-effect waves-light sub" value="Cadastrar Video" name="SendPostForm" />
				</form>
			</div>
	    </section>
</div> 