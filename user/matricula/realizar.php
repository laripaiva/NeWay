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
    <?php
        $courseId = filter_input (INPUT_GET, 'curso', FILTER_VALIDATE_INT);
        $userId = filter_input (INPUT_GET, 'aluno', FILTER_VALIDATE_INT);
        $readData = new Read;
        $readData->exeRead("courses", "WHERE id = :id", "id={$courseId}");
        foreach ($readData->getResult() as $ses){
            extract($ses);
    ?>

     <section>
        <header>
            <h1><?=$titulo; ?></h1><br>
            <p class="tagline"><b>Categoria:</b><?=$categoria?></p> 
            <p class="tagline"><b>Número de módulos:</b></p> 
            <p class="tagline"><b>Descrição: </b><?=$descricao; ?></p>
            <ul>
                <li><a class="act_view" href="dashboard.php?exe=matricula/matriculado&curso=<?php echo  $courseId ?>&aluno=<?php echo $userId ?>"> Confirmar Matrícula</a></li>
            </ul>
        </header>
        
        
        <?php 
        }
        ?>
    </section>
</div> 