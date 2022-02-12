<?php
$stati=['AtStorage','Departed','Delivered','Collected'];
?>

<section>
    <header>
        <h1>Modifica ordine</h1>
    </header>
    <div>
        <label for="edit-select">Digita l'ID dell'ordine da modificare:</label>
        <input type="number" id="order-id">
    </div>
    <div class="is-hidden" id="order">
        <label for="order-status">Modifica l'ordine: </label>
        <select name="order-status" id="order-status">
            <?php foreach($stati as $stato): ?>
                <option value="<?php echo($stato);?>"><?php echo($stato);?></option>
            <?php endforeach ?>
        </select>
    </div>
    <script src="js/modificaOrdine.js"></script>
</section>