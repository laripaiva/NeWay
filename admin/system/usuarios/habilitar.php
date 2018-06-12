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
            $data = (strftime( '%d/%m/%Y', strtotime( date( 'd-m-Y' ))));  
            $userId = filter_input (INPUT_GET, 'usuario', FILTER_VALIDATE_INT);
            $readUser = new Read;
            $readUser->exeRead("users", "WHERE id = :id", "id={$userId}");

            require('_models\AdminUsuarios.class.php');
                $habilitar = new AdminUsuarios;
                $habilitar->Habilitar($userId, $data);
                frontErro($habilitar->getError()[0], $habilitar->getError()[1]);           
        ?>
         <a href="../admin/painel.php?exe=usuarios/index"><input type="button" value="Visualizar Usuários"></a>
    <article>
</div> 