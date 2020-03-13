<?php include_once 'php/class/all.class.php'; ?>
<?php include_once 'php/inc/head.inc.php'; ?>
<title>Kart'Québéc - Mon compte</title>
<?php include_once 'php/inc/header.inc.php';

//Si connecté, on affiche le profil de la personne, sinon on renvoi vers la page de connexion
if (!isset($_SESSION["membre"]))
    header('location:connexion.php');

include 'php/traitements/tprofil.php';
?>

<main>
    <div class="container">
        <h1>Profil</h1>
        <form method="POST">
            <div class="row">
                <div class="col-12">
                    <?= isset($msg["Infos"]) ? $msg["Infos"] : "" ?>
                    <h4>Mes informations</h4>
                </div>
                <div class="col-3">
                    <label for="nom">Nom</label>
                    <input class="form-control" type="text" name="nom" placeholder="Nom" value=<?= $membre->nom ?>>
                </div>
                <div class="col-3">
                    <label for="prenom">Prénom</label>
                    <input class="form-control" type="text" name="prenom" placeholder="Prénom" value=<?= $membre->prenom ?>>
                </div>
                <div class="col-3">
                    <label for="tel">Téléphone</label>
                    <input class="form-control" type="tel" name="tel" placeholder="Téléphone" value=<?= $membre->telephone ?>>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <label for="experience">Année(s) d'expérience</label>
                    <input class="form-control" type="number" name="experience" value=<?= $membre->experience ?> min=0 max=999 maxlength="3">
                </div>
                <div class="col-3">
                    <label for="poids">Poids</label>
                    <input class="form-control" type="number" name="poids" value=<?= $membre->poids ?> min=0 max=999 maxlength="3">
                </div>
                <div class="col-12"><input class="btn btn-primary" type="submit" name="modifInfos" value="Modifier"></div>
            </div>
        </form>
        <hr>
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12">
                    <?= isset($msg["Photo"]) ? $msg["Photo"] : "" ?>
                    <h4>Photo de profil</h4>
                </div>
                <div class="col-2"><img width="100" height="100" src="img/Profils/<?= $membre->photo != "" ? $membre->photo : "blank.jpg" ?>" alt="Photo de profil"></div>
                <div class="col-4"><input type="file" name="file"></div>
                <div class="col-4"><input class="btn btn-primary" type="submit" name="modifPhoto" value="Modifier"></div>
            </div>
        </form>
        <hr>
        <form method="POST">
            <div class="row">
                <div class="col-12">
                    <?= isset($msg["Courriel"]) ? $msg["Courriel"] : "" ?>
                    <h4>Adresse mail</h4>
                </div>
                <div class="col-4"><input class="form-control" type="email" name="courriel" placeholder="Courriel" value=<?= $membre->courriel ?>></div>
                <div class="col-6"><input class="btn btn-primary" type="submit" name="modifCourriel" value="Modifier"></div>
            </div>
        </form>
        <hr>
        <form method="POST">
            <div class="row">
                <div class="col-12">
                    <?= isset($msg["MDP"]) ? $msg["MDP"] : "" ?>
                    <h4>Mot de passe</h4>
                </div>
                <div class="col-4"><input class="form-control" type="password" name="ancienmdp" placeholder="Ancien" minlength=8></div>
                <div class="col-4"><input class="form-control" type="password" name="nouveaumdp" placeholder="Nouveau" minlength=8></div>
                <div class="col-4"><input class="form-control" type="password" name="nouveaumdp2" placeholder="Répéter nouveau" minlength=8></div>
                <div class="col-12"><input class="btn btn-primary" type="submit" name="modifMdp" value="Modifier"></div>
            </div>
        </form>
        <form method="POST">
            <div class="row">
                <div class="col-12">
                    Inscrit depuis le <?= strftime("%d %B %Y", strtotime($membre->inscription)); ?>
                    <input class="btn btn-danger" type="submit" name="supprimerCompte" value="Supprimer compte">
                </div>
            </div>
        </form>
        <hr>
        <div class="row">
            <div class="col-12">
                <h1>Mon historique</h1>
                <h3>Les courses à venir</h3>
                <?php if (count($avenir) > 0) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom de la course</th>
                                <th>Départ</th>
                                <th>Prix</th>
                                <th>Nombre de tours</th>
                                <th>Sens</th>
                                <th>Remarques</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($avenir as $a) : ?>
                                <tr>
                                    <td><?= $a["Description"] ?></td>
                                    <td><?= strftime("%d %B %Y", strtotime($a["Date"])) . " à " . date("H\hi", strtotime($a["Date"])) ?></td>
                                    <td><?= "$" . $a["Prix"] ?></td>
                                    <td><?= $a["NbTours"] ?></td>
                                    <td><?= $a["SensCourse"] ?></td>
                                    <td><?= $a["Remarques"] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    Aucune course à venir.
                <?php endif; ?>
                <hr>
                <h3>Les courses éfféctuées</h3>
                <?php if (count($effectuees) > 0) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom de la course</th>
                                <th>Départ</th>
                                <th>Prix</th>
                                <th>Nombre de tours</th>
                                <th>Sens</th>
                                <th>Remarques</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($effectuees as $e) : ?>
                                <tr>
                                    <td><?= $e["Description"] ?></td>
                                    <td><?= strftime("%d %B %Y", strtotime($e["Date"])) . " à " . date("H\hi", strtotime($e["Date"])) ?></td>
                                    <td><?= "$" . $e["Prix"] ?></td>
                                    <td><?= $e["NbTours"] ?></td>
                                    <td><?= $e["SensCourse"] ?></td>
                                    <td><?= $e["Remarques"] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    Aucune course éfféctuées
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include_once 'php/inc/footer.inc.php'; ?>