<?php include_once 'php/class/all.class.php'; ?>
<?php include_once 'php/inc/head.inc.php'; ?>
<title>Kart'Québéc - Historique participant</title>
<?php include_once 'php/inc/header.inc.php';

$participants = $db->Read("SELECT * FROM membre");

if (isset($_POST["submit"])) {
    if ($_POST["participant"] == "")
        $msg["submit"] = "<div class='alert alert-danger' role='alert'>Veuillez choisir un participant</div>";

    $numeroMembre = htmlentities($_POST["participant"]);
}

?>
<main>
    <?= isset($msg["submit"]) ? $msg["submit"] : "" ?>
    <div class="row">
        <div class="col-4">
            <form method="POST">
                <label for="participant">Participant</label>
                <select class="form-control mb-3" name="participant" required>
                    <option value="" selecte hidden>Choisir un participant</option>
                    <?php foreach ($participants as $p) : ?>
                        <option value=<?= $p["Numero"] ?>><?= $p["Numero"] . " - " . $p["Nom"] . " " . $p["Prenom"] ?></option>
                    <?php endforeach; ?>
                </select>
                <input class="btn btn-primary" type="submit" name="submit" value="Voir historique">
            </form>
        </div>
    </div>
    <?php if (!isset($msg["submit"]) && isset($_POST["submit"])) :
        $avenir = $db->Read("SELECT * FROM panier INNER JOIN course ON (panier.numeroCourse = course.Numero) WHERE Visible = true AND estCommandee = true AND numeroMembre = \"$numeroMembre\" AND Date > CURRENT_TIMESTAMP ORDER BY Date ASC");
        $effectuees = $db->Read("SELECT * FROM panier INNER JOIN course ON (panier.numeroCourse = course.Numero) WHERE estCommandee = true AND numeroMembre = \"$numeroMembre\" AND Date < CURRENT_TIMESTAMP ORDER BY Date DESC");
    ?>
        <div class="row">
            <div class="col-12">
                <h1>Historique</h1>
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
    <?php endif; ?>
</main>
<?php include_once 'php/inc/footer.inc.php'; ?>