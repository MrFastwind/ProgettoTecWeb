<section>
    <header>
        <h1><?php echo($vendorChoice->Name);?></h1>
    </header>
    <form action="#" method="POST">
        <?php if(isset($templateParams["success"])): ?>
            <p class="text-black"><?php echo $templateParams["success"]; ?></p>
        <?php endif; ?>
        <?php if(isset($templateParams["error"])): ?>
            <p class="text-black"><?php echo $templateParams["error"]; ?></p>
        <?php endif; ?>
        <ul class="list-unstyled">
            <li>
                <textarea name="productDescription" id="description" cols="30" rows="5"><?php echo($vendorChoice->Description);?></textarea>
            </li>
            <li>
                <label for="quantity">Quantità: </label>
                <input type="number" min="0" name="quantity" placeholder="Quantità" value="<?php echo($vendorChoice->Quantity);?>"/>
            </li>
            <li>
                <label for="price">Prezzo:</label>
                <input type="number" min="0" name="price" placeholder="Prezzo" value="<?php echo($vendorChoice->Price);?>"/>
            </li>
            <li>
                <div class="btnContainer">
                    <input class="edit-btn" type="submit" name="submitProduct" value="Modifica"/>
                </div>
            </li>
        </ul>
    </form>
</section>