<?php include_once 'php/class/all.class.php'; ?>
<?php include_once 'php/inc/head.inc.php'; ?>
<title>Kart'Québéc - Inscription</title>
<?php include_once 'php/inc/header.inc.php'; ?>
<?php include_once 'php/traitements/tinscription.php'; ?>

<main>
    <h1>Inscription</h1>
    <form action="" method="POST">
        <div class="container">
            <?= isset($msg["General"]) ? "<div class='col-12'>" . $msg["General"] . "</div>" : "" ?>
            <div class="row">
                <div class="col-3">
                    <label for="numero">Numéro</label>
                    <input class="form-control" type="text" name="numero" required>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="nom">Nom</label>
                    <input class="form-control" type="text" name="nom" required>
                </div>
                <div class="col-3">
                    <label for="prenom">Prénom</label>
                    <input class="form-control" type="text" name="prenom" required>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="courriel">Courriel</label>
                    <input class="form-control" type="email" name="courriel" required>
                </div>
                <div class="col-3">
                    <label for="telephone">Téléphone</label>
                    <input class="form-control" type="text" name="telephone" required>
                </div>
                <?= isset($msg["Courriel"]) ? "<div class='col-3'>" . $msg["Courriel"] . "</div>" : "" ?>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="mdp">Mot de passe (min 8 caractères)</label>
                    <input class="form-control" type="password" name="mdp" minlength="8" required>
                </div>
                <div class="col-3">
                    <label for="confirmmdp">Confirmation</label>
                    <input class="form-control" type="password" name="confirmmdp" minlength="8" required>
                </div>
                <?= isset($msg["MDP"]) ? "<div class='col-3'>" . $msg["MDP"] . "</div>" : "" ?>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="experience">Année(s) d'expérience</label>
                    <input class="form-control" type="number" name="experience" min="0" value="0" required>
                </div>
                <div class="col-3">
                    <label for="ddn">Date de naissance</label>
                    <input class="form-control" type="date" name="ddn" required>
                </div>
                <div class="col-3">
                    <label for="poids">Poids (en kg)</label>
                    <input class="form-control" type="number" name="poids" min="1" value="70" required>
                </div>
                <?= isset($msg["DDN"]) ? "<div class='col-3'>" . $msg["DDN"] . "</div>" : "" ?>
            </div>
            <div class="row">
                <div class="col-4">
                    <label for="photo">Photo</label>
                    <input class="form-control-file" type="file" name="photo">
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <input class="btn btn-primary btn-lg" type="submit" name="submit" value="S'inscrire">
                </div>
            </div>
        </div>
    </form>
</main>

<?php include_once 'php/inc/footer.inc.php'; ?>