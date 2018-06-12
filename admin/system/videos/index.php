<div class="content cat_list">

    <?php
        $moduleId = filter_input (INPUT_GET, 'module', FILTER_VALIDATE_INT);
        $readModule = new Read;
        $readModule->exeRead("modules", "WHERE id = :id", "id={$moduleId}");
        $nome= $readModule->getResult()[0];

    ?>
    <section>
        <h1>Videos no módulo <?php echo $nome['titulo']; ?>:</h1>
        <li><a href="painel.php?exe=videos/create&module=<?php echo $moduleId;?>">Criar novo vídeo</a></li>
        <?php

            /************************************************************************************************
            * VERIFICAR SE HOUVE CADASTRAMENTO DE VIDEO
            ************************************************************************************************/
            $upload = filter_input(INPUT_GET, 'upload', FILTER_VALIDATE_BOOLEAN);
            $videoId = filter_input (INPUT_GET, 'video', FILTER_VALIDATE_INT);            
            if ($upload &&  $videoId){
                $readVideo = new Read;
                $readVideo->exeRead("videos", "WHERE id = :id", "id={$videoId}");
                $nomeVideo= $readVideo->getResult()[0];
                frontErro("O vídeo <b>{$nomeVideo['titulo']} </b>foi cadastrado com sucesso.", ACCEPT);
            }
            /***********************************************************************************************/
            $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
            if ($empty){
                frontErro("Você tentou editar um vídeo que não existe no sistema.", E_USER_NOTICE);
            }   
            $readData = new Read;
            $readData->exeRead("videos", "WHERE id != :d AND id_modules = :idm", "d=0&idm={$moduleId}");

            if (!$readData->getResult()){
                frontErro("Não há vídeos registrados nesse módulo.", E_USER_NOTICE);
            }

            foreach ($readData->getResult() as $ses){
                extract($ses); 
        ?>
            <section>
                <header>
                    <h1><?=$titulo; ?></h1><br> 
                    <p class="tagline"><b>Descrição: </b><?=$descricao; ?></p>
                    <embed height="300" src="<?=$diretorio; ?>" width="300"></embed>
                    <ul>
                    <li><a class="act_edit" href="painel.php?exe=videos/update&video=<?=$id?>&nameModule=<?=  $nome['titulo'];?>">Editar</a></li>
                        <li><a class="act_delete" href="painel.php?exe=cursos/delete&courseId=<?=$id?>" title="Excluir">Deletar</a></li>
                    </ul>
                </header>
            </section>
        <?php 
          }
        ?>
    </section>
</div> <!-- content home -->