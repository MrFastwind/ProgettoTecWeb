<section>
    <header>
        <h1><?php echo($vendorChoice->Name);?></h1>
    </header>
    <form action="#" method="POST">
        <?php if(isset($templateParams["success"])): ?>
            <p class="text-white"><?php echo $templateParams["success"]; ?></p>
        <?php endif; ?>
        <ul class="list-unstyled">
            <li>
                <textarea name="productDescription" id="description" cols="30" rows="5"><?php echo($vendorChoice->Description);?></textarea>
            </li>
            <li>
                <input type="number" min="0" name="quantity" value="<?php echo($vendorChoice->Quantity);?>"/>
            </li>
            <li>
                <input type="number" min="0" name="price" value="<?php echo($vendorChoice->Price);?>"/>
            </li>
            <li>
                <select name="category">
                    <?php foreach($categories as $categoria): ?>
                        <option value=<?php echo($categoria);?> <?php if($vendorChoice->Category==$categoria): ?> selected="selected" <?php endif ?>>
                        <?php echo($categoria);?>
                    </option>
                    <?php endforeach ?>
                </select>
            </li>
            <li>
                <div class="btnContainer">
                    <input class="edit-btn" type="submit" name="submitProduct" value="Modifica"/>
                </div>
            </li>
        </ul>
    </form>
</section>