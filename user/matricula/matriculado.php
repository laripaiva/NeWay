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
        $data['id_courses']  = filter_input (INPUT_GET, 'curso', FILTER_VALIDATE_INT);
        $data['id_user']  = filter_input (INPUT_GET, 'aluno', FILTER_VALIDATE_INT);

        $readRegister = new Read;
        $readRegister->exeRead("watch_courses", "WHERE id_user = :idu AND id_courses = :idc", "idu={$data['id_user']}&idc={$data['id_courses']}");

        if ($readRegister->getResult()){
            echo "you can't do register anymore";
            die;
        }?>
        
        <p> oi </p>
        
        <?php
            if (!$readRegister->getResult()){
                $register = new Create;
                $register->ExeCreate('watch_courses', $data);


            if ($register->getResult()){
                echo "oi linda";
            }else{
                echo "não deu certo";
            }
        }
    ?>

</div>