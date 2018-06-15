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
        <p class="title center-align">Atualizar Texto</p>
    </div>
        <?php
            // //PEGA ID DO MODULO PELA URL E FAZ LEITURA
            $moduleId = filter_input (INPUT_GET, 'module', FILTER_VALIDATE_INT);
            $arquivoId = filter_input (INPUT_GET, 'arquivo', FILTER_VALIDATE_INT);

            if ($moduleId){
                $readModule = new Read;
                $readModule->exeRead("modules", "WHERE id = :id", "id={$moduleId}");
                if (!$readModule->getResult()){
                    header ('Location: painel.php?exe=index&empty=true');
                }elseif ($arquivoId){
                    $readFile = new Read;
                    $readFile->exeRead("texts", "WHERE id = :id AND id_modules = :idm", "id={$arquivoId}&idm={$moduleId}");
                    if (!$readFile->getResult()){
                        header ('Location: painel.php?exe=index&empty=true');
                    }else{
                        $dataFile= $readFile->getResult()[0];
                    }
                }elseif($arquivoId==null){
                    header ('Location: painel.php?exe=index&empty=true');
                }
        }elseif($moduleId==null){
            header ('Location: painel.php?exe=index&empty=true');
        }
            
        ?>
        <section class="container">
            <?php
                $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
        
                if (!empty($data['SendPostForm'])){
                    unset ($data['SendPostForm']);

                    require('_models\AdminTextos.class.php');
                    $cadastra = new AdminTextos;
                    $cadastra->ExeUpdateTexts($data, $dataFile['id']);
                    
                    if (!$cadastra->getResult()){
                        frontErro($cadastra->getError()[0],$cadastra->getError()[0]);
                    }else{
                        header ('Location: painel.php?exe=textos/upload&update=true&file=' . $dataFile['id']);
                    }
                    
                }
            ?>
			<div class="row">
                <form name="CursoForm" action="" method="post">
					<div class="row">
						<div class="input-field col s12">
                            <input type="text" id="textarea1" class="materialize-textarea" name="titulo" value="<?php if (isset($dataFile)) echo $dataFile['titulo']; ?>"></textarea>
							<label id="textarea1">Título do Arquivo</label>
						</div>
						<div class="input-field col s12">
							<input type="text" id="textarea1" class="materialize-textarea" name="descricao" value="<?php if (isset($dataFile)) echo  $dataFile['descricao']; ?>"></textarea>
							<label for="textarea1">Descrição</label>
						</div>
					</div>	
                    <input type="submit" class="btn waves-effect waves-light sub" value="Atualizar Arquivo" name="SendPostForm" />
                    
				</form>
			</div>
	    </section>
</div> 