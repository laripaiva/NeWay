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
        <p class="title center-align">Atualizar Video</p>
    </div>
        <?php
            // //PEGA ID DO MODULO PELA URL E FAZ LEITURA
            $moduleId = filter_input (INPUT_GET, 'module', FILTER_VALIDATE_INT);
            $videoId = filter_input (INPUT_GET, 'video', FILTER_VALIDATE_INT);

            if ($moduleId){
                $readModule = new Read;
                $readModule->exeRead("modules", "WHERE id = :id", "id={$moduleId}");
                if (!$readModule->getResult()){
                    header ('Location: painel.php?exe=index&empty=true');
            }elseif ($videoId){
                $readVideo = new Read;
                $readVideo->exeRead("videos", "WHERE id = :id AND id_modules = :idm", "id={$videoId}&idm={$moduleId}");
                if (!$readVideo->getResult()){
                    header ('Location: painel.php?exe=index&empty=true');
                }else{
                    $dataVideo= $readVideo->getResult()[0];
                }
            }elseif($videoId==null){
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

                    require('_models\AdminVideos.class.php');
                    $cadastra = new AdminVideos;
                    $cadastra->ExeUpdateVideos($data, $dataVideo['id']);
                    
                    if (!$cadastra->getResult()){
                        frontErro($cadastra->getError()[0],$cadastra->getError()[0]);
                    }else{
                        header ('Location: painel.php?exe=videos/upload&update=true&video=' . $dataVideo['id']);
                    }
                    
                }
            ?>
			<div class="row">
                <form name="CursoForm" action="" method="post">
					<div class="row">
						<div class="input-field col s12">
                            <input type="text" id="textarea1" class="materialize-textarea" name="titulo" value="<?php if (isset($dataVideo)) echo $dataVideo['titulo']; ?>"></textarea>
							<label id="textarea1">Título do Video</label>
						</div>
						<div class="input-field col s12">
							<input type="text" id="textarea1" class="materialize-textarea" name="descricao" value="<?php if (isset($dataVideo)) echo  $dataVideo['descricao']; ?>"></textarea>
							<label for="textarea1">Descrição</label>
						</div>
					</div>	
                    <input type="submit" class="btn waves-effect waves-light sub" value="Atualizar Video" name="SendPostForm" />
                    
				</form>
			</div>
	    </section>
</div> 