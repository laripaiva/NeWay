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

    <article>
        <?php
            $videoId = filter_input (INPUT_GET, 'video', FILTER_VALIDATE_INT);
            $readVideo = new Read;
            $readVideo->exeRead("videos", "WHERE id = :id", "id={$videoId}");
            $data= $readVideo->getResult()[0];

            $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);

            if (!empty($data['SendPostForm'])){
                unset ($data['SendPostForm']);
                require('_models\AdminVideos.class.php');
                $cadastra = new AdminVideos;
                $cadastra->ExeUpdateVideos($data, $videoId);
                frontErro($cadastra->getError()[0], $cadastra->getError()[1]);

                if ($cadastra->getResult()){
                    header ('Location: painel.php?exe=videos/upload&update=true&video=' . $videoId);
                }
            }else{
                $read = new Read;
                $read->exeRead("videos", "WHERE id = :id", "id={$videoId}");
                if (!$read->getResult()){
                    //Se for gerado update falso, quer dizer que tentamos atualizar algo que não existe
                    header ('Location: painel.php?exe=cursos/index&empty=true');
                }else{
                    $data = $read->getResult()[0];
                }
            }
        ?>
        <header>
            <h1>Atualizar Vídeo:</h1>
        </header>
        <form name="VideoForm" action="" method="post" enctype="multipart/form-data">
            <label class="label">   
                <span class="field">Titulo:</span>
                <input type="text" name="titulo" value="<?php if (isset($data)) echo $data['titulo']; ?>" />
            </label>
           
            <label class="label">
                <span class="field">Descrição:</span>
                <textarea name="descricao" rows="5"><?php if (isset($data)) echo $data['descricao']; ?></textarea>
            </label>
            <input type="submit" class="btn blue" value="Atualizar Video" name="SendPostForm"/>
        </form>

    </article>

    <div class="clear"></div>
</div> 