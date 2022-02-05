<!DOCTYPE html>
<html lang="it">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet"/> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css"/>
    <script type="text/javascript" src="/js/nav.js"></script>
    <title><?php echo $templateParams["title"];?></title>
</html>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <header>
        <nav id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn text-decoration-none text-dark" onclick="closeNav()">&times;</a>
            <form action="search.php" method="POST">
                <input type="text" id="search" name="search"/>
                <button type="submit" class="searchbtn">
                    <img src="/img/search.png" alt="Search">
                </button>
            </form>
            <ul class="list-unstyled">
                <li>
                    <a class="text-decoration-none text-dark" href="catalogo.php">Catalogo</a>
                </li>
                <li>
                    <a class="text-decoration-none text-dark" href="cart.php">Carrello</a>
                </li>
            </ul>
            <ul class="login list-unstyled">
                <li>
                    <a class="text-decoration-none text-dark" href="signup.php">Sign up</a>
                </li>
                <?php if(!$shop->getUserManager()->isUserLogged()): ?>
                    <li><a class="text-decoration-none text-dark" href="login.php">Login</a></li>
                <?php else: ?>
                    <li><a class="text-decoration-none text-dark" href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
            <?php if($shop->getUserManager()->isUserLogged()): 
                $user = $_SESSION["User"];
                    if($user->isVendor):
            ?>
                <ul class="list-unstyled">
                    <li>
                        <a href="venditore.php" class="text-decoration-none text-dark">Vendi</a>
                    </li>
                    <li>
                        <a href="modifica.php" class="text-decoration-none text-dark">Modifica un prodotto</a>
                    </li>
                </ul>
                <?php endif;?>
            <?php endif; ?>
        </nav>
        <div>
            <!--TODO: add logo-->
        </div>
        <span onclick="openNav()">&#9776;</span>
    </header>
    <main class="flex-container">
        <?php if(isset($templateParams["name"])){
            require($templateParams["name"]);
        }
        ?>
    </main>
    <footer>
        <ul class="list-unstyled">
            <li><a class="text-decoration-none text-white" href="#">TERMINI DI SERVIZIO</a></li>
            <li><a class="text-decoration-none text-white" href="#">PRIVACY POLICY</a></li>
            <li><a class="text-decoration-none text-white" href="#">SPEDIZIONE</a></li>
        </ul>
        <ul class="list-unstyled" id="social">
            <li><a class="text-decoration-none text-white" href="#">TWITTER</a></li>
            <li><a class="text-decoration-none text-white" href="#">FACEBOOK</a></li>
            <li><a class="text-decoration-none text-white" href="#">INSTAGRAM</a></li>
        </ul>
        <!--TODO: add logo-->
    </footer>
</body>