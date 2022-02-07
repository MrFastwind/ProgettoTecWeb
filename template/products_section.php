<section>
    <header>
        <h1 class="text-white">PRODOTTI</h1>
    </header>
    <?php if(isset($templateParams["cartSuccess"])): ?>
        <p class="text-white"><?php echo($templateParams["cartSuccess"]);?></p>
    <?php endif ?>
    <?php if(isset($products)): ?>
        <ul class="list-unstyled accordion" id="accordion">
        <?php foreach ($products as $product): ?>
            <li>
                <div class="accordion-item">
                    <h2 class="accordionHeader" id="<?php echo($product->Name);?>Label">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo($product->Name);?>" aria-expanded="false" aria-controls="<?php echo($product->Name);?>"><?php echo($product->Name);?></button>
                    </h2>
                    <div id="<?php echo($product->Name);?>" class="accordion-collapse collapse" aria-labelledby="<?php echo($product->Name);?>Label" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            <ul class="list-unstyled">
                                <li>
                                    <p><?php echo($product->Description);?></p>
                                </li>
                                <li>
                                    <p>Prezzo per singola unità: <?php echo($product->Price);?>.00€</p>
                                </li>
                            </ul>
                            <form action="addTocart.php" method="POST">
                                <ul class="list-unstyled addToCart">
                                    <li>
                                        <select name="quantity">
                                            <?php for($i=1; $i<=$product->Quantity; $i++): ?>
                                                <option value="<?php echo($i);?>"><?php echo($i);?></option>
                                            <?php endfor ?>
                                        </select>
                                    </li>
                                    <li>
                                        <input type="submit" name="add" value="Aggiungi al carrello" id="addToCart"/>
                                    </li>
                                    <li>
                                        <input type="hidden" name="product" value="<?php echo($product->ProductID);?>"/>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
        <?php endforeach ?>
    </ul>
    <?php else: ?>
        <p class="text-white"><?php echo "Prodotto non disponibile"?></p>
    <?php endif ?>
</section>