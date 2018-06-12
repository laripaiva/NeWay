<?php
/**
 * Caso aja tentativa de acessar essa página sem passar pelo painel, irá ser redirecionado para o painel
 * Método para previnir acessos inadequados ao sistema
 */
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;

$courseId = filter_input (INPUT_GET, 'curso', FILTER_VALIDATE_INT);
$readData = new Read;
$readData->exeRead("modules", "WHERE id_courses = :d", "d={$courseId}");
$nModulos = $readData->getRowCount();
?>

<div class="content form_create">

    <p>Número de Módulos: <?php echo $nModulos;?></p>
    <?php
        foreach ($readData->getResult() as $ses){
            extract($ses);
                
    ?>
        <section>
            <header>
                <h1><?=$titulo; ?></h1><br>
                <p class="tagline"><b>Descrição: </b><?=$descricao; ?></p>
                <ul>
                    <li><a href="dashboard.php?exe=matricula/visualizarVideos&modulo=<?=$id?>&aluno=<?php echo $userlogin['id'];?>">Visualizar Vídeos</a></li>
                </ul>
            </header>
        </section>
        <?php 
          }
        ?>
</div> 