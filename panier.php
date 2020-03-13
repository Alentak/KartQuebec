<?php include_once 'php/class/all.class.php'; ?>
<?php include_once 'php/inc/head.inc.php'; ?>
<title>Kart'Québéc - Panier</title>
<?php include_once 'php/inc/header.inc.php'; 

if (!isset($_SESSION["membre"]))
    header('location:connexion.php');

$panier = $db->Read("SELECT course.Numero, Description, Nom, Date FROM course INNER JOIN panier ON course.Numero = panier.numeroCourse INNER JOIN membre ON panier.numeroMembre = membre.Numero WHERE membre.Numero = {$_SESSION["membre"]->numero} AND estCommandee = false");

if (isset($_GET["c"])) {
    $_SESSION["membre"]->RetirerCoursePanier($db, $_GET["c"]);
    header('location:panier.php');
}
?>
<main>
    <h1>Mon panier</h1>
    <div class="row">
        <?php foreach ($panier as $p) : ?>
            <div class="col-4">
                <article>
                    <h3><?= $p["Description"] ?></h3>
                    <p>Date de la course : <?= strftime("%d %B %Y", strtotime($p["Date"])) . " à " . date("H:i", strtotime($p["Date"])) ?></p>
                    <a href="panier.php?c=<?= $p["Numero"] ?>"><button type="submit" class="btn btn-primary"><i class="fas fa-trash-alt"></i></button></a>

                </article>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (count($panier) > 0) : ?>
        <form action="paiement.php" method="POST">
            <input type="submit" value="Commander" name="commander" class="btn btn-primary">
        </form>
    <?php else : ?>
        Le panier est vide
    <?php endif; ?>
</main>
<?php include_once 'php/inc/footer.inc.php'; ?>