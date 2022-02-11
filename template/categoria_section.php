<section>
    <header>
        <h1><?php echo $templateParams["title"]; ?></h1>
    </header>
    <?php if(isset($templateParams["cartSuccess"])): ?>
        <p class="text-white"><?php echo($templateParams["cartSuccess"]);?></p>
    <?php endif ?>
    <ul class="list-unstyled accordion" id="accordion">
        <?php foreach($products as $product): ?>
            <?php if($product->Quantity!=0): ?>
                <li>
                    <div class="accordion-item">
                        <h2 class="accordionHeader" id="<?php echo($product->Name);?>Label">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo($product->Name);?>" aria-expanded="false" aria-controls="<?php echo($product->Name);?>"><?php echo($product->Name);?></button>
                        </h2>
                        <div id="<?php echo($product->Name);?>" class="accordion-collapse collapse" aria-labelledby="<?php echo($product->Name);?>Label" data-bs-parent="#accordion" style="background-image: linear-gradient(rgba(55,55,55,.6), rgba(55,55,55,.6)), url('<?php echo(retrieveImage($product->Image,IMG_DIR));?>');">
                            <div class="accordion-body">
                                <ul class="list-unstyled">
                                    <li>
                                        <p class="text-white"><?php echo($product->Description);?></p>
                                    </li>
                                    <li>
                                        <p class="text-white">Prezzo per singola unità: <?php echo($product->Price);?>.00€</p>
                                    </li>
                                </ul>
                                <form action="addToCart.php" method="POST">
                                    <ul class="list-unstyled addToCart">
                                        <li>
                                            <select name="quantity">
                                                <?php for($i=1; $i<=$product->Quantity; $i++): ?>
                                                    <option value="<?php echo($i);?>"><?php echo($i);?></option>
                                                <?php endfor ?>
                                            </select>
                                        </li>
                                        <li>
                                            <input type="submit" name="add" value="🛒Aggiungi al carrello" id="addToCart"/>
                                        </li>
                                        <li>
                                            <input type="hidden" name="product" value="<?php echo($product->ProductID);?>"/>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endif ?>
        <?php endforeach ?>
    </ul>
</section>