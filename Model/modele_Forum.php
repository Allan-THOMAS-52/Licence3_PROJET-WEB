<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "Model.php";
#[\AllowDynamicProperties]
class Modele_Forum {
    private $titre;

    public function __construct($t = null)
    {
        
        if(!is_null($t)){
            $this->titre = $t;
        }
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($t) {
        $this->titre = $t;
    }



    public static function readAll()
    {
        try {
            $sql = "SELECT * FROM Forum";
            $conn = Model::$pdo;
            $rep = $conn->query($sql);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'Modele_Forum');
            $forums = [];
            while($forum = $rep->fetch()){
                echo'<a href="page_forum.php?id='.$forum->id_forum.'">'.$forum->titre.'</a><br>';
                $forums[] = $forum;
            }
            return $forums;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function supprimer()
    {
        try
        {
            if (isset($_GET['id'])) {
                $id_forum = $_GET['id'];
                $conn = Model::$pdo;
                $sql = "DELETE FROM Forum WHERE id_forum = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt->execute([$id_forum])) {
                    header("Location: ../View/php/page_accueil.php");
                    exit(); 
                } else {
                    echo "Erreur lors de l'exécution de la requête de suppression dans la base de données.";
                    return false;
                }
            } else {
                echo "ID du forum non trouvé dans la requête GET.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
    
    public static function readAll_Admin()
{
    try {
        $sql = "SELECT * FROM Forum";
        $conn = Model::$pdo;
        $rep = $conn->query($sql);
        $rep->setFetchMode(PDO::FETCH_CLASS, 'Modele_Forum');
        $forums = [];
        while($forum = $rep->fetch()){
            echo '<form action="../../Controller/routeur.php" method="get">
                      <a href="page_forum.php?id='.$forum->id_forum.'">'.$forum->titre.'</a>
                      <input type="hidden" name="id" value="'.$forum->id_forum.'"> 
                      <button type="submit" name="action" value="supprimer_forum">Supprimer</button>
                  </form>';
            $forums[] = $forum;
        }
        
        echo '
        <form action="../../Controller/routeur.php" method="post">
            <input type="text" name="titre" placeholder="Titre">
            <button type="submit" name="action" value="add_forum">
                <a>Ajouter</a>
            </button>
        </form>';
        
        return $forums;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

    
    



    public function save()
    {
        try {
            if(isset($_POST['titre'])) {
                $titre = $_POST['titre'];
                $sql = "INSERT INTO Forum (titre) VALUES (?)";
                $requete = Model::$pdo->prepare($sql);
                if ($requete->execute([$titre])) {
                    header("Location: ../View/php/page_accueil.php");
                } else {
                    echo "Erreur lors de l'exécution de la requête d'insertion dans la base de données.";
                    return false;
                }
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }



}
?>