<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$id_quiz = isset($_GET['id']) ? $_GET['id'] : null;
$_SESSION['id_quiz'] = $id_quiz; 
require_once(realpath(dirname(__FILE__) . '\..\..\Controller/controleur_Quiz.php'));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
</head>
<body>

<?php
Controleur_Quiz::readQuiz();
?>




</body>
</html>
