<section>
    <header>
        <h1 class="cartHeader">CARRELLO</h1>
    </header>
    <div>
        <?php if(isset($templateParams["cartSuccess"])): ?>
            <p><?php echo($templateParams["cartSuccess"]);?> <a href="notifiche.php" class="text-warning">notifiche</a></p>
        <?php endif ?>
    </div>
    <?php if (!empty($items) && count($items)!=0): ?>
        <table class="cartTable">
            <?php foreach($items as $item):
                $product = $dbm->getFactory()->getProduct($item->ProductID);
                $img = retrieveImage($product->Image, IMG_DIR);
            ?>
                <tr>
                    <td><img class="tableImg" src="<?php echo($img);?>" alt="<?php echo ($product->Name);?>"></td>
                    <td><p><?php echo($product->Name);?></p></td>
                    <td><p>Quantità: <?php echo($item->Quantity);?></p></td>
                </tr>
            <?php endforeach ?>
        </table>
        <footer>
            <ul class="list-unstyled">
                <li>
                    <p class="text-white">Totale: <?php echo($price);?>.00 €</p>
                </li>
                <li>
                    <a href="checkout.php" class="checkoutBtn">Checkout</a>
                </li>
            </ul>
        </footer>
    <?php else: ?>
            <div><p class="text-black">Il tuo carrello è vuoto.</p></div>
    <?php endif ?>
</section>