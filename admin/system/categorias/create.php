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

<div class="container">

    <!-- Modal Cadastro -->
    <form name="CatForm" action="" method="post" enctype="multipart/form-data">
        <div class="modal-content">
            <h4 class="center-align">Cadastrar Categoria</h4>
    <?php
        $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
        if (!empty($data['SendPostForm'])){
            unset ($data['SendPostForm']);

            require('_models\AdminCat.class.php');
            $cadastra = new AdminCat;
            $cadastra->ExeCreateCat($data);
            if(!$cadastra->getResult()){
                frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
            }
            else{
                header ('Location: painel.php?exe=categorias/index&create=true&categoria=' . $cadastra->getResult());
            }
        }
    ?>
            <div class="row">
                <div class="input-field col s12">
                    <input id="first_name" type="text" class="validate" name="nome" value="<?php if (isset($data)) echo $data['nome']; ?>" >
                    <label for="first_name">Nome</label>
                </div>
            </div>
            <input type="submit" class="modal-close waves-effect waves-green btn modal-trigger" value="Cadastrar Categoria" name="SendPostForm" />
        </div>
    </form>
</div> 