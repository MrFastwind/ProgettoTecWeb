<?php if(count($templateParams["prodotti"])!=0): ?>
    <?php foreach ($templateParams["prodotti"] as $prodotto): ?>
        <?php echo $prodotto ?>
    <?php endforeach ?>
    <?php else: ?>
        <p class="text-white"><?php echo "Prodotto non disponibile"?></p>
<?php endif ?>