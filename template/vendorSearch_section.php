<section>
    <header>
        <h1>SCEGLI UN PRODOTTO</h1>
    </header>
    <form action="#" method="POST">
        <input class="vendor-search" id="vendor-search" type="text" placeholder="Cerca il prodotto..."/>
    </form>
    <div class="vendor-search-container">
        <?php foreach($categories as $key=>$name): ?>
            <?php $products = $dbm->getFactory()->getProductsByCategory($key); ?>
                <h2><?php echo($name);?></h2>
                <?php foreach($products as $product): ?>
                    <ul class="list-unstyled products">
                        <li class="vendor-search-product-container"style="background-image: linear-gradient(rgba(0,0,0,.4), rgba(0,0,0,.4)), url('<?php echo(retrieveImage($product->Image,IMG_DIR));?>');">
                            <a class="vendor-search-product" href="modifica.php?vendorChoice=<?php echo($product->ProductID)?>"><?php echo($product->Name);?></a>
                        </li>
                    </ul>
                <?php endforeach ?>
        <?php endforeach ?>
    </div>
    <script src="js/vendorSearch.js"></script>
</section>