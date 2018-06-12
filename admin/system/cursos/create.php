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
            $cat = filter_input (INPUT_GET, 'categoria');
            $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
            if (!empty($data['SendPostForm'])){
                unset ($data['SendPostForm']);      

                $data['categoria'] = (int) $cat;
                require('_models\AdminCursos.class.php');
                $cadastra = new AdminCursos;
                $cadastra->ExeCreateCursos($data);

                if($cadastra->getResult()){
                    header ('Location: painel.php?exe=cursos/upload&create=true&curso=' . $cadastra->getResult());
                }else{
                    frontErro($cadastra->getError()[0], $cadastra->getError()[1]);
                }
            }
        ?>
        <form name="CursoForm" action="" method="post" enctype="multipart/form-data">
            <label class="label">
                <span class="field">Titulo:</span>
                <input type="text" name="titulo" value="<?php if (isset($data)) echo $data['titulo']; ?>" />
            </label>
        
            <label class="label">
                <span class="field">Carga Horária (horas/minutos):</span>
                <input type=time name="carga_horaria" value="<?php if (isset($data)) echo $data['carga_horaria']; ?>"/>
            </label>

            <label class="label">
                <span class="field">Descrição:</span>
                <textarea name="descricao" rows="5"><?php if (isset($data)) echo $data['descricao']; ?></textarea>
            </label>

            <input type="submit" class="btn green" value="Cadastrar Curso" name="SendPostForm" />
        </form>

    </article>
</div> 