<header>
    <h1 class="text-white"><?php echo $templateParams["title"]; ?></h1>
</header>
<section>
    <ul class="list-unstyled accordion" id="accordion">
        <?php foreach($products as $product): ?>
            <li>
                <div class="accordion-item">
                    <h2 class="accordionHeader" id="<?php echo($product->Name);?>Label">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo($product->Name);?>" aria-expanded="true" aria-controls="<?php echo($product->Name);?>"><?php echo($product->Name);?></button>
                    </h2>
                    <div id="<?php echo($product->Name);?>" class="accordion-collapse collapse show" aria-labelledby="<?php echo($product->Name);?>Label" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            <?php echo($product->Description);?>
                            <ul class="list-unstyled addToCart">
                                <li>
                                    <select name="quantity">
                                        <?php for($i=1; $i<=$product->Quantity; $i++): ?>
                                            <option value="<?php echo($i);?>"><?php echo($i);?></option>
                                        <?php endfor ?>
                                    </select>
                                </li>
                                <li>
                                    <a href="#">Aggiungi al carrello</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach ?>
    </ul>
</section>