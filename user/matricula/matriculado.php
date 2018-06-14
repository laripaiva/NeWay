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
<div>
    <?php
        $data['id_courses']  = filter_input (INPUT_GET, 'course', FILTER_VALIDATE_INT);

        $readCourse = new Read;
        $readCourse->exeRead("courses", "WHERE id = :id", "id={$data['id_courses']}");
        $readCourse = $readCourse->getResult()[0];

        $data['id_user']  = filter_input (INPUT_GET, 'aluno', FILTER_VALIDATE_INT);

        $readRegister = new Read;
        $readRegister->exeRead("watch_courses", "WHERE id_user = :idu AND id_courses = :idc", "idu={$data['id_user']}&idc={$data['id_courses']}");

        if ($readRegister->getResult()){
            header('Location: dashboard.php?exe=index&empty=true&mat=false&course=' . $readCourse['titulo']);
        }?>
        
        <?php
            if (!$readRegister->getResult()){
                $register = new Create;
                $register->ExeCreate('watch_courses', $data);


            if ($register->getResult()){
                header('Location: dashboard.php?exe=index&mat=true&course=' . $readCourse['titulo']);
            }
        }
    ?>

</div>