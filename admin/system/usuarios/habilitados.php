<div class="container">
    <div class="row">
        <div class="col l12 s12">
					
        <?php
            
            // /************************************************************************************************
            //     * VERIFICAR SE ERROS E SUCESSOS
            //     ************************************************************************************************/
            $desabilitado = filter_input(INPUT_GET, 'desabilitado', FILTER_VALIDATE_BOOLEAN); 
            $user = filter_input (INPUT_GET, 'usuario', FILTER_VALIDATE_INT);
            
            if ($user){
                $readUser = new Read;
                $readUser->exeRead("users", "WHERE id = :id", "id={$user}");
                $dataUser = $readUser->getResult()[0];
            }
        ?>

        <?php
            if ($desabilitado && $user){
                frontErro("O aluno(a) <b>{$dataUser['nome']} </b>foi desabilitado com sucesso.", ACCEPT);
            }
        ?>

        <?php
            require('_models\AdminUsuarios.class.php');
            $readData = new AdminUsuarios;
            $readData->readHabilitados();

            if ($readData->getResult()){
                $alunos = $readData->getResult();
        ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Sobrenome</th>
                            <th>E-mail</th>
                            <th>Data de habilitação</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
        <?php
                foreach ($alunos->getResult() as $ses){
                    extract($ses);
        ?>
                
                    <tr id="<?=$id;?>">
                        <td><?=$nome;?></td>
                        <td><?=$nome_final;?></td>
                        <td><?=$email;?></td>
                        <td><?=$data_habilitacao;?></td>
                        <td><a class="waves-effect waves-light btn" href="painel.php?exe=usuarios/desabilitar&usuario=<?=$id;?>">Desabilitar</a></td>
                    </tr>
        <?php 
                }
            }else{
                frontErro("Não há usuários habilitados.", E_USER_NOTICE);
            }
        ?>
                    </tbody>
                </table>
		</div>
	</div>
</div> 