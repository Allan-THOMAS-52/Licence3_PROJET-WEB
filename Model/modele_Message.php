<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "Model.php";

class Modele_Message {
    private $id_forum;
    private $id_utilisateur;
    private $contenu;

    private $date;


    public function __construct($idf = null, $ifu = null, $c = null, $date = null)
    {
        if (!is_null($idf)) {
            $this->id_forum = $idf;
        }
        if (!is_null($ifu)) {
            $this->id_utilisateur = $ifu;
        }
        if (!is_null($c)) {
            $this->contenu = $c;
        }
        if (!is_null($date)) {
            $this->date_creation = $date;
        }
    }
    
    public function getIdForum()
    {
        return $this->id_forum;
    }
    
    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }
    
    public function getContenu()
    {
        return $this->contenu;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setIdForum($id_forum)
    {
        $this->id_forum = $id_forum;
    }
    
    public function setIdUtilisateur($id_utilisateur)
    {
        $this->id_utilisateur = $id_utilisateur;
    }
    
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }
    
    public function setDate($date_creation)
    {
        $this->date = $date_creation;
    }
    



    public static function readAll()
{
    try {
        if (isset($_GET['id'])) {
            $id_forum = $_GET['id'];

            $connexion = mysqli_connect(conf::getHostname(), conf::getLogin(), conf::getPassword(), conf::getDatabaseName());

            if (!$connexion) {
                die("Erreur de connexion à la base de données: " . mysqli_connect_error());
            }

            $requete_messages = "SELECT m.contenu, u.Prenom, m.date FROM message m JOIN utilisateur u ON m.id_utilisateur = u.id WHERE m.id_forum = ?";
            $statement_messages = mysqli_prepare($connexion, $requete_messages);
            mysqli_stmt_bind_param($statement_messages, "i", $id_forum);
            mysqli_stmt_execute($statement_messages);
            $resultat_messages = mysqli_stmt_get_result($statement_messages);

            if ($resultat_messages && mysqli_num_rows($resultat_messages) > 0) {
                while ($row = mysqli_fetch_assoc($resultat_messages)) {
                    $contenu_message = $row['contenu'];
                    $nom_utilisateur = $row['Prenom'];
                    $date = date('H:i', strtotime($row['date'])); // Format court (heure:minutes)
                    
                    echo "<p>$date <strong>$nom_utilisateur:</strong> $contenu_message</p>";
                }
            } else {
                echo "Aucun message trouvé pour ce forum.";
            }

            mysqli_close($connexion);
        } else {
            echo "ID du forum non spécifié.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

    


public function save()
{
    try {
        if (isset($_GET['id']) && isset($_SESSION['utilisateur_id']) && isset($_GET['contenu_message'])) {
            $id_utilisateur = $_SESSION['utilisateur_id'];
            $id_forum = $_GET['id'];
            $contenu = $_GET['contenu_message'];

            $sql = "INSERT INTO Message (id_forum, id_utilisateur, contenu, date) VALUES (:id_forum, :id_utilisateur, :contenu, NOW())";
            $requete = Model::$pdo->prepare($sql);
            
            $requete->bindParam(':id_forum', $id_forum, PDO::PARAM_INT);
            $requete->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            $requete->bindParam(':contenu', $contenu, PDO::PARAM_STR);
            
            if ($requete->execute()) {
                header("Location: ../View/php/page_forum.php?id=" . $id_forum);
                exit();
            } else {
                echo "Erreur lors de l'exécution de la requête d'insertion dans la base de données.";
                return false;
            }
        } else {
            echo "ID du forum, ID utilisateur ou contenu du message non spécifié.";
            return false;
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}




    

}
?>

