<?php include_once 'php/class/all.class.php'; ?>
<?php
session_start();
require_once('lib/vendor/autoload.php');

\Stripe\Stripe::setApiKey('sk_test_BQokikJOvBiI2HlWgH4olfQ2');

// Sanitize POST ARRAY
$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
// Référence : https://www.php.net/manual/fr/filter.filters.sanitize.php

$membre = $_SESSION["membre"];

$nom = $membre->nom;
$prenom = $membre->prenom;
$email = $membre->courriel;
$token = $POST['stripeToken'];
$valeurCourses = $POST['prix'];
$descriptionProduit = "Participation à une course";


// Création acheteur pour Stripe
$customer = \Stripe\Customer::create([
    'email' => $email,
    'source' => $token
]);


// Charger "l'acheteur"
$charge = \Stripe\Charge::create([
    'amount' => $valeurCourses,
    'currency' => 'cad',
    'description' => $descriptionProduit,
    'customer' => $customer->id,
]);

$charge->billing_details['email'] = $email; // Ajout information email
$charge->billing_details['name'] = $prenom . ' ' . $nom; // Ajout information Nom

//Met à jour le statut des course de non commandées à commandées en indiquant la date de commande
$db->Execute("UPDATE panier SET estCommandee = true, dateCommandee = NOW() WHERE numeroMembre='$membre->numero'");

// Renvoyer vers success
header('location: success.php?etat=' . $charge->status . '&tid=' . $charge->id . '&produit=' . $charge->description . '&um=' . $charge->amount . '&name=' . $charge->billing_details['name']);
