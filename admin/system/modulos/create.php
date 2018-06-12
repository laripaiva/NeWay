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
            $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
            //Pega o id e nome do curso da URL
           
            $courseId = filter_input (INPUT_GET, 'courseId', FILTER_VALIDATE_INT);
            $readCourse = new Read;
            $readCourse->exeRead("courses", "WHERE id = :id", "id={$courseId}");
            $nomeCourse = filter_input (INPUT_GET, 'nomeCourse');            
        ?>
    <article>

        <header>
            <h1>Criar Módulo no curso <?php echo $nomeCourse;?>:</h1>
        </header>
        <?php
            $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
            if (!empty($data['SendPostForm'])){
                unset ($data['SendPostForm']);

                require('_models\AdminModulos.class.php');
                $cadastra = new AdminModulos;
                $cadastra->ExeCreateModulos($data, $courseId);

                
                frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
                if ($cadastra->getResult()){
                    header ('Location: painel.php?exe=modulos/update&create=true&moduleId=' . $cadastra->getResult() . '&nameCourse=' . $nomeCourse . '&nameModule=' . $data['titulo'] . '&idCourse=' . $courseId);      
                } 
            }
        ?>
        <form name="ModuloForm" action="" method="post" enctype="multipart/form-data">
            <label class="label">
                <span class="field">Titulo:</span>
                <input type="text" name="titulo" value="<?php if (isset($data)) echo $data['titulo']; ?>" />
            </label>
            
            <label class="label">
                <span class="field">Descrição:</span>
                <textarea name="descricao" rows="5"><?php if (isset($data)) echo $data['descricao']; ?></textarea>
            </label>
            <div class="gbform"></div>

            <input type="submit" class="btn green" value="Cadastrar Curso" name="SendPostForm" />
        </form>

    </article>

    <div class="clear"></div>
</div> 