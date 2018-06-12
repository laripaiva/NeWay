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
        $moduleId = filter_input (INPUT_GET, 'module', FILTER_VALIDATE_INT);
    ?>
    <article>

        <header>
            <h1>Criar vídeo:</h1>
        </header>
        <?php
            $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
            if (!empty($data['SendPostForm'])){
                unset ($data['SendPostForm']);

                require('_models\AdminVideos.class.php');              
                $cadastra = new AdminVideos;
                $cadastra->ExeCreateVideos($data, $moduleId);
                frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
                if ($cadastra->getResult()){
                    header ('Location: painel.php?exe=videos/upload&create=true&video=' . $cadastra->getResult() . '&module=' . $moduleId);     
                } 
            }
        ?>
        <form name="VideoForm" action="" method="post">
            <label class="label">
                <span class="field">Titulo:</span>
                <input type="text" name="titulo" value="<?php if (isset($data)) echo $data['titulo']; ?>" />
            </label>

            <label class="label">
                <span class="field">Descrição:</span>
                <textarea name="descricao" rows="5"><?php if (isset($data)) echo $data['descricao']; ?></textarea>
            </label>

            <input type="submit" class="btn green" value="Prosseguir cadastro" name="SendPostForm" />
        </form>

    </article>

    <div class="clear"></div>
</div> 