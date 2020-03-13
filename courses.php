<?php include_once 'php/class/all.class.php'; ?>
<?php include_once 'php/inc/head.inc.php'; ?>
<title>Kart'Québéc - Les courses</title>
<?php include_once 'php/inc/header.inc.php';

$_SESSION["ajouterCourse"] = null;

if (isset($_GET["c"])) {
    $_SESSION["ajouterCourse"] = $_SESSION["membre"]->AjouterCoursePanier($db, $_GET["c"]);
}
//Pour que le nom de la variable soit court
if (isset($_SESSION["ajouterCourse"]))
    $msg = $_SESSION["ajouterCourse"];

?>
<main>
    <h1>Les courses</h1>
    <?php if (isset($msg)) : ?>
        <div class="row">
            <div class="col">
                <?= isset($msg["Fail"]) ? $msg["Fail"] : $msg["Success"]; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <?php
        foreach (Course::GetCourses($db) as $r) :
            $c = new Course($r["Numero"], $r["Description"], strftime("%d %B %Y", strtotime($r["Date"])), $r["SensCourse"], $r["NbTours"], $r["DirecteurCourse"], $r["ResponsablePiste"], $r["CategorieKart"], $r["Prix"], $r["Remarques"], $r["Visible"]);
        ?>
            <div class="col-4">
                <article>
                    <h2><?= $c->description ?></h2>
                    <p>Date : <?= $c->date ?></p>
                    <p>Heure : <?= date("H:i", strtotime($c->date)) ?></p>
                    <p>Nombre de tour(s) : <?= $c->nbTours ?></p>
                    <p>Catégorie kart : <?= $c->categorieKart ?></p>
                    <p>Prix : <?= $c->prix ?>$</p>
                    <?php if (isset($_SESSION["membre"])) : ?>
                        <p>Numéro course : <?= $c->numero ?></p>
                        <p>Sens de la course : <?= $c->sensCourse ?></p>
                        <p>Remarques : <?= $c->remarques ?></p>
                        <p>Directeur de course : <?= $c->directeur ?></p>
                        <p>Responsable de piste : <?= $c->responsable ?></p>
                    <?php endif; ?>
                    <a href="courses.php?c=<?= $c->numero ?>"><button type="submit" class="btn btn-primary">Ajouter au panier</button></a>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php include_once 'php/inc/footer.inc.php'; ?>