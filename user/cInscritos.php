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
        <p class="title center-align">Cursos Inscritos</p>
    </div>

<section id="" class="categoria container">

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
                $categoria= $readCursos[$i]->getResult()[0]['categoria'];
                
                $readCat= new Read;
                $readCat->exeRead("categorys", "WHERE id = :id ", "id={$categoria}");
                $readCat = $readCat->getResult()[0];

                $foto= $readCursos[$i]->getResult()[0]['foto'];
            ?>
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
						<img class="activator" src="<?php echo $foto;?>">
					</div>
					<div class="card-content">
						<span class="card-title activator grey-text text-darken-4"><?php echo $nome;?></span>
                        <p><b>Categoria:</b><?php echo $readCat['nome'];?></p>
                        <p><b>Descrição:</b><?php echo $descricao;?></p>
						<p><a href="painel.php?exe=historico.php">Visualizar vídeos</a></p>
					</div>
                </div>
    <?php   
            }
        }
    ?>
    
    <?php 
    // }
    ?>

</div>