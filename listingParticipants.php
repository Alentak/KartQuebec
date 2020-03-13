<?php include_once 'php/class/all.class.php'; ?>
<?php include_once 'php/inc/head.inc.php'; ?>
<title>Kart'Québéc - Listing des participants</title>
<?php include_once 'php/inc/header.inc.php';

$participants = $db->Read("SELECT * FROM panier INNER JOIN membre ON (membre.Numero = panier.numeroMembre) INNER JOIN course ON (course.Numero = panier.numeroCourse) GROUP BY membre.Numero");
$_SESSION["participants"] = $participants;
?>
<main>
    <h1>Les participants</h1>
    <?php
    foreach ($participants as $r) :
        $membre = new Membre($r["Numero"], $r["Nom"], $r["Prenom"], $r["Telephone"], $r["Courriel"], $r["MDP"], strftime("%d %B %Y", strtotime($r["DDN"])), $r["Experience"], $r["Poids"], $r["Photo"], strftime("%d %B %Y", strtotime($r["Inscription"])), $r["EstAdmin"]);

        $courses = $db->Read("SELECT * FROM panier INNER JOIN membre ON (membre.Numero = panier.numeroMembre) INNER JOIN course ON (course.Numero = panier.numeroCourse) WHERE membre.Numero = $membre->numero");
    ?>
        <article>
            <div class="row">
                <div class="col-6">
                    <h2><?= $membre->prenom." ".$membre->nom?></h2>
                    <p>Telephone : <?= $membre->telephone ?></p>
                    <p>Courriel : <?= $membre->courriel ?></p>
                    <p>Date de naissance : <?= $membre->ddn ?></p>
                    <p>Experience : <?= $membre->experience ?> ans</p>
                    <p>Poids : <?= $membre->poids ?> kg</p>
                    <p>Photo : <img src="img/Profils/<?= $membre->photo ?>" alt="photo membre" width="100" height="100"></p>
                    <p>Inscrit le : <?= $membre->inscription ?></p>
                </div>
                <div class="col-6">
                    <h3>Courses</h3>
                    <table>
                        <tr>
                            <th>Numéro</th>
                            <th>Nom</th>
                        </tr>
                        <?php foreach ($courses as $c) : ?>
                            <tr>
                                <td><?= $c["numeroCourse"] ?></td>
                                <td><?= $c["Description"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </article>
    <?php
    endforeach;
    ?>
    <a href="pdfParticipants.php" target="_blank"><i class="far fa-file-pdf" style="font-size:50px;color:red;"></i> Exporter au format PDF</a>
</main>
<?php include_once 'php/inc/footer.inc.php'; ?>