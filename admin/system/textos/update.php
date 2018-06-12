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

<div>
<article class="content form_create">
        <?php
            $textoId = filter_input (INPUT_GET, 'texto', FILTER_VALIDATE_INT);
            $readText = new Read;
            $readText->exeRead("texts", "WHERE id = :id", "id={$textoId}");
            $dataText = $readText->getResult()[0];
            // var_dump($dataText);

            $data = filter_input_array (INPUT_POST, FILTER_DEFAULT);

            if (!empty($data['SendPostForm'])){
                unset ($data['SendPostForm']);
                require('_models\AdminTextos.class.php');
                // var_dump($data);
                $update = new AdminTextos;
                $update->ExeUpdateTexts($data, $textoId);
                
                // frontErro($update->getError()[0], $update->getError()[1]);

                // if ($update->getResult()[0]){
                //     // header ('Location: painel.php?exe=videos/upload&update=true&video=' . $videoId);
                //     var_dump($update->getResult()[0]);
                // }
            }
            // else{
            //     $read = new Read;
            //     $read->exeRead("videos", "WHERE id = :id", "id={$videoId}");
            //     if (!$read->getResult()){
            //         //Se for gerado update falso, quer dizer que tentamos atualizar algo que não existe
            //         header ('Location: painel.php?exe=cursos/index&empty=true');
            //     }else{
            //         $data = $read->getResult()[0];
            //     }
            // }
        ?>

        <article>
            <form name="TextoForm" action="" method="post">
                <label class="label">
                    <span class="field">Titulo:</span>
                    <input type="text" name="titulo" value="<?php if (isset($dataText)) echo $dataText['titulo']; ?>" />
                </label>

                <label class="label">
                    <span class="field">Descrição:</span>
                    <textarea name="descricao" rows="5"><?php if (isset($dataText)) echo $dataText['descricao']; ?></textarea>
                </label>

                <input type="submit" class="btn green" value="Prosseguir alteração" name="SendPostForm" />
            </form>
        </article>
        
        
    </article>
    <script src="JS/jquery-3.3.1.js" type="text/javascript" charset="utf-8" async defer></script>
	<script src="JS/materialize.js"></script>
	<script src="JS/usus.js"></script>
</div> 