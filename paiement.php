<?php include_once 'php/class/all.class.php'; ?>
<?php include_once 'php/inc/head.inc.php'; ?>
<title>Kart'Québéc - Paiement</title>
<link rel="stylesheet" href="css/style.css">
<?php include_once 'php/inc/header.inc.php';

$membre = $_SESSION['membre'];

if (!isset($_SESSION["membre"]))
    header('location:connexion.php');

if (isset($_POST["commander"])) {
    //Récup les courses du panier
    $courses = $db->Read("SELECT * FROM panier INNER JOIN course ON (panier.numeroCourse = course.Numero) WHERE estCommandee = false AND numeroMembre = '$membre->numero'");

    $total = 0;
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
            <form action="charge.php" method="post" id="payment-form">
            <div class="form-row">
                <input type="hidden" name="prix" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Nom" value="<?= $total ?>" required>

                <div id="card-element" class="form-control mt-4">
                    <!-- css BootStrap -->
                    <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
            </div>

            <button>Paiement</button>
        </form>
        </div>
    </div>

    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="js/charge.js"></script>
</main>
<?php include_once 'php/inc/footer.inc.php'; ?>