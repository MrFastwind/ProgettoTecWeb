<form action="#" method="POST">
    <h1>SIGN UP</h1>
    <?php if(isset($templateParams["erroreSignup"])): ?>
        <p><?php echo $templateParams["erroreSignup"]; ?></p>
    <?php endif; ?>
        <ul class="list-unstyled">
            <li>
                <input type="text" id="username" name="username" placeholder="Username"/>
            </li>
            <li>
                <input type="text" id="email" name="email" placeholder="email"/>
            </li>
            <li>
                <input type="password" id="password" name="password" placeholder="Password"/>
            </li>
            <li>
                <div class="btnContainer">
                    <input type="submit" value="Registrati"/>
                </div>
            </li>
        </ul>
        <footer>
            <p>Hai già un account? <a href="login.php" class="text-warning">Accedi</a></p>
        </footer>
</form>