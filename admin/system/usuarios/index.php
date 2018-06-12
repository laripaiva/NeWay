<div class="content cat_list">
    <section>
        <h1>Gerenciar Alunos</h1><br><br>
        <?php
            $readData = new Read;
            $readData->exeRead("users", "WHERE level = :level", "level=2");

            $habilitados = $readData->getRowCount();

            $readData = new Read;
            $readData->exeRead("users", "WHERE level = :level", "level=1");

            $desabilitados = $readData->getRowCount();
        ?>
        <header>
            <h3>Alunos não habilitados: </h3><br> 
            <p class="tagline"><b>Quantidade: </b><?php echo $desabilitados; ?></p>
            <ul>
                <li><a class="act_delete" href="painel.php?exe=usuarios/desabilitados" title="Habilitar alunos">Habilitar alunos</a></li>                        
            </ul>
        </header>
        <br><br><br><br>
        <header>
            <h3>Alunos habilitados: </h3><br> 
            <p class="tagline"><b>Quantidade: </b><?php echo $habilitados; ?></p>
            <ul>
                <li><a class="act_delete" href="painel.php?exe=usuarios/habilitados" title="Desabilitar alunos">Desabilitar alunos</a></li>                        
            </ul>
        </header>
    </section>
</div> 