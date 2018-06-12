<div class="content cat_list">

    <section>

        <h1>Categorias:</h1>

        <?php
            /************************************************************************************************
            * VERIFICAR SE ERROS E SUCESSOS NO CADASTRAMENTO  E ATUALIZAÇÃO DE CATEGORIA
            ************************************************************************************************/
            $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
            $create = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
            $update = filter_input(INPUT_GET, 'update', FILTER_VALIDATE_BOOLEAN);
            $catId = filter_input (INPUT_GET, 'categoria', FILTER_VALIDATE_INT);            
            if ($create &&  $catId){
                $readCat = new Read;
                $readCat->exeRead("categorys", "WHERE id = :id", "id={$catId}");
                $nomeCat= $readCat->getResult()[0];
                frontErro("A categoria <b>{$nomeCat['nome']} </b>foi cadastrada com sucesso.", ACCEPT);
            }elseif ($update &&  $catId){
                $readCat = new Read;
                $readCat->exeRead("categorys", "WHERE id = :id", "id={$catId}");
                $nomeCat= $readCat->getResult()[0];
                frontErro("A categoria <b>{$nomeCat['nome']} </b>foi atualizada com sucesso.", ACCEPT);
            }elseif($empty){
                frontErro("<b> Erro </b>, você tentou atualizar uma categoria que não existe.", E_USER_WARNING);
            }
        ?>

        <li><a href="painel.php?exe=categorias/create">Criar categoria</a></li>
        <?php  
            $readData = new Read;
            $readData->exeRead("categorys", "WHERE id != :d", "d=0");

            foreach ($readData->getResult() as $ses){
                extract($ses);
            
        ?>
            <section>
                <header>
                    <h3>Nome: <?=$nome; ?></h3>
                    <p class="tagline"><b>identificador:</b><?=$id?></p> 
                    <ul>
                        <li><a class="act_edit" href="painel.php?exe=categorias/update&categoria=<?=$id?>" title="Editar">Editar</a></li>
                    </ul>
                </header>
            </section>
        <?php 
          }
        ?>
    </section>
</div>