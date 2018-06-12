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

        <?php
            /**
             * VERIFICADOR DE VARIÁVEL CREATE 
             */
            $checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
            $nameModule = filter_input(INPUT_GET, 'nameModule');
            $idCourse = filter_input(INPUT_GET, 'idCourse', FILTER_VALIDATE_INT);
            if ($checkCreate == 1){
                frontErro("O módulo <b>{$nameModule}</b> foi cadastrado com sucesso. Continue atualizando.", ACCEPT);
            } 
            /*************************************/

            // //PEGA ID DO MODULO PELA URL E FAZ LEITURA
            $moduleId = filter_input (INPUT_GET, 'moduleId', FILTER_VALIDATE_INT);
            $readModule = new Read;
            $readModule->exeRead("modules", "WHERE id = :id", "id={$moduleId}");

            // //PEGA NOME DO CURSO PELA URL
            $nameCourse = filter_input (INPUT_GET, 'nameCourse');                   

            
        ?>

    <article>

        <header>
            <h1>Atualizar módulo no curso <?php echo $nameCourse; ?></h1>
        </header>

        
        <?php
             $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
    
            if (!empty($data['SendPostForm'])){
                unset ($data['SendPostForm']);

                require('_models\AdminModulos.class.php');
                $cadastra = new AdminModulos;
                $cadastra->ExeUpdateModulos($moduleId, $data, $idCourse);
                
                frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
            }
            else{
                $read = new Read;
                $read->exeRead("modules", "WHERE id = :id", "id={$moduleId}");
                if (!$read->getResult()){
                    //Se for gerado update falso, quer dizer que tentamos atualizar algo que não existe
                    header ('Location: painel.php?exe=cursos/index&empty=true');
                }else{
                    $data = $read->getResult()[0];
                }
            }
        ?>

        <form name="UpdateForm" action="" method="post" enctype="multipart/form-data">
            <label class="label">   
                <span class="field">Titulo:</span>
                <input type="text" name="titulo" value="<?php if (isset($data)) echo $data['titulo']; ?>" />
            </label>
           
            <label class="label">
                <span class="field">Descrição:</span>
                <textarea name="descricao" rows="5"><?php if (isset($data)) echo $data['descricao']; ?></textarea>
            </label>
            <input type="submit" class="btn blue" value="Atualizar Modulo" name="SendPostForm" />
        </form>

    </article>

    <div class="clear"></div>
</div> 