<div class="container">
    <?php
        $readData = new Read;
        $readData->exeRead("users", "WHERE level = :level", "level=2");

        $habilitados = $readData->getRowCount();

        $readData = new Read;
        $readData->exeRead("users", "WHERE level = :level", "level=1");

        $desabilitados = $readData->getRowCount();
    
        ?>
        
        <div class="row">
            <div class="col s12 l6">
                <div class="card">
                    <div class="card-image">
                        <img src="imagens/user.png">
                        <a class="btn-floating halfway-fab waves-effect waves-light red" href="painel.php?exe=usuarios/desabilitados"><i class="material-icons">chevron_right</i></a>
                    </div>
                    <div class="card-content">
                        <span class="card-title">Usuários Desabilitados</span>
                        <p>Quantidade:<p><span id=""><?php echo $desabilitados; ?></span><br>
                    </div>
                </div>
            </div>
            <div class="col s12 l6">
                <div class="card">
                    <div class="card-image">
                        <img src="imagens/user2.png">
                        <a class="btn-floating halfway-fab waves-effect waves-light red" href="painel.php?exe=usuarios/habilitados"><i class="material-icons">chevron_right</i></a>
                    </div>
                    <div class="card-content">
                        <span class="card-title">Usuários Habilitados</span>
                        <p>Quantidade:<p><span id=""><?php echo $habilitados; ?></span>
                    </div>
                </div>
            </div>
            </div>
        </div>        
    <script src="JS/jquery-3.3.1.js" type="text/javascript" charset="utf-8" async defer></script>
	<script src="JS/materialize.js"></script>
	<script src="JS/usus.js"></script>
</div> 
