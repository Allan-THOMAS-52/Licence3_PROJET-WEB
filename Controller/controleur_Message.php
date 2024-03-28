<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    //require_once "../model/modele_Message.php";
    require_once(realpath(dirname(__FILE__) . '\..\Model/modele_Message.php'));
    require_once(realpath(dirname(__FILE__) . '\..\Config/config.php'));

    class Controleur_Message{

        public static function readAll()
        {
            Modele_Message::readAll();
            //require "../view/php/list.php";
        }

        public static function add()
        {
            $message = new Modele_Message();
            $message->save();
        }

           /* $id_forum = $_POST['id_forum'];    
            $utilisateur_id = $_SESSION['utilisateur_id'];
            
            $connexion = mysqli_connect(conf::getHostname(), conf::getLogin(), conf::getPassword(), conf::getDatabaseName());

            if (!$connexion) {
                die("Erreur de connexion à la base de données: " . mysqli_connect_error());
            }


            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $contenu_message = mysqli_real_escape_string($connexion, $_POST['contenu_message']);
                $requete_insertion = "INSERT INTO message (id_forum, id_utilisateur, contenu, date) VALUES ('$id_forum', '$utilisateur_id', '$contenu_message', NOW())";
               
                if (mysqli_query($connexion, $requete_insertion)) {
                    Controleur_Message::readAll();
                    exit();
                } else {
                    echo "Erreur lors de l'ajout du message : " . mysqli_error($connexion);
                }
            }

            mysqli_close($connexion);
        }*/
    }
?>