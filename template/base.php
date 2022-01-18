<!DOCTYPE html>
<html lang="it">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="../css/style.css"/>
    <title><?php echo $templateParams["title"];?></title>
</html>
<body>
    <header>
        <nav>
            <div> <input type="text" id="menuSearch" name="menuSearch"></div> <!--TODO: make search bar-->
            <ul>
                <li>
                    <a href="catalogo.php">Catalogo</a>
                </li>
                <li>
                    <a href="#">Carrello</a> <!--TODO: add cart link-->
                </li>
            </ul>
            <ul class="login">
                <?php if(!isUserLoggedIn()): ?>
                    <li><a href="login.php">Login</a></li>
                <?php else: ?>
                    <li><button>Logout</button></li> <!--TODO: add logout-->
                <?php endif; ?>
            </ul>
        </nav>
        <div>
            <!--TODO: add logo-->
        </div>
    </header>
    <main>
        <?php if(isset($templateParams["name"])){
            require($templateParams["name"]);
        }
        ?>
    </main>
</body>
<footer><!--TODO: add links-->
    <ul>
        <li><a href="#">Termini di servizio</a></li>
        <li><a href="#">Privacy policy</a></li>
        <li><a href="#">Spedizione</a></li>
    </ul>
    <ul id="social">
        <li><a href="#">Twitter</a></li>
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Instagram</a></li>
    </ul>
    <!--TODO: add logo-->
</footer>