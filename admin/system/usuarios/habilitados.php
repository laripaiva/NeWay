<div class="content cat_list">
    <section>
        <h1>Desabilitar Alunos </h1>
        <?php
            require('_models\AdminUsuarios.class.php');
            $readData = new AdminUsuarios;
            $readData->readHabilitados();

            if ($readData->getResult()){
                $alunos = $readData->getResult();
                foreach ($alunos->getResult() as $ses){
                    extract($ses);
        ?>
                <section>
                    <header>
                        <p class="tagline"><b>Nome: </b><?=$nome;?></p>
                        <p class="tagline"><b>Sobrenome: </b><?=$nome_final;?></p>
                        <p class="tagline"><b>Email: </b><?=$email;?></p>
                        <p class="tagline"><b>Data de habilitação: </b><?=$data_habilitacao;?></p>
                        
                        <ul>
                            <li><a class="act_delete" href="painel.php?exe=usuarios/desabilitar&usuario=<?=$id;?>" title="Desabilitar aluno">Desabilitar aluno</a></li>
                        </ul>
                    </header>
                </section>
        <?php 
          }
        }else{
            frontErro("Não há usuários habilitados.", E_USER_NOTICE);
        }
        ?>
    </section>
</div> 