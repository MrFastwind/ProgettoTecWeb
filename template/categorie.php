<header>
    <h2 class="text-white">CATEGORIE</h2>
</header>
<ul class="categories">
    <?php foreach($templateParams["categorie"] as $key=>$categoria): ?>
        <?php
        echo(`<a href="categoria.php?id=$key">`);
        echo $categoria; ?></a>
    <?php endforeach ?>
</ul>
