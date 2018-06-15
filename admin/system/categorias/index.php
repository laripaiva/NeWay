<div class="neway z-depth-5">
  <p class="title center-align">Gerenciar categorias</p>
</div>
<div class="container">

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
        <style type="text/css">
        tr:hover {
          background-color:#e8eaf6;
      }
  </style>
  <div class="row">
    <div class="col l12">
        <table class="centered">
            <thead>
                <tr>
                    <th>Identificador </th>
                    <th>Categoria</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                $readData = new Read;
                $readData->exeRead("categorys", "WHERE id != :d", "d=0");

                foreach ($readData->getResult() as $ses){
                    extract($ses);

                    ?>
                    <tr id="">
                        <td> <?=$id;?></td>
                        <td> <?=$nome;?></td>
                        <td><a class="waves-effect red darken-4 btn" href="painel.php?exe=categorias/update&categoria=<?=$id?>">Editar</a></td>
                    </tr>

                    <?php 
                }
                ?>
            </tbody>
        </table>

    </div>
</div>
<div class="center-align">
    <a href="painel.php?exe=categorias/create" class="waves-effect light-blue darken-4 btn modal-trigger"><i class="material-icons right">add_to_queue</i>Criar Categoria</a>    
</div>

</div>

</div>