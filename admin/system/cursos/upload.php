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
        $courseId = filter_input (INPUT_GET, 'curso', FILTER_VALIDATE_INT);
    ?>
    <article>

        <header>
            <h3>Upload Imagem</h3>
        </header>
        <?php
            require ('..\_app\Helpers\UploadFotos.class.php');  
            require ('..\_app\Helpers\Check.class.php');
            if ($courseId){
                frontErro("Para continuar o cadastro, faça o upload da foto.", E_USER_NOTICE);
            }
            if(isset($_POST['enviar'])){
                $file = $_FILES['arquivo'];
                if (!empty($file['name'])){
                    $validateName = new Check;
                    $file['name'] = $validateName->validateName($file['name']);
                    $dir = '..\uploads\imagens';
                    $read = new UploadFotos;
                    $read->upload($file, $dir);
                    require('_models\AdminFotos.class.php');              
                    $cadastra = new AdminFotos;
                    $cadastra->ExeUploadImg($courseId, $read->getDir());

                    if (!$cadastra->getResult()){
                        frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
                    }else{
                        header('Location: painel.php?exe=cursos/index&create=true&upload=true&curso=' . $cadastra->getResult());
                    }
                }    
            }
        ?>
        <form name="uploadform" enctype="multipart/form-data" method="post" action="">
            <input type="file" name="arquivo" value="arquivo" accept="image/*" />
            <label>
            <input name="enviar" type="submit" value="Finalizar">
            </label>
        </form>

    </article>
</div> 