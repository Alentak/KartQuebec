<?php include_once 'php/class/all.class.php'; ?>
<?php include_once 'php/inc/head.inc.php'; ?>
<title>Kart'Québéc - Connexion</title>
<?php include_once 'php/inc/header.inc.php'; ?>
<?php
$membre = null;
$erreur = null;
if (isset($_POST["submit"])) {

    $courriel = $_POST["courriel"];
    $mdp = md5($_POST["mdp"]);

    $membre = Membre::GetMembreByCourriel($db, $courriel);

    if($membre == null || $membre->mdp != $mdp)
        $erreur = "<div class='alert alert-danger' role='alert'>Mot de passe ou email incorrecte</div>";
    else{
        $_SESSION["membre"] = $membre;
        header('location:profil.php');
    }
}
?>
<main>
    <div class="container">
        <?= $erreur != null ? $erreur : "" ?>
        <h2>Connexion</h2>
        <form action="" method="POST">
            <div class="row">
                <div class="col-4">
                    <input class="form-control" type="email" name="courriel" placeholder="Courriel" required value=<?= isset($_POST["courriel"]) ? $_POST["courriel"] : ''?>>
                    <input class="form-control" type="password" name="mdp" placeholder="Mot de passe" minlength="8" required value=<?= isset($_POST["mdp"]) ? $_POST["mdp"] : ''?>>
                    <input class="btn btn-primary btn-lg" type="submit" name="submit" value="Se connecter">
                </div>
            </div>
        </form>
        <a href="inscription.php">Pas encore inscrit ?</a>
    </div>
</main>
<?php include_once 'php/inc/footer.inc.php'; ?>