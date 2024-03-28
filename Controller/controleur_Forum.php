<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//require_once "..\Model\modele_Forum.php";
require_once(realpath(dirname(__FILE__) . '\..\Config/config.php'));
require_once(realpath(dirname(__FILE__) . '\..\Model\modele_Forum.php'));

class Controleur_Forum {

    public static function readAll() {
        Modele_Forum::readAll();
    }

    public static function readAll_Admin() {
        Modele_Forum::readAll_Admin();
    }
    public static function add() {
        $forum = new Modele_Forum(); 
        $forum->save();
    }

    public static function supprimer(){ 
        Modele_Forum::supprimer();
    }
}

?>