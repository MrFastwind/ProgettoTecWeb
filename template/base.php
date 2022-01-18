<?php
    include_once("./bootstrap.php");
?>
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
            <div>
                <form action="search.php" method="POST">
                    <input type="text" id="search" name="search"/>
                    <button type="submit" id="menuButton" name="menuButton"></button>
                </form>
            </div>
            <ul>
                <li>
                    <a href="catalogo.php">Catalogo</a>
                </li>
                <li>
                    <a href="cart.php">Carrello</a>
                </li>
            </ul>
            <ul class="login">
                <li>
                    <a href="signup.php">Sign up</a>
                </li>
                <?php if(!$shop->getUserManager()->isUserLogged()): ?>
                    <li><a href="login.php">Login</a></li>
                <?php else: ?>
                    <li><a href="logout.php">Logout</a></li>
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