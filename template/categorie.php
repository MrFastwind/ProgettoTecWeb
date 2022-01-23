<header>
    <h2 class="text-white">CATEGORIE</h2>
</header>
<ul class="categories">
    <?php foreach($templateParams["categorie"] as $key=>$name): ?>
        <?php
        echo('<a href="categoria.php?id='.$key.'">'.$name. '</a>');
        /*echo $categoria; */?>
    <?php endforeach ?>
</ul>
