<?php if(count($templateParms["prodotti"])!=0): ?>
    <?php foreach ($templateParms["prodotti"] as $prodotto): ?>
        <?php echo $prodotto ?>
    <?php endforeach ?>
<?php endif ?>