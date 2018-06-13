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
            $readModule = new Read;
            $readModule->exeRead("modules", "WHERE id = :id", "id={$moduleId}");
            
            $dataModule = $readModule->getResult()[0];
            
        ?>
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
                    frontErro("oi", E_USER_NOTICE);
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

        <section class="container">
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