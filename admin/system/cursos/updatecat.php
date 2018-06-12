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

            $courseId = filter_input (INPUT_GET, 'courseId');
            $readCourse = new Read;
            $readCourse->exeRead("courses", "WHERE id = :id", "id={$courseId}");
            $course = $readCourse->getResult()[0];
            $category = new Read;
            $category->exeRead("categorys", "WHERE id =:id", "id={$course['categoria']}");
            $category = $category->getResult()[0];

            $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);
            if (!empty($data['SendPostForm'])){
                unset ($data['SendPostForm']);

                if ($data['categoria']=="null"){
                    frontErro("<b>Erro</b>, preencha o campo categoria.", E_USER_WARNING);
                }else{
                    $readCat = new Read;
                    $readCat->exeRead("categorys", "WHERE nome = :n", "n={$data['categoria']}");
                    $cat = $readCat->getResult()[0];
                    header('Location: painel.php?exe=cursos/update&categoria=' . $cat['id'] . '&curso=' . $course['id']);
                }

            }
        ?>
        <form name="CursoForm" action="" method="post" enctype="multipart/form-data">            
            <label class="label">
                <span class ="field"> Categoria </span>
                <select name="categoria">
                    <?php
                        echo "<option value=\"{$category['nome']}\"> {$category['nome']} </option>";
                    
                        $readCat = new Read;
                        $readCat->exeRead("categorys", "WHERE id != :id", "id={$category['id']}");
                        if (!$readCat->getResult()){
                            echo "<option value=\"{$category['nome']}\"> {$category['nome']} </option>";
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