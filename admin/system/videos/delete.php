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
            $video = filter_input (INPUT_GET, 'video', FILTER_VALIDATE_INT);
            $module = filter_input (INPUT_GET, 'module', FILTER_VALIDATE_INT);

            $readVideo = new Read;
            $readVideo->exeRead("videos", "WHERE id = :id AND id_modules = :idm", "id={$video}&idm={$module}");

            if ($readVideo->getResult()){
                $deleteVideo = new Delete;
                $deleteVideo->ExeDelete("videos","WHERE id = :id AND id_modules = :idm", "id={$video}&idm={$module}");
                header('Location: painel.php?exe=videos/index&delete=true');
            }

        ?>
    <article>
</div>