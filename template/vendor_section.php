<header>
    <h2 class="text-white">AGGIUNGI UN PRODOTTO</h2>
</header>
<form action="#" method="POST">
    <?php if(isset($templateParams["success"])): ?>
        <p class="text-white"><?php echo $templateParams["success"]; ?></p>
    <?php endif; ?>
    <ul class="list-unstyled">
        <li>
            <input type="text" name="productName" placeholder="Nome del prodotto"/>
        </li>
        <li>
            <textarea name="productDescription" id="description" cols="30" rows="5" placeholder="Breve descrizione del prodotto..."></textarea>
        </li>
        <li>
            <input type="text" name="quantity" placeholder="Quantità"/>
        </li>
        <li>
            <input type="text" name="price" placeholder="Prezzo"/>
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
            <input type="submit" name="submitProduct" value="Aggiungi"/>
        </li>
    </ul>
</form>