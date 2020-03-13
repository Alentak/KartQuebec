<?php
class Course
{
    private $numero;
    private $description;
    private $date;
    private $sensCourse;
    private $nbTours;
    private $directeur;
    private $responsable;
    private $categorieKart;
    private $prix;
    private $remarques;
    private $visible;

    public function __construct($numero, $description, $date, $sensCourse, $nbTours, $directeur, $responsable, $categorieKart, $prix, $remarques, $visible)
    {
        $this->numero = $numero;
        $this->description = $description;
        $this->date = $date;
        $this->sensCourse = $sensCourse;
        $this->nbTours = $nbTours;
        $this->directeur = $directeur;
        $this->responsable = $responsable;
        $this->categorieKart = $categorieKart;
        $this->prix = $prix;
        $this->remarques = $remarques;
        $this->visible = $visible;
    }

    public function __get($value)
    {
        return $this->$value;
    }

    public static function Ajouter($db, $numero, $description, $date, $sensCourse, $nbTours, $directeur, $responsable, $categorieKart, $prix, $remarques, $visible)
    {
        $db->Execute("INSERT INTO course(Numero, Description, Date, SensCourse, NbTours, DirecteurCourse, ResponsablePiste, CategorieKart, Prix, Remarques, Visible) VALUES(\"$numero\", \"$description\", \"$date\", \"$sensCourse\", $nbTours, \"$directeur\", \"$responsable\", \"$categorieKart\", $prix, \"$remarques\", $visible)");
    }

    public static function Modifier($db, $numero, $description, $date, $sensCourse, $nbTours, $directeur, $responsable, $categorieKart, $prix, $remarques, $visible)
    {
        $db->Execute("UPDATE course SET Description = \"$description\", Date = \"$date\", SensCourse = \"$sensCourse\", NbTours = $nbTours, DirecteurCourse = \"$directeur\", ResponsablePiste = \"$responsable\", CategorieKart = \"$categorieKart\", Prix = $prix, Remarques = \"$remarques\", Visible = $visible WHERE Numero = \"$numero\"");
    }

    public static function Supprimer($db, $numero)
    {
        //On ne supprime pas une course mais on la rend invisible car on veut qu'elle s'affiche quand meme dans l'historique des personnes qui y ont participé
        $rqt = $db->co->prepare("UPDATE course SET Visible = false WHERE Numero =:numero");
        $rqt->bindValue(':numero', $numero);
        $rqt->execute();
    }

    public static function GetCourses($db)
    {
        return $db->Read("SELECT * FROM course WHERE Visible = true AND Date > CURRENT_TIMESTAMP ORDER BY Numero");
    }

    public static function GetCourseByNumero($db, $numero)
    {
        $c = $db->ReadOne("SELECT * FROM course WHERE Numero='$numero'");
        return new Course($c["Numero"], $c["Description"], $c["Date"], $c["SensCourse"], $c["NbTours"], $c["DirecteurCourse"], $c["ResponsablePiste"], $c["CategorieKart"], $c["Prix"], $c["Remarques"], $c["Visible"]);
    }
}
?>