<div class="content cat_list">
    <section>
        <h1>Habilitar Alunos </h1>
        <?php
            require('_models\AdminUsuarios.class.php');
            $readData = new AdminUsuarios;
            $readData->readDesabilitados();

            if ($readData->getResult()){
                $alunos = $readData->getResult();
                foreach ($alunos->getResult() as $ses){
                    extract($ses);
        ?>
         
                <section>
                    <?php
                    ?>
                    <header>
                        <p class="tagline"><b>Identificador: </b><?=$id;?></p>
                        <p class="tagline"><b>Nome: </b><?=$nome;?></p>
                        <p class="tagline"><b>Sobrenome: </b><?=$nome_final;?></p>
                        <p class="tagline"><b>Email: </b><?=$email;?></p>
                        <ul>
                            <li><a class="act_delete" href="painel.php?exe=usuarios/habilitar&usuario=<?=$id;?>" title="Habilitar aluno">Habilitar aluno(a)</a></li>                        
                        </ul>
                        
                    </header>
                    
                </section>
        <?php 
          }
        }else{
            frontErro("Não há usuários pendentes.", E_USER_NOTICE);
        }
        ?>
    </section>
</div> 