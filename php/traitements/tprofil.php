<?php
$msg = [];
if (isset($_POST["modifInfos"])) {
    $nom = htmlentities($_POST["nom"]);
    $prenom = htmlentities($_POST["prenom"]);
    $tel = htmlentities(trim($_POST["tel"]));
    $expe = htmlentities(trim($_POST["experience"]));
    $poids = htmlentities(trim($_POST["poids"]));

    if ($nom == null || $nom == "" || $prenom == null || $prenom == "" || $tel == null || $tel == "" || $expe == "" || $poids == "")
        $msg["Infos"] = "<div class='alert alert-danger' role='alert'>Veuillez remplir tous les champs</div>";

    if ($expe < 0 || $poids < 0)
        $msg["Infos"] = "<div class='alert alert-danger' role='alert'>Valeurs négatives interdites</div>";

    if (strlen($expe) > 3 || strlen($poids) > 3)
        $msg["Infos"] = "<div class='alert alert-danger' role='alert'>Veuillez entrer un nombre d'années d'expérience et un poids convenable</div>";

    if (!is_numeric($expe) || !is_numeric($poids))
        $msg["Infos"] = "<div class='alert alert-danger' role='alert'>Veuillez entrer des nombres</div>";

    if (!isset($msg["Infos"])) {
        $rqt = $db->co->prepare("UPDATE membre SET Nom=:nom, Prenom=:prenom, Telephone=:tel, Experience=:expe, Poids=:poids WHERE Numero ='{$_SESSION["membre"]->numero}'");
        $rqt->bindValue(':nom', $nom);
        $rqt->bindValue(':prenom', $prenom);
        $rqt->bindValue(':tel', $tel);
        $rqt->bindValue(':expe', $expe);
        $rqt->bindValue(':poids', $poids);
        $rqt->execute();

        $_SESSION["membre"]->nom = $nom;
        $_SESSION["membre"]->prenom = $prenom;
        $_SESSION["membre"]->telephone = $tel;
        $_SESSION["membre"]->experience = $expe;
        $_SESSION["membre"]->poids = $poids;

        $msg["Infos"] = "<div class='alert alert-success' role='alert'>Le profil a bien été modifié</div>";
    }
}

if (isset($_POST["modifPhoto"])) {
    if (isset($_FILES['file'])) {
        $maxSize = 2097152;
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'ico');

        if ($_FILES['file']['size'] <= $maxSize) {
            $extensionUpload = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));
            if (in_array($extensionUpload, $allowTypes)) {
                $path = "img/Profils/" . $_SESSION["membre"]->numero . "." . $extensionUpload;

                $files = glob("img/Profils/*" . $_SESSION["membre"]->numero . ".*"); //tester si l'utilisateur à déjà une image enregistrée
                //Supprimer l'image existante car si on le fait pas et que l'utilisateur upload une nouvelle image avec une extension differennte, l'ancien fichier ne sera pas remplacé
                if (count($files) > 0)
                    unlink($files[0]);

                $res = move_uploaded_file($_FILES['file']['tmp_name'], $path);
                if ($res) {
                    $nomImage = $_SESSION["membre"]->numero . '.' . $extensionUpload;

                    $insert = $db->co->prepare("UPDATE membre SET Photo = :nomPhoto WHERE Numero='{$_SESSION["membre"]->numero}'");
                    $insert->bindvalue(':nomPhoto', $nomImage);
                    $insert->execute();

                    $_SESSION["membre"]->photo = $nomImage;

                    $msg["Photo"] = "<div class='alert alert-success' role='alert'>La photo de profil a bien été modifiée</div>";
                } else
                    $msg["Photo"] = "<div class='alert alert-danger' role='alert'>Les mot de passes ne sont pas identiques</div>";
            } else
                $msg["Photo"] = "<div class='alert alert-danger' role='alert'>Format non compatible<br>Formats acceptés : jpg, png, jpeg, gif, ico</div>";
        } else
            $msg["Photo"] = "<div class='alert alert-danger' role='alert'>Fichier trop lourd</div>";
    }
}

//Formulaire de modification du courriel
if (isset($_POST["modifCourriel"])) {
    $courriel = htmlentities(trim($_POST["courriel"]));

    if ($courriel == $_SESSION["membre"]->courriel)
        $msg["Courriel"] = "<div class='alert alert-danger' role='alert'>Adresse mail identique à l'ancienne</div>";

    if ($courriel == null || $courriel == "" || !filter_var($courriel, FILTER_VALIDATE_EMAIL))
        $msg["Courriel"] = "<div class='alert alert-danger' role='alert'>Adresse mail invalide</div>";

    if (!isset($msg["Courriel"])) {
        try {
            $modif = $db->co->prepare("UPDATE membre SET Courriel = :courriel WHERE Numero='{$_SESSION["membre"]->numero}'");
            $modif->bindValue(":courriel", $courriel);
            $modif->execute();
            $msg["Courriel"] = "<div class='alert alert-success' role='alert'>La modification de l'adresse mail a réussi</div>";

            //Met à jour la variable session
            $_SESSION["membre"]->courriel = $courriel;
        } catch (PDOException $ex) {
            $msg["Courriel"] = "<div class='alert alert-danger' role='alert'>La modification de l'adresse mail a échoué</div>";
        }
    }
}

//Formulaire de modification du mdp
if (isset($_POST["modifMdp"])) {
    $ancien = htmlentities(trim($_POST["ancienmdp"]));
    $nouveau = htmlentities(trim($_POST["nouveaumdp"]));
    $nouveau2 = htmlentities(trim($_POST["nouveaumdp2"]));

    $mdpEnregistre = $db->ReadOne("SELECT MDP FROM membre WHERE Numero='{$_SESSION["membre"]->numero}'")["MDP"];

    if ($mdpEnregistre == md5($ancien)) {
        if ($nouveau == $nouveau2) {
            try {
                $modif = $db->co->prepare("UPDATE membre SET MDP = :mdp WHERE Numero='{$_SESSION["membre"]->numero}'");
                $modif->bindValue(':mdp', md5($nouveau));
                $modif->execute();
                $msg["MDP"] = "<div class='alert alert-success' role='alert'>Le mot de passe a bien été modifié</div>";

                //Met à jour la variable session
                $_SESSION["membre"]->mdp = md5($nouveau);
            } catch (PDOException $ex) {
                $msg["MDP"] = "<div class='alert alert-danger' role='alert'>La modification du mot de passe a échoué</div>";
            }
        } else
            $msg["MDP"] = "<div class='alert alert-danger' role='alert'>Les mot de passes ne sont pas identiques</div>";
    } else
        $msg["MDP"] = "<div class='alert alert-danger' role='alert'>L'ancien mot de passe est incorrect</div>";

    unset($_POST["modifMdp"]);
}

if (isset($_POST["supprimerCompte"])) {
    $db->Execute("DELETE FROM membre WHERE Numero = '{$_SESSION["membre"]->numero}'");
    //Supprimer la photo associée au compte
    unlink("img/Profils/" . $_SESSION["membre"]->photo);
    header('location:deconnexion.php');
}

$membre = $_SESSION["membre"];

$avenir = $db->Read("SELECT * FROM panier INNER JOIN course ON (panier.numeroCourse = course.Numero) WHERE Visible = true AND estCommandee = true AND numeroMembre = '$membre->numero' AND Date > CURRENT_TIMESTAMP ORDER BY Date ASC");
$effectuees = $db->Read("SELECT * FROM panier INNER JOIN course ON (panier.numeroCourse = course.Numero) WHERE estCommandee = true AND numeroMembre = '$membre->numero' AND Date < CURRENT_TIMESTAMP ORDER BY Date DESC");
