<?php
if (!empty($_GET['tid']) && !empty($_GET['produit'])) {
    $_GET = filter_var_array($_GET, FILTER_SANITIZE_STRING);
} else {
    header('location: index.php');
}
?>
<?php include_once 'php/class/all.class.php'; ?>
<?php include_once 'php/inc/head.inc.php'; ?>
<title>Kart'Québéc - Paiement effectué</title>
<?php include_once 'php/inc/header.inc.php'; ?>
<main>
    <div class="container mt-4">
        <h2>Merci <?= $_GET['name']; ?> pour votre achat ! </h2>
        <hr>
        <p>
            ID de transaction : <?= $_GET['tid']; ?>
        </p>
        <p>
            Achat : <?= $_GET['produit'] ?>
        </p>
        <p>
        Prix total des produits achetés : $<?=number_format($_GET['um'], 2, ',', ' '); ?>
        </p>
        <a href="index.php"><button type="button" class="btn btn-primary">Accueil</button></a>
    </div>
</main>
<?php include_once 'php/inc/footer.inc.php'; ?>