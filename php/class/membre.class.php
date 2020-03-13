<?php
class Membre
{
    private $numero;
    private $nom;
    private $prenom;
    private $telephone;
    private $courriel;
    private $mdp;
    private $ddn;
    private $experience;
    private $poids;
    private $photo;
    private $inscription;
    private $admin;

    public function __construct($numero, $nom, $prenom, $telephone, $courriel, $mdp, $ddn, $experience, $poids, $photo, $inscription, $admin)
    {
        $this->numero = $numero;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->courriel = $courriel;
        $this->mdp = $mdp;
        $this->ddn = $ddn;
        $this->experience = $experience;
        $this->poids = $poids;
        $this->photo = $photo;
        $this->inscription = $inscription;
        $this->admin = $admin;
    }

    public function __get($value)
    {
        return $this->$value;
    }

    public function __set($attribut, $value)
    {
        $this->$attribut = $value;
    }

    public function Ajouter($db)
    {
        $db->Execute("INSERT INTO membre(Numero, Nom, Prenom, Telephone, Courriel, MDP, DDN, Experience, Poids, Photo) 
        VALUES('$this->numero','$this->nom','$this->prenom','$this->telephone','$this->courriel','$this->mdp','$this->ddn',$this->experience,$this->poids,'$this->photo')");
    }

    public function Modifier($db, $numero, $nom, $prenom, $telephone, $courriel, $mdp, $ddn, $experience, $poids, $photo)
    {
        $db->Execute("UPDATE membre SET Numero = '$this->numero', Nom = '$this->nom', Prenom = '$this->prenom', Telephone = '$this->telephone', Courriel = '$this->courriel', MotDePasse = '$this->motdepasse', DDN = '$this->ddn', Experience = $this->experience, Poids = $this->poids, Photo = '$this->photo' WHERE Numero = '$this->numero'");

        $this->numero = $numero;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->courriel = $courriel;
        $this->mdp = $mdp;
        $this->ddn = $ddn;
        $this->experience = $experience;
        $this->poids = $poids;
        $this->photo = $photo;
    }

    public function Supprimer($db)
    {
        $db->Execute("DELETE FROM membre WHERE numero = '$this->numero'");
    }

    public static function GetMembreByCourriel($db, $courriel)
    {
        $m = $db->ReadOne("SELECT * FROM membre WHERE Courriel = '$courriel'");

        if ($m == null)
            return null;

        return new Membre($m["Numero"], $m["Nom"], $m["Prenom"], $m["Telephone"], $m["Courriel"], $m["MDP"], $m["DDN"], $m["Experience"], $m["Poids"], $m["Photo"], $m["Inscription"], $m["EstAdmin"]);
    }

    public function AjouterCoursePanier($db, $numeroCourse)
    {
        $msg = [];
        $msg["Success"] = "<div class='alert alert-success' role='alert'>Course ajoutée au panier</div>";

        if (count($db->Read("SELECT * FROM panier WHERE numeroMembre='{$_SESSION['membre']->numero}' AND numeroCourse='$numeroCourse' AND estCommandee = false")) > 0)
            $msg["Fail"] = "<div class='alert alert-danger' role='alert'>Cette course est deja dans votre panier</div>";

        if (count($db->Read("SELECT * FROM panier WHERE numeroMembre='{$_SESSION['membre']->numero}' AND numeroCourse='$numeroCourse' AND estCommandee = true")) > 0)
            $msg["Fail"] = "<div class='alert alert-danger' role='alert'>Vous avez deja commandé cette course</div>";

        if(!isset($msg["Fail"])) $db->Execute("INSERT INTO panier(numeroMembre, numeroCourse, estCommandee) VALUES('{$_SESSION['membre']->numero}', '$numeroCourse', 0)");

        return $msg;
    }
    public function RetirerCoursePanier($db, $numeroCourse)
    {
        $db->Execute("DELETE FROM panier WHERE numeroCourse=$numeroCourse AND numeroMembre={$_SESSION['membre']->numero} AND estCommandee = false");
    }
}
