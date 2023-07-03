
<nav class="navbar navbar-expand-lg text-bg-info">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">@monSite</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
            aria-expanded="false" aria-label="Toggle navigation"
        >
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="afficherFruits.php">Fruits</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Panier
                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="listePanier.php">Gestion</a></li>
                        <li><a class="dropdown-item" href="addPanier.php">Ajout</a></li>
                    </ul>
                </li>           
            </ul>

        </div>
    </div>
</nav>