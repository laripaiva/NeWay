<div class="container">
    <div class="row">
        <div class="col l12 s12">
					
        <?php
            
            // /************************************************************************************************
            //     * VERIFICAR SE ERROS E SUCESSOS
            //     ************************************************************************************************/
            $habilitado = filter_input(INPUT_GET, 'habilitado', FILTER_VALIDATE_BOOLEAN); 
            $user = filter_input (INPUT_GET, 'usuario', FILTER_VALIDATE_INT);
            
            if ($user){
                $readUser = new Read;
                $readUser->exeRead("users", "WHERE id = :id", "id={$user}");
                $dataUser = $readUser->getResult()[0];
            }
        ?>

        <?php
            if ($habilitado && $user){
                frontErro("O aluno(a) <b>{$dataUser['nome']} </b>foi habilitado com sucesso.", ACCEPT);
            }
        ?>
<style type="text/css">
        tr:hover {background-color:#e8eaf6;}
        table{margin-top: 20px;}
  </style>
        <?php
            require('_models\AdminUsuarios.class.php');
            $readData = new AdminUsuarios;
            $readData->readDesabilitados();

            if ($readData->getResult()){
                $alunos = $readData->getResult();
        ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Sobrenome</th>
                            <th>E-mail</th>
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
                        <td><a class="waves-effect red darken-4 btn" href="painel.php?exe=usuarios/habilitar&usuario=<?=$id;?>">Habilitar</a></td>
                    </tr>
        <?php 
                }
            }else{
                frontErro("Não há usuários desabilitados.", E_USER_NOTICE);
            }
        ?>
                    </tbody>
                </table>
		</div>
	</div>
</div> 