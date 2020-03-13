<?php 
$msg = [];
if (isset($_POST["submit"])) {
    $numero = htmlentities(trim($_POST["numero"]));
    $nom = htmlentities(trim($_POST["nom"]));
    $prenom = htmlentities(trim($_POST["prenom"]));
    $courriel = htmlentities(trim($_POST["courriel"]));
    $telephone = htmlentities(trim($_POST["telephone"]));
    $mdp = htmlentities(trim($_POST["mdp"]));
    $confirmmdp = htmlentities(trim($_POST["confirmmdp"]));
    $experience = htmlentities(trim($_POST["experience"]));
    $ddn = htmlentities(trim($_POST["ddn"]));
    $poids = htmlentities(trim($_POST["poids"]));

    if($numero == null || $nom == null || $prenom == null || $telephone == null || $experience == null || $poids == null)
        $msg["General"] = "<div class='alert alert-danger'>Veuillez remplir tous les champs</div>";

    if (!filter_var($courriel, FILTER_VALIDATE_EMAIL))
        $msg["Courriel"] = "<div class='alert alert-danger'>Courriel invalide</div>";

    if (strlen($mdp) < 8)
        $msg["MDP"] = "<div class='alert alert-danger'>Le mot de passe doit faire plus de 8 charactères</div>";

    if ($mdp != $confirmmdp)
        $msg["MDP"] = "<div class='alert alert-danger'>Les mots de passe doivent être identiques</div>";

    //Test si l'adresse mail existe deja
    if (count($db->Read("SELECT * FROM membre WHERE Courriel='$courriel'")) > 0)
        $msg["Courriel"] = "<div class='alert alert-danger'>Adresse email déjà existante</div>";

    if($_POST["ddn"] == null)
        $msg["DDN"] = "<div class='alert alert-danger'>Date de naissance invalide</div>";

    if (count($msg) == 0) {
        $membre = new Membre($numero, $nom, $prenom, $telephone, $courriel, md5($mdp), $ddn, $experience, $poids, "", date("Y-m-d H:i:s"), false);
        $_SESSION["membre"] = $membre;

        $membre->Ajouter($db);

        header('location:profil.php');
    }
}
