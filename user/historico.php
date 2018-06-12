<?php
/**
 * Caso aja tentativa de acessar essa página sem passar pelo painel, irá ser redirecionado para o painel
 * Método para previnir acessos inadequados ao sistema
 */
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;

$matId = filter_input (INPUT_GET, 'matricula', FILTER_VALIDATE_INT);
$courseId = filter_input (INPUT_GET, 'curso', FILTER_VALIDATE_INT);
$readData = new Read;
$readData->exeRead("modules", "WHERE id_courses = :d", "d={$courseId}");
$_SESSION['id_curso'] = $courseId;

// echo $readData->getResult()[0]['id'];
// echo $readData->getResult()[1]['id'];
// var_dump ($readData->getResult());

$readProgress = new Read;
$readProgress->exeRead("historic", "WHERE id_watch_courses = :d", "d={$matId}");

?>

<div>

    <?php
        $certificado=0;
        foreach ($readData->getResult() as $ses){
            extract($ses);         
    ?>
        <section>
            <header>
                <h1><?=$titulo; ?></h1>
                <p class="tagline"><b>Descrição: </b><?=$descricao; ?></p>
                <?php 
                    
                    for ($i=0 ; $i < $readProgress->getRowCount(); $i++){
                        $historico = $readProgress->getResult()[$i];
                        if ($historico['id_module'] ==  $id){
                            $result = "Assistido";
                            $certificado++;
                            // $certificado= $certificado + 1;
                ?>
                <p class="tagline"><b>Status: </b><?php echo $result; ?></p>
                <?php 

                        }
                    }
                ?>
                <ul>
                    <li><a href="dashboard.php?exe=matricula/visualizarVideos&modulo=<?=$id?>&aluno=<?php echo $userlogin['id'];?>">Visualizar Vídeos</a></li>
                </ul>
            </header>
        </section>
        <?php 
          }
        ?>
        <?php      
            if ($readData->getRowCount() == $certificado){
                $dados = new Read;
                $dados->exeRead("users", "WHERE id = :id", "id={$userlogin['id']}");
                $curso = new Read;
                $curso->exeRead("courses", "WHERE id = :id", "id={$courseId}"); 
                $dados= $dados->getResult()[0];
                $curso =$curso->getResult()[0];
        ?>
        <a href="..\_app\Models\gerador.php?mat=<?php echo $dados['id'];?>&nome=<?php echo $dados['nome'] . ' ' . $dados['nome_final'] ;?>&curso=<?php echo $curso['titulo'];?>&ch=<?php echo $curso['carga_horaria'];?>">Curso concluído. Imprima o certificado.</a>
        <?php 
            }
        ?>

</div> 