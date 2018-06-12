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
            <h1>Atualizar curso:</h1>
        </header>

        <?php
            $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
            //Pega o id de curso da URL
            $courseId = filter_input (INPUT_GET, 'courseId', FILTER_VALIDATE_INT);

            if (!empty($data['SendPostForm'])){
                unset ($data['SendPostForm']);

                require('_models\AdminCursos.class.php');
                $cadastra = new AdminCursos;
                $cadastra->ExeUpdateCursos($courseId, $data);
                frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
            }else{
                $read = new Read;
                $read->exeRead("courses", "WHERE id = :id", "id={$courseId}");
                if (!$read->getResult()){
                    //Se for gerado update falso, quer dizer que tentamos atualizar algo que não existe
                    header ('Location: painel.php?exe=cursos/index&empty=true');
                }else{
                    $data = $read->getResult()[0];
                }
            }
            /**
             * Cadastrado -> Atualizar
             */
            $checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
            if ($checkCreate == 1){
                frontErro("O curso <b>{$data['titulo']}</b> foi cadastrado com sucesso. Continue atualizando.", ACCEPT);
            }
        ?>
        <form name="CursoForm" action="" method="post" enctype="multipart/form-data">
            <label class="label">
                <span class="field">Titulo:</span>
                <input type="text" name="titulo" value="<?php if (isset($data)) echo $data['titulo']; ?>" />
            </label>
            
            <!-- <label class="label">
                <span class ="field"> Categoria </span>
                <select name="categoria">
                    <option value="null">Selecione a categoria: </option>
                    <?php
                        // $readCat = new Read;
                        // $readCat->exeRead("categoria", "ORDER BY nome_categoria ASC");

                        // if (!$readCat->getResult()){
                        //     echo '<option desabled="desabled" value="null">Selecione a categoria: </option>';
                        // }else{
                        //     foreach ($readCat->getResult() as $cat){
                        //         echo "<option value=\"{$cat['id']}\"> {$cat['nome_categoria']} </option>";
                        //     }
                        // }

                    ?>
                </select>
            </label> -->
            <label class="label">
                <span class="field">Descrição:</span>
                <textarea name="descricao" rows="5"><?php if (isset($data)) echo $data['descricao']; ?></textarea>
            </label>
            <div class="gbform"></div>

            <input type="submit" class="btn blue" value="Atualizar Curso" name="SendPostForm" />
        </form>

    </article>

    <div class="clear"></div>
</div> 