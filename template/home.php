<section>
    <header>
        <h1>PRODOTTI IN EVIDENZA</h1>
    </header>
    <div class="carousel">
        <div class="carousel-track-container">
            <div class="carousel-track">
                <?php foreach($products as $product): ?>
                    <div class="carousel-slide current-slide" style="background-image: linear-gradient(rgba(55,55,55,.6), rgba(55,55,55,.6)), url('<?php echo(retrieveImage($product->Image,IMG_DIR));?>');">
                        <ul class="carousel-text list-unstyled">
                            <li>
                                <h2 class="text-white"><?php echo($product->Name); ?></h2>
                            </li>
                            <li>
                                <h2 class="text-warning"><?php echo($product->Price); ?>.00€</h2>
                            </li>
                        </ul>
                        <div class="carousel-overlay">
                            <ul class="list-unstyled">
                                <li>
                                    <p class="text-white"><?php echo($product->Description);?></p>
                                </li>
                                <li>
                                    <p class="text-white">Prezzo per singola unità: <?php echo($product->Price);?>.00€</p>
                                </li>
                            </ul>
                            <form action="addTocart.php" method="POST">
                                <ul class="list-unstyled addToCart">
                                    <li>
                                        <label class="text-white" for="quantity">Quantità: </label>
                                        <select name="quantity">
                                            <?php for($i=1; $i<=$product->Quantity; $i++): ?>
                                                <option value="<?php echo($i);?>"><?php echo($i);?></option>
                                            <?php endfor ?>
                                        </select>
                                    </li>
                                    <li>
                                        <input class="cart-btn"type="submit" name="add" value="&#128722;"/>
                                    </li>
                                    <li>
                                        <input type="hidden" name="product" value="<?php echo($product->ProductID);?>"/>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <button class="carousel-btn carousel-btn-left is-hidden">
            <
        </button>
        <button class="carousel-btn carousel-btn-right">
            >
        </button>
        <div class="carousel-nav">
        <button alt="carousel product selector" class="carousel-indicator current-slide">opzione 1</button>
            <?php for($i=1; $i<count($products); $i++): ?>
                <button alt="carousel product selector" class="carousel-indicator">opzione <?php echo($i+1); ?></button>
            <?php endfor ?>
        </div>
    </div>
    <div class="homeBtnContainer">
        <a class="homeButton" href="catalogo.php">Sfoglia le categorie</a>
    </div>
    <script src="js/carousel.js"></script>
</section>
<form action="search.php" method="GET" class="home-form">
    <label hidden for="search">Cerca</label>
    <input type="text" name="search" id="search" placeholder="Cerca un prodotto..."/>
    <label hidden for="searchbtn">Invia</label>
    <button type="submit" class="searchbtn" name="searchbtn">
        <img src="/img/search.png" alt="Search">
    </button>
    <footer>
        <p class="text-black">Hai un prodotto che ti interessa e non è disponibile? <a href="https://gmail.com">Scrivici</a></p>
    </footer>
</form>