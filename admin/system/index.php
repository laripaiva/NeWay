<div class="content cat_list">
    <h3>Categorias</h3><br>
    <?php  
        $readData = new Read;
        $readData->exeRead("categorys", "WHERE id != :d", "d=0");
        $quant= $readData->getRowCount();     
    ?>
    <section>
        <p>Número de categorias: <?php echo $quant;?><br>
        <a href="painel.php?exe=categorias/index"> Gerenciar categorias </a><br><br>
    </section>
    
    <h3>Cursos</h3><br>
    <?php  
        $readData = new Read;
        $readData->exeRead("courses", "WHERE id != :d", "d=0");
        $quant= $readData->getRowCount();     
    ?>
    <section>
        <p>Número de cursos: <?php echo $quant;?><br>
        <a href="painel.php?exe=cursos/index"> Gerenciar cursos </a><br><br>
    </section>

    <h3>Usuários</h3><br>
    <?php  
        $readData = new Read;
        $readData->exeRead("users", "WHERE level = :d", "d=2");
        $quant= $readData->getRowCount();     
        $readData2 = new Read;
        $readData2->exeRead("users", "WHERE level = :d", "d=1");
        $quant2= $readData2->getRowCount();     
    ?>
    <section>
        <p>Número de usuários pendentes: <?php echo $quant2;?><br>
        <p>Número de usuários matriculados: <?php echo $quant;?><br>
        <a href="painel.php?exe=usuarios/index"> Gerenciar usuários </a><br><br>
    </section>
</div> 