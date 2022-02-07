<section>
    <header>
        <h1 class="text-white">PRODOTTI</h1>
    </header>
    <?php if(isset($products)): ?>
        <ul class="list-unstyled accordion" id="accordion">
        <?php foreach ($products as $product): ?>
            <li>
                <div class="accordion-item">
                    <h2 class="accordionHeader" id="<?php echo($product->Name);?>Label">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo($product->Name);?>" aria-expanded="true" aria-controls="<?php echo($product->Name);?>"><?php echo($product->Name);?></button>
                    </h2>
                    <div id="<?php echo($product->Name);?>" class="accordion-collapse collapse show" aria-labelledby="<?php echo($product->Name);?>Label" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            <ul class="list-unstyled">
                                <li>
                                    <p><?php echo($product->Description);?></p>
                                </li>
                                <li>
                                    <p>Prezzo per singola unità: <?php echo($product->Price);?>.00€</p>
                                </li>
                            </ul>
                            <ul class="list-unstyled addToCart">
                                <li>
                                    <select name="quantity">
                                        <?php for($i=1; $i<=$product->Quantity; $i++): ?>
                                            <option value="<?php echo($i);?>"><?php echo($i);?></option>
                                        <?php endfor ?>
                                    </select>
                                </li>
                                <li>
                                    <a href="addToCart.php">Aggiungi al carrello</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
        <?php endforeach ?>
    </ul>
    <?php else: ?>
        <p class="text-white"><?php echo "Prodotto non disponibile"?></p>
    <?php endif ?>
</section>