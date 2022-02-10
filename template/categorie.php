<header>
    <h1>CATEGORIE</h1>
</header>
<section>
    <ul class="categories list-unstyled">
        <?php foreach($templateParams["categorie"] as $key=>$name): ?>
        <li>
            <?php
            echo('<a class="category" href="categoria.php?id='.$key.'"style="background-image: linear-gradient(rgba(0,0,0,.4), rgba(0,0,0,.4)), url('.retrieveImage($name,IMG_DIR).'">'.$name. '</a>');
            ?>
        <?php endforeach ?>
        </li>
    </ul>
</section>