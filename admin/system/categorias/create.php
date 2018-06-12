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

    <article>

        <header>
            <h1>Criar categoria:</h1>
        </header>

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
        <form name="CatForm" action="" method="post" enctype="multipart/form-data">
            <label class="label">
                <span class="field">Nome:</span>
                <input type="text" name="nome" value="<?php if (isset($data)) echo $data['nome']; ?>" />
            </label>
            <input type="submit" class="btn green" value="Cadastrar Categoria" name="SendPostForm" />
        </form>
    </article>
</div> 