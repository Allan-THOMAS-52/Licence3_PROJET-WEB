<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "Model.php";
#[\AllowDynamicProperties]
class Modele_Utilisateur {
    private $nom;
    private $prenom;
    private $numero;
    private $password; 
    private $type;
	private $theme;

    public function __construct($name = null, $p = null, $n = null, $psswd = null, $t = null, $th = null){
        if (!is_null($name)) {
            $this->nom = $name;
        }
        if (!is_null($p)) {
            $this->prenom = $p;
        }
        if (!is_null($n)) {
            $this->numero = $n;
        }
        if(!is_null($psswd)){
            $this->password = $psswd;
        }
        if(!is_null($t)){
            $this->type = $t;
        }
		if(!is_null($th)){
            $this->theme = $th;
        }
    }

    // Getters
    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getType() {
        return $this->type;
    }

    // Setters
    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setType($type) {
        $this->type = $type;
    }


    public static function deconnexion(){
        session_start();
        $_SESSION = array();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/'); 
        header("Location: ../View/php/index.php");
        exit();
    }
	
    public static function readAll(){
        try {
            $sql = "SELECT * FROM Utilisateur";
            $conn = Model::$pdo;
            $rep = $conn->query($sql);
            $rep->setFetchMode(PDO::FETCH_CLASS, 'modele_Utilisateur');
            return $rep->fetchAll();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

  public static function add()
    {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $numero = $_POST['numero'];
        $mdp = $_POST['password'];
        $type = $_POST['type'];

        $utilisateur = new Modele_Utilisateur($nom, $prenom, $numero, $mdp, $type);

        $requete = "INSERT INTO utilisateur (nom, prenom, numero, mdp, type) VALUES (?, ?, ?, ?, ?)";
        
        $connexion = mysqli_connect(conf::getHostname(), conf::getLogin(), conf::getPassword(), conf::getDatabaseName());

        if (!$connexion) {
            die("Erreur de connexion à la base de données: " . mysqli_connect_error());
        }

        $statement = mysqli_prepare($connexion, $requete);

        if ($statement) {
            mysqli_stmt_bind_param($statement, "sssss", $nom, $prenom, $numero, $mdp, $type);
            mysqli_stmt_execute($statement);

            if (mysqli_stmt_affected_rows($statement) > 0) {
                $_SESSION['succes'] = "Compte créé avec succès.";
                header("Location: ../View/php/page_de_connexion.php"); 
            } else {
                $_SESSION['erreur_connexion'] = "Erreur lors de la création du compte.";
                header("Location: ../View/php/creation_compte.php"); 
            }

            mysqli_stmt_close($statement);
        } else {
            $_SESSION['erreur_connexion'] = "Erreur lors de la préparation de la requête SQL.";
            header("Location: ../View/php/creation_compte.php"); 
        }
        mysqli_close($connexion);
    }
	
    public function save(){
        try {
            $sql = "INSERT INTO utilisateur (nom, prenom, numero, mdp, type, theme) VALUES (:nom, :prenom, :numero, :mdp, :type, :theme)";
            $requete = Model::$pdo->prepare($sql);
            $requete->bindParam(':nom', $this->nom);
            $requete->bindParam(':prenom', $this->prenom);
            $requete->bindParam(':numero', $this->numero);
            $requete->bindParam(':mdp', $this->password);
            $requete->bindParam(':type', $this->type);
            $requete->bindParam(':theme', $this->theme);
            
            if ($requete->execute()) {
                return Model::$pdo->lastInsertId();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }   

    public static function connexion(){
        $nom_utilisateur = $_POST['nom'];
        $prenom_utilisateur = $_POST['prenom'];
        $mot_de_passe = $_POST['password'];
            
        $connexion = mysqli_connect(conf::getHostname(), conf::getLogin(), conf::getPassword(), conf::getDatabaseName());

        if (!$connexion) {
            die("La connexion à la base de données a échoué : " . mysqli_connect_error());
        }

        $requete = "SELECT MDP, type, id, theme FROM utilisateur WHERE NOM = '$nom_utilisateur' AND PRENOM = '$prenom_utilisateur'";
        $resultat = mysqli_query($connexion, $requete);
		
        if (mysqli_num_rows($resultat) == 1) {
            $ligne = mysqli_fetch_assoc($resultat);
            $hash = $ligne['MDP'];
            $role = $ligne['type'];
			$theme = $ligne['theme'];
                
            if ($mot_de_passe == $hash) {
                $_SESSION['utilisateur_id'] = $ligne['id']; 
                $_SESSION['nom_utilisateur'] = $nom_utilisateur; 
				$_SESSION['prenom_utilisateur'] = $prenom_utilisateur;
                $_SESSION['type_utilisateur'] = $role;
				$_SESSION['theme_utilisateur'] = $theme;
				
                if ($role == "Etudiant") {
                    header("Location: ../View/php/page_accueil.php"); 
                } else if ($role == "Professeur") {
                    header("Location: ../View/php/page_accueil.php");
                }
                exit();
            } else {
                $_SESSION['erreur_connexion'] = "Mot de passe incorrect.";
                header("Location: ../View/php/page_de_connexion.php");
                    
            }
        } else {
            $_SESSION['erreur_connexion'] = "Nom d'utilisateur incorrect.";
            header("Location: ../View/php/page_de_connexion.php"); 
                
        }

        mysqli_close($connexion);
    }
	/*
	public static function updateThemeUser(){
		$theme = $_POST['theme'];
		$userID = $_POST['idUser'];	
	
		try {
			$sql = "UPDATE `utilisateur` SET `theme` = :theme WHERE `utilisateur`.`id` = :id;";
			$requete = Model::$pdo->prepare($sql);
			$requete->bindParam(':theme', $theme);
			$requete->bindParam(':id', userID );
			
			return ($requete->execute()) ? true : false ;
			
        }catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }		
	}
	*/
	
}
?>
