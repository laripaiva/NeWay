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


        $readData = new Read;
        $readData->exeRead("courses", "WHERE id != :d", "d=0");

        foreach ($readData->getResult() as $ses){
            extract($ses);
                
    ?>
        <section>
            <header>
                <h1><?=$titulo; ?></h1><br>
                <!-- <p class="tagline"><b>Categoria:</b><?=$categoria?></p>  -->
                <p class="tagline"><b>Número de módulos:</b></p> 
                <p class="tagline"><b>Descrição: </b><?=$descricao; ?></p>
                <ul>
                <li><a href="dashboard.php?exe=matricula/visualizarModulos&curso=<?=$id?>&aluno=<?php echo $userlogin['id'];?>">Visualizar Módulos</a></li>
                    <li><a href="dashboard.php?exe=matricula/realizar&curso=<?=$id?>&aluno=<?php echo $userlogin['id'];?>">Realizar Matrícula</a></li>
                </ul>
            </header>
        </section>
        <?php 
          }
        ?>
</div> 