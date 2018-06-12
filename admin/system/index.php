
    <section id="slide-curso">
        <div class="neway z-depth-5">
            <p class="title center-align">O caminho para o sucesso na palma da sua mão!</p>
        </div>
        <div class="carousel">
            <a class="carousel-item" href="#one!"><img src="IMAGES/leitura.jpg"></a>
            <a class="carousel-item" href="#two!"><img src="IMAGES/prof.jpg"></a>
            <a class="carousel-item" href="#three!"><img src="IMAGES/profissionais.jpg"></a>
            <a class="carousel-item" href="#four!"><img src="IMAGES/stu.jpg"></a>
            <a class="carousel-item" href="#five!"><img src="IMAGES/studantes.jpg"></a>
        </div>
        <div class="neway b z-depth-5">
            <p class="title center-align">Nossos Cursos:</p>
        </div>
    </section>

     <section id="" class="categoria container">
    <?php
        $readCat = new Read;
        $readCat->exeRead("categorys", "WHERE id != :id", "id=0");
        $cat = $readCat->getResult();
        for ($i=0; $i < $readCat->getRowCount(); $i++){           
    ?>
       
            <div class="cat z-depth-5">
                <p class="title"><?php echo $cat[$i]['nome'];?></p>
            </div>

            <div class="cads">
                <?php   
                    $readCourse = new Read;
                    $readCourse->exeRead("courses", "WHERE categoria = :c", "c={$cat[$i]['id']}");
                
                    foreach ($readCourse->getResult() as $ses){
                        extract($ses);
                ?>
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="<?=$foto;?>">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4"><?=$titulo;?><i class="material-icons right">more_vert</i></span>
                        <p><a href="#">Matricular-me</a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">InDesign<i class="material-icons right">close</i></span>
                        <p>Here is some more information about this product that is only revealed once clicked on.</p>
                    </div>
                </div>
            </div>
                    
    <?php
                }
        }
    ?>
    </section>