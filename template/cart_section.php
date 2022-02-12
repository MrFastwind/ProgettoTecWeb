
<script src="js/cart.js"></script>
<section class="cart-section">
    <header>
        <h1 class="cartHeader">CARRELLO</h1>
    </header>
    <div>
        <p class="cart-paragraph">Non hai finito di fare acquisti? Torna al <a href="catalogo.php">catalogo</a></p>
        <?php if(isset($templateParams["cartSuccess"])): ?>
            <p class="cart-paragraph"><?php echo($templateParams["cartSuccess"]);?> <a href="notifiche.php">notifiche</a></p>
        <?php endif ?>
    </div>
    <?php if (!empty($items) && count($items)!=0): ?>
        <table class="cartTable">
            <?php foreach($items as $item):
                $product = $dbm->getFactory()->getProduct($item->ProductID);
                $img = retrieveImage($product->Image, IMG_DIR);
            ?>
                <tr id="<?php echo($product->ProductID);?>">
                    <td><img class="tableImg" src="<?php echo($img);?>" alt="<?php echo ($product->Name);?>"></td>
                    <td><p><?php echo($product->Name);?></p></td>
                    <td><p>Quantità:</p>
                        <select id="<?php echo($product->ProductID);?>" name="quantity">
                            <?php for($i=0; $i<=$product->Quantity; $i++): ?>
                            <option value="<?php echo($i);?>" <?php if($item->Quantity==$i){echo('selected="selected"');}?>><?php echo($i);?></option>
                            <?php endfor ?>
                        </select>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
        <footer>
            <ul class="list-unstyled">
                <li>
                    <label>Totale: </label>
                    <p id="price"><?php echo($price);?>.00€</p>
                </li>
                <li>
                    <a href="checkout.php" class="checkoutBtn">Checkout</a>
                </li>
            </ul>
        </footer>
    <?php else: ?>
            <div><p class="text-black cart-paragraph">Il tuo carrello è vuoto.</p></div>
    <?php endif ?>
</section>