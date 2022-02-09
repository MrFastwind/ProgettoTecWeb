<section>
    <header>
        <h1 class="text-white">PRODOTTI IN EVIDENZA</h1>
    </header>
    <div class="carousel">
        <button class="carousel-btn carousel-btn-left is-hidden">
            <img src="<?php echo(retrieveImage("left.svg", IMG_DIR));?>" alt="left"/>
        </button>
        <div class="carousel-track-container">
            <div class="carousel-track">
                <?php foreach($products as $product): ?>
                    <div class="carousel-slide current-slide" style="background-image: linear-gradient(rgba(220,220,220,.6), rgba(220,220,220,.6)), url('<?php echo(retrieveImage($product->Image,IMG_DIR));?>');">
                        <p class="text-white"><?php echo($product->Name); ?></p>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <button class="carousel-btn carousel-btn-right">
            <img src="<?php echo(retrieveImage("right-arrow.svg", IMG_DIR));?>" alt="right"/>
        </button>
        <div class="carousel-nav">
        <button class="carousel-indicator current-slide"></button>
            <?php for($i=1; $i<count($products); $i++): ?>
                <button class="carousel-indicator"></button>
            <?php endfor ?>
        </div>
    </div>
    <div class="homeBtnContainer">
        <a class="homeButton" href="catalogo.php">Sfoglia le categorie</a>
    </div>
    <script src="js/carousel.js"></script>
</section>
<form action="search.php" method="GET">
    <input type="text" name="search" id="search" placeholder="Cerca un prodotto..."/>
    <button type="submit" class="searchbtn">
        <img src="/img/search.png" alt="Search">
    </button>
    <footer>
        <p class="text-white">Hai un prodotto che ti interessa e non è disponibile? <a class="text-warning" href="#">Scrivici</a></p>
    </footer>
</form>