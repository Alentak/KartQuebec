<?php
class Database
{
    private $server;
    private $database;
    private $username;
    private $password;
    private $co;
    
    public function __construct($server, $database, $username, $password) {
        $this->server = $server;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        try {
            $this->co = new PDO("mysql:host=$this->server;dbname=$this->database", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function __get($value)
    {
        return $this->$value;
    }

    function Read($rqt) : array
    {
        return $this->co->query($rqt)->fetchAll();
    }

    function ReadOne(string $rqt) : array
    {
        $resultat = [];

        foreach ($this->co->query($rqt) as $r) {
            $resultat = $r;
        }

        return $resultat;
    }

    function Execute($rqt)
    {
        $this->co->query($rqt);
    }
}
?>