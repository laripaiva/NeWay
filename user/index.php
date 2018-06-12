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
    <h1> Cursos Inscritos </h1>
    <?php 
       $readWatch = new Read;
       $readWatch->exeRead("watch_courses", "WHERE id_user = :idu AND id_courses != :idc", "idu={$userlogin['id']}&idc=0");

        $nWatch = $readWatch->getRowCount();

        for ($i=0; $i< $nWatch ; $i++){
            $cursos[$i] = $readWatch->getResult()[$i]['id_courses'];
        }

        for ($i=0; $i< $nWatch ; $i++){
            $readCursos[$i] = new Read;
            $readCursos[$i]->exeRead("courses", "WHERE id = :id ", "id={$cursos[$i]}");
            if ($readCursos[$i]->getResult()){
                $id = $readCursos[$i]->getResult()[0]['id'];
                $nome = $readCursos[$i]->getResult()[0]['titulo'];
                $descricao= $readCursos[$i]->getResult()[0]['descricao'];
            ?>
    <section>
        <header>
            <h3>Curso: <?php echo $nome?></h3>
            <p class="tagline"><b>Descrição: </b><?php echo $descricao; ?></p>
            <ul>
                <li><a href="dashboard.php?exe=historico&matricula=<?php echo $readWatch->getResult()[$i]['id']?>&curso=<?php echo $id; ?>"> Visualizar Histórico</a></li>                        
            </ul>
        </header>
   </section>
    <?php   
            }
        }
    ?>
    
    <?php 
    // }
    ?>

</div>