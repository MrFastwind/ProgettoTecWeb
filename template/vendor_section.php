<header>
    <h1>AGGIUNGI UN PRODOTTO</h1>
</header>
<form action="#" method="POST">
    <?php if(isset($templateParams["success"])): ?>
        <p class="text-white"><?php echo $templateParams["success"]; ?></p>
    <?php endif; ?>
    <ul class="list-unstyled">
        <li>
            <input type="text" class="product-name" name="productName" placeholder="Nome del prodotto"/>
        </li>
        <li>
            <textarea name="productDescription" id="description" cols="30" rows="5" placeholder="Breve descrizione del prodotto..."></textarea>
        </li>
        <li>
            <input type="number" min="0" name="quantity" placeholder="Quantità"/>
        </li>
        <li>
            <input type="number" min="0" name="price" placeholder="Prezzo"/>
        </li>
        <li>
            <select name="category">
                <option value="" disabled selected>Scegli una categoria...</option>
                <?php foreach($categories as $categoria): ?>
                    <option value=<?php echo($categoria);?>><?php echo($categoria);?></option>
                <?php endforeach ?>
            </select>
        </li>
        <li>
            <div class="btnContainer">
                <input type="submit" name="submitProduct" value="Aggiungi"/>
            </div>
        </li>
    </ul>
</form>