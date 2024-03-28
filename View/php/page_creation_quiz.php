<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$id_forum = isset($_GET['id']) ? $_GET['id'] : null;
$_SESSION['id_forum'] = $id_forum; 
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

    <form id="qcmForm" action="../../Controller/routeur.php" method="post">
        <label for="question1">Question 1 :</label><br>
        <input type="text" id="question1" name="questions[0]" required><br><br>
        
        <label>Réponses :</label><br>
        <label for="answer1_1">Réponse 1 :</label>
        <input type="text" id="answer1_1" name="answers[0][0]" required>
        <input type="radio" name="correct_answers[0]" value="0" required><br>
        
        <label for="answer1_2">Réponse 2 :</label>
        <input type="text" id="answer1_2" name="answers[0][1]" required>
        <input type="radio" name="correct_answers[0]" value="1"><br>
        
        <label for="answer1_3">Réponse 3 :</label>
        <input type="text" id="answer1_3" name="answers[0][2]" required>
        <input type="radio" name="correct_answers[0]" value="2"><br>
        
        <label for="answer1_4">Réponse 4 :</label>
        <input type="text" id="answer1_4" name="answers[0][3]" required>
        <input type="radio" name="correct_answers[0]" value="3"><br><br>

        <button type="submit" name="action" value="add_question">Ajouter une question</button><br><br>
        
        <input type="submit" name="action" value="save_quiz">
    </form>




</body>
</html>
