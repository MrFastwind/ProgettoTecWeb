<section>
    <header>
        <h2 class="text-white">NOTIFICHE</h2>
    </header>
    <ul class="list-unstyled notifications">
        <?php foreach($notifications as $notification): ?>
            <li>
                <p class="notifications text-white"><?php echo($notification["Text"]);?></p>
            </li>
        <?php endforeach ?>
    </ul>
</section>