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
            <h1>Criar curso:</h1>
        </header>

        <?php
            $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
            if (!empty($data['SendPostForm'])){
                unset ($data['SendPostForm']);

                if ($data['categoria']=="null"){
                    frontErro("<b>Erro</b>, preencha o campo categoria.", E_USER_WARNING);
                }else{
                    $readCat = new Read;
                    $readCat->exeRead("categorys", "WHERE nome = :n", "n={$data['categoria']}");
                    $cat = $readCat->getResult()[0];
                    header('Location: painel.php?exe=cursos/create&categoria=' . $cat['id']);
                }

            }
        ?>
        <form name="CursoForm" action="" method="post" enctype="multipart/form-data">            
            <label class="label">
                <span class ="field"> Categoria </span>
                <select name="categoria">
                    <option value="null">Selecione a categoria: </option>
                    <?php
                        $readCat = new Read;
                        $readCat->exeRead("categorys", "WHERE id != :id", "id=0");

                        if (!$readCat->getResult()){
                            echo '<option desabled="desabled" value="null">Selecione a categoria: </option>';
                        }else{
                            foreach ($readCat->getResult() as $cat){
                                echo "<option value=\"{$cat['nome']}\"> {$cat['nome']} </option>";
                            }
                        }
                    ?>
                </select>
            </label>
            <input type="submit" class="btn green" value="Cadastrar Curso" name="SendPostForm" />
        </form>

    </article>
</div> 