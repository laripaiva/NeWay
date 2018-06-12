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
            $data = "";  
            $userId = filter_input (INPUT_GET, 'usuario', FILTER_VALIDATE_INT);
            $readUser = new Read;
            $readUser->exeRead("users", "WHERE id = :id", "id={$userId}");

            require('_models\AdminUsuarios.class.php');
                $habilitar = new AdminUsuarios;
                $habilitar->Desabilitar($userId, $data);
                if($habilitar->getResult()){
                    header ('Location: ../admin/painel.php?exe=usuarios/habilitados&desabilitado=true&usuario=' . $userId);
                }
        ?>
    <article>
</div>