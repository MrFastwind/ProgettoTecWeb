<section>
    <header>
        <h1>SCEGLI UN PRODOTTO DA MODIFICARE</h1>
    </header>
    <form action="#" method="POST">
        <input type="text" placeholder="Cerca il prodotto da modificare..."/>
    </form>
        <?php foreach($categories as $key=>$name): ?>
            <?php $products = $dbm->getFactory()->getProductsByCategory($key); ?>
                <h2><?php echo($name);?></h2>
                <?php foreach($products as $product): ?>
                    <ul class="list-unstyled">
                        <li>
                            <a href="modifica.php?vendorChoice=<?php echo($product->ProductID)?>"><?php echo($product->Name);?></a>
                        </li>
                    </ul>
                <?php endforeach ?>
        <?php endforeach ?>
    </div>
</section>