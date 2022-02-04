<header>
    <h2 class="text-white">CATEGORIE</h2>
</header>
<ul class="categories list-unstyled">
    <?php foreach($templateParams["categorie"] as $key=>$name): ?>
    <li>
        <?php
        echo('<a href="categoria.php?id='.$key.'">'.$name. '</a>');
        ?>
    <?php endforeach ?>
    </li>
</ul>
