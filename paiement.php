<?php include_once 'php/class/all.class.php'; ?>
<?php include_once 'php/inc/head.inc.php'; ?>
<title>Kart'Québéc - Paiement</title>
<?php include_once 'php/inc/header.inc.php';

$membre = $_SESSION['membre'];

if (!isset($_SESSION["membre"]))
    header('location:connexion.php');

if (isset($_POST["commander"])) {
    //Récup les courses du panier
    $courses = $db->Read("SELECT * FROM panier INNER JOIN course ON (panier.numeroCourse = course.Numero) WHERE estCommandee = false AND numeroMembre = '$membre->numero'");

    $total = 0;
} else if (isset($_POST["payer"])) {
    //TODO MODULE DE PAIMENT

    //Met à jour le statut des course de non commandées à commandées en indiquant la date de commande
    $db->Execute("UPDATE panier SET estCommandee = true, dateCommandee = NOW() WHERE numeroMembre='$membre->numero'");
    header('location:courses.php');
} else
    header('location:panier.php');

?>
<main>
    <h1>Paiement</h1>
    <div class="row">
        <div class="col-4">
            <h3>Les courses commandées</h3>
            <?php
            foreach ($courses as $c) :
                $total += $c["Prix"];
            ?>
                <p>Nom de la course : <?= $c["Description"] ?><br>Date : <?= strftime("%d %B %Y", strtotime($c["Date"])) . " à " . date("H:i", strtotime($c["Date"])) ?><br>Prix : $<?= $c["Prix"] ?></p>
            <?php endforeach; ?>
            <p>Prix total : $<?= $total ?></p>
        </div>
        <div class="col-8">
            <h3>Informations de paiement</h3>
            <form method="POST">
                <input class="form-control" type="text" placeholder="Carte">
                <input type="submit" class="btn btn-primary" name="payer" value="Payer">
            </form>
        </div>
    </div>
</main>
<?php include_once 'php/inc/footer.inc.php'; ?>