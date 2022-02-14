<form action="#" method="POST" class="signup">
    <h1>SIGN UP</h1>
    <?php if(isset($templateParams["erroreSignup"])): ?>
        <p><?php echo $templateParams["erroreSignup"]; ?></p>
    <?php endif; ?>
        <ul class="list-unstyled">
            <li>
                <label for="username" hidden>username</label>
                <input type="text" id="username" name="username" placeholder="Username"/>
            </li>
            <li>
                <label for="email" hidden>email</label>
                <input type="text" id="email" name="email" placeholder="email"/>
            </li>
            <li>
                <label for="password" hidden>password</label>
                <input type="password" id="password" name="password" placeholder="Password"/>
            </li>
            <li>
                <div class="btnContainer">
                    <label for="registrati" hidden>invia</label>
                    <input type="submit" name="registrati" value="Registrati"/>
                </div>
            </li>
        </ul>
        <footer>
            <p>Hai già un account? <a href="login.php">Accedi</a></p>
        </footer>
</form>