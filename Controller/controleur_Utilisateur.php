<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "../Model/modele_Utilisateur.php";
require_once "../Config/config.php";
#[\AllowDynamicProperties]
class Controleur_Utilisateur{

    public static function readAll()
    {
        $liste = Modele_Utilisateur::readAll();
    }

    public static function add()
    {
        Modele_Utilisateur::add();
    }

    public static function deconnexion()
    {
        Modele_Utilisateur::deconnexion();
    }


    public static function connexion(){
        Modele_Utilisateur::connexion();        
    }
    
}
?>
