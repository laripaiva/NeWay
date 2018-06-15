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
        <p class="title center-align">Upload Arquivo</p>
    </div>
<div class="container">
    <?php
        $videoId = filter_input (INPUT_GET, 'file', FILTER_VALIDATE_INT);
        $update = filter_input (INPUT_GET, 'update',  FILTER_VALIDATE_BOOLEAN);

    ?>
    

        <?php
            require ('..\_app\Helpers\UploadFotos.class.php');  
            require ('..\_app\Helpers\Check.class.php');
            if ($videoId){
                $readVideo = new Read;
                $readVideo->exeRead("texts", "WHERE id = :id", "id={$videoId}");
                $readData = $readVideo->getResult()[0];
                if (!$update){
                    frontErro("Para continuar o cadastro, faça o upload da foto.", E_USER_NOTICE);
                }
            }

            if(isset($_POST['enviar'])){
                $file = $_FILES['arquivo'];
                if (!empty($file['name'])){
                    $validateName = new Check;
                    $file['name'] = $validateName->validateName($file['name']);
                    $dir = '..\uploads\arquivos';
                    $read = new UploadFotos;
                    $read->upload($file, $dir);
                    require('_models\AdminFotos.class.php');        
                    
                    $readData['diretorio'] = '..\uploads\arquivos/' . $file['name'];

                    var_dump($readData);

                    $cadastra = new AdminFotos;
                    $cadastra->ExeUpdateUploadFiles($readData);

                    
                    var_dump($cadastra->getResult());

                    if (!$cadastra->getResult()){
                        frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
                    }else{
                        header('Location: painel.php?exe=textos/index&update=true&upload=true&modulo=' . $readData['id_modules']);
                    }
                }elseif($update){
                    header('Location: painel.php?exe=textos/index&update=true&modulo=' . $readData['id_modules']);
                }
            }
        ?>
        <form name="uploadform" enctype="multipart/form-data" method="post" action="">
            <?php 
                if ($readData['diretorio']){
                
            ?>
                     <embed height="500px" src="<?php echo $readData['diretorio'];?>" width="100%"></embed>
            <?php
                }
            ?>
            <input type="file" name="arquivo" value="arquivo" accept="application/pdf, application/vnd.ms-excel" value=""/>
            <br><br>
            <label>
            <input name="enviar" class="waves-effect  red darken-4 btn" type="submit" value="Finalizar">
            </label>
        </form>

    </article>
</div> 