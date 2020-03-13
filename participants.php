<?php include_once 'php/class/all.class.php'; ?>
<?php include_once 'php/inc/head.inc.php'; ?>
<title>Kart'Québéc - Connexion</title>
<?php include_once 'php/inc/header.inc.php';

$courses = $db->Read("SELECT * FROM panier INNER JOIN membre ON (membre.Numero = panier.numeroMembre) INNER JOIN course ON (course.Numero = panier.numeroCourse) GROUP BY course.Numero");
$_SESSION["courses"] = $courses;
?>
<main>
    <h1>Les courses</h1>
    <?php
    foreach ($courses as $r) :
        $c = new Course($r["Numero"], $r["Description"], strftime("%d %B %Y", strtotime($r["Date"])), $r["SensCourse"], $r["NbTours"], $r["DirecteurCourse"], $r["ResponsablePiste"], $r["CategorieKart"], $r["Prix"], $r["Remarques"], true);

        $participants = $db->Read("SELECT * FROM panier INNER JOIN membre ON (membre.Numero = panier.numeroMembre) INNER JOIN course ON (course.Numero = panier.numeroCourse) WHERE course.Numero = $c->numero AND estCommandee = true");
    ?>
        <article>
            <div class="row">
                <div class="col-6">
                    <h2><?= $c->description ?></h2>
                    <p>Numéro course : <?= $c->numero ?></p>
                    <p>Date : <?= $c->date ?></p>
                    <p>Heure : <?= date("H:i", strtotime($c->date)) ?></p>
                    <p>Sens de la course : <?= $c->sensCourse ?></p>
                    <p>Nombre de tour(s) : <?= $c->nbTours ?></p>
                    <p>Directeur de course : <?= $c->directeur ?></p>
                    <p>Responsable de piste : <?= $c->responsable ?></p>
                    <p>Catégorie kart : <?= $c->categorieKart ?></p>
                    <p>Prix : <?= $c->prix ?>$</p>
                    <p>Remarques : <?= $c->remarques ?></p>
                </div>
                <div class="col-6">
                    <h3>Participants</h3>
                    <table>
                        <tr>
                            <th>Numéro</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                        </tr>
                        <?php foreach ($participants as $p) : ?>
                            <tr>
                                <td><?= $p["numeroMembre"] ?></td>
                                <td><?= $p["Nom"] ?></td>
                                <td><?= $p["Prenom"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </article>
    <?php
    endforeach;
    ?>
    <a href="listingParticipants.php" target="_blank"><i class="far fa-file-pdf" style="font-size:50px;color:salmon;"></i> Exporter au format PDF</a>
</main>
<?php include_once 'php/inc/footer.inc.php'; ?>