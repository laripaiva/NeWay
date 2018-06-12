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
            <h1>Atualizar categoria:</h1>
        </header>

        <?php
            $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
            //Pega o id de curso da URL
            $catId = filter_input (INPUT_GET, 'categoria', FILTER_VALIDATE_INT);

            if (!empty($data['SendPostForm'])){
                unset ($data['SendPostForm']);

                require('_models\AdminCat.class.php');
                $update = new AdminCat;
                $update->ExeUpdateCat($catId, $data);
                frontErro($update->getError()[0], $update->getError()[1]);
                if ($update->getResult()){
                    header ('Location: painel.php?exe=categorias/index&update=true&categoria=' . $catId);
                }
            }else{
                $read = new Read;
                $read->exeRead("categorys", "WHERE id = :id", "id={$catId}");
                if (!$read->getResult()){
                    //Se for gerado update falso, quer dizer que tentamos atualizar algo que não existe
                    header ('Location: painel.php?exe=categorias/index&empty=true');
                }else{
                    $data = $read->getResult()[0];
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