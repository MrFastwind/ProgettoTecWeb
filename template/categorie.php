<header>
    <h2>Categorie</h2>
</header>
<ul class="categories">
    <?php foreach($templateParams["categorie"] as $key=>$categoria): ?>
        <?php
        echo(`<a href="categoria.php?id=$key">`);
        echo $categoria; ?></a> <!--TODO: add nomecategoria and link-->
    <?php endforeach ?>
</ul>
