<?php
$courses = Course::GetCourses($db);

$msg = [];

if (isset($_POST["addSubmit"])) {
    $numero = htmlentities($_POST["addNumero"]);
    $description = htmlentities($_POST["addDescription"]);
    $date = htmlentities($_POST["addDate"]);
    $sensCourse = htmlentities($_POST["addSens"]);
    $nbTours = htmlentities($_POST["addNbTours"]);
    $directeur = htmlentities($_POST["addDirecteur"]);
    $responsable = htmlentities($_POST["addResponsable"]);
    $categorieKart = htmlentities($_POST["addCategorie"]);
    $prix = htmlentities($_POST["addPrix"]);
    $remarques = htmlentities($_POST["addRemarques"]);

    if ($numero == "" || $description == "" || $date == null || $sensCourse == "" || $nbTours == "" || $nbTours < 1 || $directeur == "" || $responsable == "" || $categorieKart == "" || $prix == "" || $prix < 0 || $remarques == "")
        $msg["add"] = "<div class='alert alert-danger' role='alert'>Veuillez remplir les champs correctement</div>";

    if (!isset($msg["add"])) {
        try {
            Course::Ajouter($db, $numero, $description, $date, $sensCourse, $nbTours, $directeur, $responsable, $categorieKart, $prix, $remarques, true);
            $msg["add"] = "<div class='alert alert-success' role='alert'>Course ajoutée</div>";
        } catch (PDOException $ex) {
            $msg["add"] = "<div class='alert alert-danger' role='alert'>Une course avec ce numéro existe déjà</div>";
        }
    }
}

if (isset($_POST["modifChoixSubmit"])) {
    try {
        $choix = Course::GetCourseByNumero($db, $_POST["modifCourse"]);
        $_SESSION["modifCourse"] = $choix->numero;
    } catch (PDOException $ex) {
        $msg["Choix"] = "<div class='alert alert-danger' role='alert'>La course choisie n'existe pas</div>";
    }
}

if (isset($_POST["modifSubmit"])) {
    $description = htmlentities($_POST["modifDescription"]);
    $date = htmlentities($_POST["modifDate"]);
    $sensCourse = htmlentities($_POST["modifSens"]);
    $nbTours = htmlentities($_POST["modifNbTours"]);
    $directeur = htmlentities($_POST["modifDirecteur"]);
    $responsable = htmlentities($_POST["modifResponsable"]);
    $categorieKart = htmlentities($_POST["modifCategorie"]);
    $prix = htmlentities($_POST["modifPrix"]);
    $remarques = htmlentities($_POST["modifRemarques"]);

    if ($description == "" || $date == null || $sensCourse == "" || $nbTours == "" || $nbTours < 1 || $directeur == "" || $responsable == "" || $categorieKart == "" || $prix == "" || $prix < 0 || $remarques == "")
        $msg["modif"] = "<div class='alert alert-danger' role='alert'>Veuillez remplir les champs correctement</div>";

    if (!isset($msg["modif"])) {
        Course::Modifier($db, $_SESSION["modifCourse"], $description, $date, $sensCourse, $nbTours, $directeur, $responsable, $categorieKart, $prix, $remarques, true);
        $msg["modif"] = "<div class='alert alert-success' role='alert'>Course modifiée</div>";
    }
}

if (isset($_POST["delSubmit"])) {
    $numeroCourse = htmlentities($_POST["deleteCourse"]);

    if ($numeroCourse == null || $numeroCourse == "")
        $msg["Delete"] = "<div class='alert alert-danger' role='alert'>Aucune course choisie</div>";

    if (!isset($msg["Delete"])) {
        try {
            Course::Supprimer($db, $numeroCourse);
            $msg["Delete"] = "<div class='alert alert-success' role='alert'>La course a bien été supprimée</div>";
        } catch (PDOException $ex) {
            $msg["Delete"] = "<div class='alert alert-danger' role='alert'>Cette course est inconnue</div>";
        }
    }
}
