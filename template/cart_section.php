<section>
    <header>
        <h2 class="text-white">CARRELLO</h2>
    </header>
    <div>
        <?php if(isset($templateParams["cartSuccess"])): ?>
            <p><?php echo($templateParams["cartSuccess"]);?> <a href="notifiche.php" class="text-warning">notifiche</a></p>
        <?php endif ?>
    </div>
    <?php if (!empty($items) && count($items)!=0): ?>
        <table>
            <?php foreach($items as $item):
                $product = $dbm->getFactory()->getProduct($item->ProductID);
                //$img = $product->Image;
            ?>
                <tr>
                    <!--<td><img src="<?php echo($img);?>" alt="<?php echo ($product->Name);?>"></td>-->
                    <td><?php echo($product->Name);?></td>
                    <td><?php echo($item->Quantity);?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <footer>
            <div class="btnContainer">
                <a href="checkout.php" class="checkoutBtn">Checkout</a>
            </div>
        </footer>
    <?php else: ?>
            <div><p class="text-white">Il tuo carrello è vuoto.</p></div>
    <?php endif ?>
</section>