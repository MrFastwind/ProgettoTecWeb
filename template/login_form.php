<form action="#" method="POST">
    <h2>Login</h2>
    <?php if(isset($templateParams["erroreLogin"])): ?>
            <p><?php echo $templateParams["erroreLogin"]; ?></p>
    <?php endif; ?>
        <ul>
            <li>
                <input type="text" id="username" name="username" />
            </li>
            <li>
                <input type="password" id="password" name="password" />
            </li>
            <li>
                <input type="submit" name="submit" value="Accedi" />
            </li>
        </ul>
        <footer>
            <p>Non hai un account? <a href="login_form.php">Registrati</a></p>
        </footer>
</form>