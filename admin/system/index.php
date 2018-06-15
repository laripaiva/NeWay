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
   
    <div class="neway z-depth-5">
        <p class="title center-align">Gerenciar Cursos</p>
    </div>

    <section id="" class="categoria container">
    <?php
        $update = filter_input(INPUT_GET, 'update', FILTER_VALIDATE_BOOLEAN);
        $curso = filter_input(INPUT_GET, 'curso', FILTER_VALIDATE_INT);
        $create = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
        $empty= filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);

        if ($curso || $update || $create){
            $readCourse = new Read;
            $readCourse->exeRead("courses", "WHERE id = :id", "id={$curso}");
            $dataCourse = $readCourse->getResult()[0];
        }
        
    ?>
    <?php
        if($update && $curso){
            frontErro("O curso <b>{$dataCourse['titulo']}</b> foi atualizado.", ACCEPT);
        }elseif($create && $curso){
            frontErro("O curso <b>{$dataCourse['titulo']}</b> foi cadastrado.", ACCEPT);
        }elseif($empty){
            frontErro("<b>Erro</b>, a operação não pode ser realizada.", E_USER_WARNING);
        }
    ?>
    <?php
        $readCat = new Read;
        $readCat->exeRead("categorys", "WHERE id != :id", "id=0");
        $cat = $readCat->getResult();
        for ($i=0; $i < $readCat->getRowCount(); $i++){           
    ?>
        <div class="cat z-depth-5">
            <p class="title2"><?php echo $cat[$i]['nome'];?></p>
            <div class="mar"></div>
            <a href="painel.php?exe=cursos/create&categoria=<?php echo $cat[$i]['id'];?>" class="waves-effect light-blue darken-4 btn but2">cadastrar</a>
        </div>
        <div class="cads">
        <?php   
            $readCourse = new Read;
            $readCourse->exeRead("courses", "WHERE categoria = :c", "c={$cat[$i]['id']}");
        
            foreach ($readCourse->getResult() as $ses){
                extract($ses);
        ?>
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
						<img class="activator" src="<?=$foto;?>">
					</div>
					<div class="card-content">
						<span class="card-title activator grey-text text-darken-4"><?=$titulo;?><i class="material-icons right">more_vert</i></span>
						<p><a href="painel.php?exe=cursos/update&courseId=<?=$id?>&categoria=<?=$categoria;?>">Editar</a></p>
                        <p><a href="painel.php?exe=modulos/index&course=<?=$id?>">Gerenciar Módulos</a></p>
					</div>
                    <div class="card-reveal">
						<span class="card-title grey-text text-darken-4"><?=$titulo;?><i class="material-icons right">close</i></span>
						<p><?=$descricao;?></p>
					</div>
                </div>
               
            
        <?php
                }
        ?>
        </div> 
        <?php
        }
        ?>

    </section>
