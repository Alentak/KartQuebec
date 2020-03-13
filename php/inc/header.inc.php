</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Kart'Québéc</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="courses.php">Les courses</a>
                </li>
                <?php if (isset($_SESSION["membre"])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="panier.php">Mon panier <i class="fas fa-shopping-cart"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if(isset($_SESSION["membre"])): ?>
                            <img width='30' height='30' src='img/Profils/<?= $_SESSION["membre"]->photo != "" ? $_SESSION["membre"]->photo : "blank.jpg"?>'> <?= $_SESSION["membre"]->nom . " " . $_SESSION["membre"]->prenom; ?>
                        <?php endif; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="profil.php">Mon compte <i class="fas fa-user"></i></a>
                        <a class="dropdown-item" href="deconnexion.php">Se déconnecter</a>
                    </div>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php">Se connecter</i></a>
                </li>
                <?php endif; ?>
                <?php if (isset($_SESSION["membre"]) && $_SESSION["membre"]->admin) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administration
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="participants.php">Listing participants</a>
                            <a class="dropdown-item" href="historiqueParticipant.php">Historiques</a>
                            <a class="dropdown-item" href="gestioncourses.php">Gestion des courses</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container">