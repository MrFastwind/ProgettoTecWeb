<form action="#" method="POST">
    <h2 class="text-white">LOGIN</h2>
    <?php if(isset($templateParams["erroreLogin"])): ?>
        <p><?php echo $templateParams["erroreLogin"]; ?></p>
    <?php endif; ?>
    <ul class="list-unstyled">
        <li>
            <input type="text" id="username" name="username" placeholder="Username / Email" />
        </li>
        <li>
            <input type="password" id="password" name="password" placeholder="Password" />
        </li>
        <li>
            <input type="submit" name="submit" value="Accedi"/>
        </li>
    </ul>
    <footer>
        <p>Non hai un account? <a href="signup.php" class="text-warning">Registrati</a></p>
    </footer>
</form>