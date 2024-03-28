<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "controleur_Utilisateur.php";
require_once "controleur_Forum.php";
require_once "controleur_Message.php";
require_once "controleur_Quiz.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$action2 = isset($_POST['action']) ? $_POST['action'] : 'index';
switch ($action) {
    case 'index':
        Controleur_Utilisateur::readAll();
        break;
    case 'add_message':
        Controleur_Message::add();
        break;
    case 'supprimer_forum':
        Controleur_Forum::supprimer();
        break;
    case 'supprimer_quiz':
        Controleur_Quiz::supprimer();
        break;  
    default:
        header("HTTP/1.0 404 Not Found");
        echo "Page not found";
        break;
}


switch ($action2) {
    case 'add':
        Controleur_Utilisateur::add();
        break;
    case 'add_question':
        Controleur_Quiz::addQCM();
        break;
    case 'connexion':
        $_SESSION['nom_utilisateur'] = $nom_utilisateur; 
        Controleur_Utilisateur::connexion();
        break;
    case 'deconnexion':
        Controleur_Utilisateur::deconnexion();
        break;
    case 'add_forum':
        Controleur_Forum::add();
        break;
    case 'add_quiz':
        Controleur_Quiz::add();
        break;
    case 'save_quiz':
        Controleur_Quiz::save();
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo "Page not found";
        break;
}

?>