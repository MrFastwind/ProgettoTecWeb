<section>
    <header>
        <h1 class="text-white">PRODOTTI IN EVIDENZA</h1>
    </header>
    <div class="carousel">
        <?php foreach($products as $product): ?>
            <div class="slides">
                <img src="<?php echo(retrieveImage($product->Image,IMG_DIR));?>" alt="<?php echo $product->Name;?>"/>
                <div class="carouselText"><?php echo($product->Name . " $product->Price" . " €");?></div>
            </div>
        <?php endforeach ?>
        <a class="prev" onclick="plusSlides(-1)"></a>
        <a href="next" onclick="plusSlides(1)"></a>
    </div>
    <div style="text-align: center;">
        <?php for($i=0; $i<count($products); $i++): ?>
            <span class="dot" onclick="currentslide(<?php echo($i+1);?>)"></span>
        <?php endfor ?>
    </div>
    <footer>
        <a class="homeButton" href="catalogo.php">Sfoglia le categorie</a>
    </footer>
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
