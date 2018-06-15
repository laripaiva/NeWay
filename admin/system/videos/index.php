<div class="content cat_list">
    
    <?php
        $moduleId = filter_input (INPUT_GET, 'modulo', FILTER_VALIDATE_INT);
        $readModule = new Read;
        $readModule->exeRead("modules", "WHERE id = :id", "id={$moduleId}");
        if (!$readModule->getResult()){
            header ('Location: painel.php?exe=index&empty=true');
        }
        $nome= $readModule->getResult()[0];
    ?>
    <div class="neway z-depth-5">
        <p class="title center-align">Gerenciar vídeos no módulo <?php echo $nome['titulo']; ?><a href="painel.php?exe=videos/create&module=<?php echo $moduleId; ?>" class="waves-effect waves-light btn ">Adicionar video</a></p>
    </div>
    
        <?php
            $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
            $update = filter_input(INPUT_GET, 'update', FILTER_VALIDATE_BOOLEAN);
            $delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_BOOLEAN);
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
                    
                    <a class="waves-effect  red darken-4 btn" href="painel.php?exe=videos/update&video=<?=$id?>&module=<?=$nome['id'];?>"><i class="material-icons left">edit</i>Editar</a>
                    <a class="waves-effect  red darken-4 btn" href="painel.php?exe=videos/delete&video=<?=$id?>&module=<?=$nome['id'];?>" title="Excluir"><i class="material-icons left">delete_forever</i>Deletar</a>
                   
                    </div>
                </header>
            </section>
        <?php 
          }
        ?>
</div> 