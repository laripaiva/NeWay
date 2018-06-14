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

<div class="neway z-depth-5">
        <p class="title center-align">Upload arquivo</p>
    </div>
<div class="container">
    <?php
        $courseId = filter_input (INPUT_GET, 'curso', FILTER_VALIDATE_INT);
        $update = filter_input (INPUT_GET, 'update',  FILTER_VALIDATE_BOOLEAN);

    ?>
    

        <?php
            require ('..\_app\Helpers\UploadFotos.class.php');  
            require ('..\_app\Helpers\Check.class.php');
            if ($courseId){
                $readCourse = new Read;
                $readCourse->exeRead("courses", "WHERE id = :id", "id={$courseId}");
                $readData = $readCourse->getResult()[0];
                if (!$update){
                    frontErro("Para continuar o cadastro, faça o upload da foto.", E_USER_NOTICE);
                }
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
                        header('Location: painel.php?exe=index&create=true&upload=true&curso=' . $courseId);
                    }
                }elseif($update){
                    header('Location: painel.php?exe=index&update=true&curso=' . $courseId);
                }
            }
        ?>
        <form name="uploadform" enctype="multipart/form-data" method="post" action="">
            <?php 
                if ($readData['foto']){

                
            ?>
                    <embed height="200" src="<?php echo $readData['foto'];?>" width="200"></embed><br><br>
            <?php
                }
            ?>
            <input type="file" name="arquivo" value="arquivo" accept="image/*" value=""/>
            <br><br>
            <label>
            <input name="enviar" class="btn waves-effect waves-light sub" type="submit" value="Finalizar">
            </label>
        </form>

    </article>
</div> 