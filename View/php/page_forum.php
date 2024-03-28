<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$id_forum = isset($_GET['id']) ? $_GET['id'] : null;
$_SESSION['id_forum'] = $id_forum; 
require_once(realpath(dirname(__FILE__) . '\..\..\Controller/controleur_Message.php'));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Rafraîchie la page toutes le 5 secs mais ducoup cela efface le message entrain
    d'être entré.
    Je voulais que les messages des autres 'affichent sans nécessairement avoir le 
    besoin de refresh la page.

    Si vous avez des idées?

   
    <meta http-equiv="refresh" content="5"> -->
    <title>Forum</title>
</head>
<body>

<?php
Controleur_Message::readAll();
?>

<!-- Formulaire pour ajouter un nouveau message -->
<form action="../../Controller/routeur.php" method="get">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <label for="contenu_message">Votre message:</label><br>
    <textarea name="contenu_message" id="contenu_message" rows="1" cols="50"></textarea><br>
    <input type="hidden" name="action" value="add_message">
    <input type="submit" value="Envoyer">
</form>




</body>
</html>
