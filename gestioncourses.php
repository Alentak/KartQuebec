<?php include_once 'php/class/all.class.php'; ?>
<?php include_once 'php/inc/head.inc.php'; ?>
<title>Kart'Québéc - Gestion des courses</title>
<?php include_once 'php/inc/header.inc.php'; ?>
<?php include_once 'php/traitements/tgestioncourses.php'; ?>

<main>
    <h1>Gestion des courses</h1>
    <div class="row">
        <div class="col-12">
            <?= isset($msg["add"]) ? $msg["add"] : "" ?>
            <h3>Ajouter une course</h3>
            <form method="POST">
                <div class="row">
                    <div class="col-3">
                        <label for="addNumero">Numéro</label>
                        <input type="text" class="form-control" name="addNumero" required>
                    </div>
                    <div class="col-4">
                        <label for="addDescription">Description</label>
                        <input type="text" class="form-control" name="addDescription" required>
                    </div>
                    <div class="col-3">
                        <label for="addDate">Date</label>
                        <input type="date" class="form-control" name="addDate" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <label for="addSens">Sens de la course</label>
                        <input type="text" class="form-control" name="addSens" required>
                    </div>
                    <div class="col-2">
                        <label for="addNbTours">Nombre de tours</label>
                        <input type="number" class="form-control" name="addNbTours" value="1" min="1" max="99" required>
                    </div>
                    <div class="col-3">
                        <label for="addDirecteur">Directeur de course</label>
                        <input type="text" class="form-control" name="addDirecteur" required>
                    </div>
                    <div class="col-3">
                        <label for="addResponsable">Responsable de piste</label>
                        <input type="text" class="form-control" name="addResponsable" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <label for="addCategorie">Catégorie kart</label>
                        <input type="text" class="form-control" name="addCategorie" required>
                    </div>
                    <div class="col-2">
                        <label for="addPrix">Prix</label>
                        <input type="number" class="form-control" name="addPrix" value="1" min="1" required>
                    </div>
                    <div class="col-4">
                        <label for="addRemarques">Remarques</label>
                        <input type="text" class="form-control" name="addRemarques" required>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" name="addSubmit" value="Ajouter">
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <?= isset($msg["modif"]) ? $msg["modif"] : "" ?>
            <h3>Modifier une course</h3>
            <form method="POST">
                <div class="row">
                    <div class="col-4">
                        <select class="form-control mb-3" name="modifCourse" required>
                            <option value="" selected hidden>Choisir une course</option>
                            <?php foreach ($courses as $c) : ?>
                                <option value=<?= $c["Numero"] ?>><?= $c["Numero"]." - ".$c["Description"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-2">
                        <input type="submit" class="btn btn-primary" name="modifChoixSubmit" value="Modifier">
                    </div>
                </div>
            </form>
            <?php if (isset($_POST["modifChoixSubmit"])) : ?>
                <form method="POST">
                    <div class="row">
                        <div class="col-3">
                            <label for="modifNumero">Numéro</label>
                            <input type="text" class="form-control" name="modifNumero" value="<?= $choix->numero ?>" required>
                        </div>
                        <div class="col-4">
                            <label for="modifDescription">Description</label>
                            <input type="text" class="form-control" name="modifDescription" value="<?= $choix->description ?>" required>
                        </div>
                        <div class="col-3">
                            <label for="modifDate">Date</label>
                            <input type="date" class="form-control" name="modifDate" value="<?= date('Y-m-d', strtotime($choix->date)) ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="modifSens">Sens de la course</label>
                            <input type="text" class="form-control" name="modifSens" value="<?= $choix->sensCourse ?>" required>
                        </div>
                        <div class="col-2">
                            <label for="modifNbTours">Nombre de tours</label>
                            <input type="number" class="form-control" name="modifNbTours" value="<?= $choix->nbTours ?>" min="1" max="99" required>
                        </div>
                        <div class="col-3">
                            <label for="modifDirecteur">Directeur de course</label>
                            <input type="text" class="form-control" name="modifDirecteur" value="<?= $choix->directeur ?>" required>
                        </div>
                        <div class="col-3">
                            <label for="modifResponsable">Responsable de piste</label>
                            <input type="text" class="form-control" name="modifResponsable" value="<?= $choix->responsable ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <label for="modifCategorie">Catégorie kart</label>
                            <input type="text" class="form-control" name="modifCategorie" value="<?= $choix->categorieKart ?>" required>
                        </div>
                        <div class="col-2">
                            <label for="modifPrix">Prix</label>
                            <input type="number" class="form-control" name="modifPrix" value="<?= $choix->prix ?>" min="1" required>
                        </div>
                        <div class="col-4">
                            <label for="modifRemarques">Remarques</label>
                            <input type="text" class="form-control" name="modifRemarques" value="<?= $choix->remarques ?>" required>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" name="modifSubmit" value="Modifier">
                </form>
            <?php endif; ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <?= isset($msg["Delete"]) ? $msg["Delete"] : "" ?>
            <h3>Supprimer une course</h3>
            <form method="POST">
                <div class="row">
                    <div class="col-4">
                        <select class="form-control mb-3" name="deleteCourse" required>
                            <option value="" selected hidden>Choisir une course</option>
                            <?php foreach ($courses as $c) : ?>
                                <option value=<?= $c["Numero"] ?>><?= $c["Description"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" name="delSubmit" value="Supprimer">
            </form>
        </div>
    </div>
</main>
<?php include_once 'php/inc/footer.inc.php'; ?>