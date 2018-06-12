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
                $desabilitar = new AdminUsuarios;
                $desabilitar->Habilitar($userId, $data);    
                if($desabilitar->getResult()){
                    header ('Location: ../admin/painel.php?exe=usuarios/desabilitados&habilitado=true&usuario=' . $userId);
                }     
        ?>
    <article>
</div> 