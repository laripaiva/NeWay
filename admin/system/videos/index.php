<div class="content cat_list">
    
    <?php
        $moduleId = filter_input (INPUT_GET, 'modulo', FILTER_VALIDATE_INT);
        $readModule = new Read;
        $readModule->exeRead("modules", "WHERE id = :id", "id={$moduleId}");
        $nome= $readModule->getResult()[0];
    ?>
    <div class="neway z-depth-5">
        <p class="title center-align">Gerenciar Arquivos no módulo <?php echo $nome['titulo']; ?></p>
    </div>
    
        <?php
            $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
            if ($empty){
                frontErro("Você tentou editar um vídeo que não existe no sistema.", E_USER_NOTICE);
            }   
            $readData = new Read;
            $readData->exeRead("videos", "WHERE id != :d AND id_modules = :idm", "d=0&idm={$moduleId}");

            if (!$readData->getResult()){
                frontErro("Não há arquivos/textos registrados nesse módulo.", E_USER_NOTICE);
            }

            foreach ($readData->getResult() as $ses){
                extract($ses); 
        ?>
            <section>
                <header>
                <div class="container">
                    <h1 class="center-align"><?=$titulo; ?></h1><br> 
                    <p class="tagline"><b>Descrição: </b><?=$descricao; ?></p>
                    <embed height="500px" src="<?=$diretorio; ?>" width="100%"></embed>
                    
                    <a class="waves-effect  red darken-4 btn" href="painel.php?exe=textos/update&texto=<?=$id?>&nameModule=<?=  $nome['titulo'];?>"><i class="material-icons left">edit</i>Editar</a>
                    <a class="waves-effect  red darken-4 btn" href="painel.php?exe=cursos/delete&courseId=<?=$id?>" title="Excluir"><i class="material-icons left">delete_forever</i>Deletar</a>
                   
                    </div>
                </header>
            </section>
        <?php 
          }
        ?>
</div> 