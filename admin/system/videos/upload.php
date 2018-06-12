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
        $videoId = filter_input (INPUT_GET, 'video', FILTER_VALIDATE_INT);
    ?>
    <article>

        <header>
            <h1>Upload Vídeo</h1>
        </header>
        <?php
            require ('..\_app\Helpers\UploadFotos.class.php');
            require ('..\_app\Helpers\Check.class.php');
            if(isset($_POST['enviar'])){
                $file = $_FILES['arquivo'];
                if (!empty($file['name']){
                    $validateName = new Check;
                    $file['name'] = $validateName->validateName($file['name']);
                    $dir = '..\uploads\videos';
                    $read = new UploadFotos;
                    $read->upload($file, $dir);
                    require('_models\AdminVideos.class.php');              
                    $cadastra = new AdminVideos;
                    $cadastra->ExeUploadVideos($videoId, $read->getDir());

                    if (!$cadastra->getResult()){
                        frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
                    }else{
                        frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
                    }
                }else{
                    frontErro("Não há arquivo para upload.", E_USER_WARNING);
                 }         
            }
        ?>
        <form name="uploadform" enctype="multipart/form-data" method="post" action="">
            <input type="file" name="arquivo" value="arquivo" />
            <label>
            <input name="enviar" type="submit" value="Finalizar">
            </label>
        </form>

    </article>
</div> 