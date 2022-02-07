<section>
    <div class="tableContainer">
        <header>
            <h2 class="text-white">NOTIFICHE</h2>
        </header>
        <table class="notifications">
            <tr>
                <th>Data</th>
                <th>Notifica</th>
            </tr>
            <?php foreach($notifications as $notification): ?>
                <tr>
                    <td><?php echo($notification["Time"]);?></td>
                    <td><?php echo($notification["Text"]);?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</section>