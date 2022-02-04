<header>
    <h2 class="text-white">CARRELLO</h2>
</header>
<table>
    <?php foreach($items as $item):
        $product = $requests->getProductById($item->ProductID);
        $img = $product->Image;
    ?>
        <tr>
            <td><img src=<?php echo($img);?> alt=<?php echo ($product->Name);?>></td>
            <td><?php echo($product->Name);?></td>
            <td><?php echo($item->Quantity);?></td>
        </tr>
    <?php endforeach ?>   
</table>