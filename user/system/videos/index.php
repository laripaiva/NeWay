<?php
/**
 * Caso aja tentativa de acessar essa página sem passar pelo painel, irá ser redirecionado para o painel
 * Método para previnir acessos inadequados ao sistema
 */
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;

$moduleId = filter_input (INPUT_GET, 'modulo', FILTER_VALIDATE_INT);
$userId = filter_input (INPUT_GET, 'aluno', FILTER_VALIDATE_INT);

if ($moduleId && $userId){
    $readModule = new Read;
    $readModule->exeRead("modules", "WHERE id = :id", "id={$moduleId}");

    $curso = $readModule->getResult()[0];
    $curso['id_courses'] = (int) $curso['id_courses'];
    
    $readWatchCourses = new Read;
    $readWatchCourses->exeRead("watch_courses", "WHERE id_courses = :id AND id_user = :idu", "id={$curso['id_courses']}&idu={$userId}");

    if ($readWatchCourses->getResult()){
        $result = $readWatchCourses->getResult()[0];
        $data['id_module'] = $moduleId;
        $data['id_watch_courses'] = (int) $result['id'];

        $readData = new Read;
        $readData->exeRead ("historic", "WHERE id_module = :idm AND id_watch_courses = :idc", "idm={$data['id_module']}&idc={$data['id_watch_courses']}");
        if (!$readData->getResult()){
            $createModuleW = new Create;
            $createModuleW->ExeCreate('historic', $data);
        }
    }
}
?>

<div class="content form_create">

    <div class="neway z-depth-5">
       <p class="title center-align">Vídeos do Modulo <?php echo $curso['titulo'];?></p>
    </div>  
    <section id="" class="categoria container">
        <?php
            $readVideos = new Read;
            $readVideos->exeRead("videos", "WHERE id_modules = :d", "d={$moduleId}");
            foreach ($readVideos->getResult() as $ses){
                extract($ses);
                    
        ?>
            <section>
                <header>
                    <h1><?=$titulo; ?></h1><br>
                    <p class="tagline"><b>Descrição: </b><?=$descricao; ?></p>
                    <embed height="300" src="<?=$diretorio;?>" width="300"></embed>
                </header>
            </section>
            <?php 
            }
            if (!$readVideos->getResult()){
                frontErro("Não há vídeos/textos cadastrados nesse módulo.", E_USER_NOTICE);
            }
            ?>
    </section>
</div> 