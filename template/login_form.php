<form action="#" method="POST" class="login">
    <h1>LOGIN</h1>
    <?php if(isset($templateParams["erroreLogin"])): ?>
        <p><?php echo $templateParams["erroreLogin"]; ?></p>
    <?php endif; ?>
    <ul class="list-unstyled">
        <li>
            <label for="username" hidden>Username</label>
            <input type="text" id="username" name="username" placeholder="Username / Email" />
        </li>
        <li>
            <label for="password" hidden>password</label>
            <input type="password" id="password" name="password" placeholder="Password" />
        </li>
        <li>
            <div class="btnContainer">
                <input type="submit" name="submit" value="Accedi"/>
            </div>
        </li>
    </ul>
    <footer>
        <p>Non hai un account? <a href="signup.php">Registrati</a></p>
    </footer>
</form>