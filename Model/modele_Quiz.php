<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "Model.php";


class Modele_Quiz {
    private $titre;

    public static function readAll_Admin() {
        $xmlFile = __DIR__ . "/../xml/quiz.xml";
        $xml = simplexml_load_file($xmlFile);
        
        if ($xml !== false) { 
            echo "<ul>";
            foreach ($xml->quiz as $quiz) {
                if(isset($quiz['id']) && !empty($quiz['id'])) {
                    echo '';
                    echo '<form action="../../Controller/routeur.php" method="get">
                        <li><a href="page_quiz.php?id='.$quiz['id'].'">Quiz '.$quiz['id'].'</a></li>
                        <input type="hidden" name="id" value="'.$quiz['id'].'"> 
                        <button type="submit" name="action" value="supprimer_quiz">Supprimer</button>
                        </form>';
                }
            }
            echo '
            <form action="../../Controller/routeur.php" method="post">
            <button type="submit" name="action" value="add_quiz">
            <a>Ajouter</a>
            </button>
            </form>';
            echo "</ul>";
        } else {
            echo "Erreur lors du chargement du fichier XML.";
        }
    }

    public static function save() {
        if (!empty($_POST['questions']) && !empty($_POST['answers']) && !empty($_POST['correct_answers'])) {
            $questions = $_POST['questions'];
            $answers = $_POST['answers'];
            $correctAnswers = $_POST['correct_answers'];
    
            $xmlFile = __DIR__ . "/../xml/quiz.xml";
            if (file_exists($xmlFile)) {
                $xml = simplexml_load_file($xmlFile);
            } else {
                $xml = new SimpleXMLElement('<quiz/>');
            }
            $quizCount = $xml->count();
            $nextQuizId =($quizCount + 1);
    
            $quiz = $xml->addChild('quiz');
            $quiz->addAttribute('id', $nextQuizId);
    
            foreach ($questions as $index => $questionText) {
                $question = $quiz->addChild('question');
                $question->addChild('text', $questionText);

                if (isset($answers[$index]) && isset($correctAnswers[$index])) {
                    $answersNode = $question->addChild('answers');
                    foreach ($answers[$index] as $answerIndex => $answerText) {
                        $answer = $answersNode->addChild('answer', $answerText);
                        if ($correctAnswers[$index] == $answerIndex) {
                            $answer->addAttribute('correct', 'true');
                        } else {
                            $answer->addAttribute('correct', 'false');
                        }
                    }
                }
            }
            header("Location: ../View/php/page_accueil.php");
            if (file_put_contents($xmlFile, $xml->asXML()) !== false) {
                return "QCM enregistré avec succès !";
            } else {
                return "Erreur lors de l'enregistrement du QCM.";
            }
        } else {
            return "Erreur : Les données du formulaire sont manquantes ou vides.";
        }
    }
    
    public static function addQCM(){
        $questionCount = 1; // Nombre initial de questions

        echo '<label for="question1">Question 1 :</label><br>';
        echo '<input type="text" id="question1" name="questions[0]" required><br><br>';
        
        echo '<label>Réponses :</label><br>';
        
        echo '<label for="answer1_1">Réponse 1 :</label>';
        echo '<input type="text" id="answer1_1" name="answers[0][0]" required>';
        echo '<input type="radio" name="correct_answers[0]" value="0" required><br>';
        
        echo '<label for="answer1_2">Réponse 2 :</label>';
        echo '<input type="text" id="answer1_2" name="answers[0][1]" required>';
        echo '<input type="radio" name="correct_answers[0]" value="1"><br>';
        
        echo '<label for="answer1_3">Réponse 3 :</label>';
        echo '<input type="text" id="answer1_3" name="answers[0][2]" required>';
        echo '<input type="radio" name="correct_answers[0]" value="2"><br>';
        
        echo '<label for="answer1_4">Réponse 4 :</label>';
        echo '<input type="text" id="answer1_4" name="answers[0][3]" required>';
        echo '<input type="radio" name="correct_answers[0]" value="3"><br><br>';
        self::add();
    }

    public static function add(){
        header("Location: ../View/php/page_creation_quiz.php");
    }

    public static function supprimer() {
        if (isset($_POST['id']) || isset($_GET['id'])) {
            $id_quiz = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];
    
            $xmlFile = __DIR__ . "/../xml/quiz.xml";
            $xml = simplexml_load_file($xmlFile);
    
            if ($xml !== false) {
                $quizFound = false;
                foreach ($xml->quiz as $quiz) {
                    if ((string)$quiz['id'] === $id_quiz) {
                        unset($quiz[0]);
                        $quizFound = true;
                        break;
                    }
                }
                if ($quizFound && $xml->asXML($xmlFile)) {
                    header("Location: ../View/php/page_accueil.php");
                } else {
                    echo "Erreur : Quiz non trouvé ou impossible de le supprimer.";
                }
            } else {
                echo "Erreur lors de la lecture du fichier XML.";
            }
        } else {
            echo "Erreur : Identifiant du quiz non spécifié.";
        }
    }
    

    public static function readAll() {
        $xmlFile = __DIR__ . "/../xml/quiz.xml";
        $xml = simplexml_load_file($xmlFile);
        
        if ($xml !== false) { 
            echo "<ul>";
            foreach ($xml->quiz as $quiz) {
                if(isset($quiz['id']) && !empty($quiz['id'])) {
                    echo '<li><a href="page_quiz.php?id='.$quiz['id'].'">Quiz '.$quiz['id'].'</a></li>';
                }
            }
            echo "</ul>";
        } else {
            echo "Erreur lors du chargement du fichier XML.";
        }
    }

    public static function readQuiz()
    {
        if (isset($_GET['id'])) {
            $id_quiz = $_GET['id'];

            $xmlFile = __DIR__ . "/../xml/quiz.xml";
            $xml = simplexml_load_file($xmlFile);
            if ($xml !== false) { 
                $selectedQuiz = null;

                foreach ($xml->quiz as $quiz) {
                    if ((string)$quiz['id'] === $id_quiz) {
                        $selectedQuiz = $quiz;
                        break;
                    }
                }

                if ($selectedQuiz !== null) {
                    echo "<h1>QCM : $id_quiz</h1>";

                    $questionIndex = 1;
                    foreach ($selectedQuiz->question as $question) {
                        $text = (string)$question->text;
                        $answers = $question->answers->answer;

                        echo "<p>Question $questionIndex: $text</p>";
                        $optionIndex = 'A';
                        if ($answers && count($answers) > 0) { 
                            foreach ($answers as $answer) {
                                $isCorrect = (string)$answer['correct'] === 'true';
                                echo "<input type='radio' name='reponse_$questionIndex' value='$isCorrect'> $optionIndex) $answer<br>";
                                $optionIndex++;
                            }
                            echo "<hr>";
                            $questionIndex++;
                        } else {
                            echo "<p>Aucune réponse trouvée pour cette question.</p>";
                        }
                    }
                } else {
                    echo "Erreur : QCM non trouvé.";
                }
            } else {
                echo "Erreur lors de la lecture du fichier XML.";
            }
        }
    }
/*
    public function add() {
        
        if (!empty($postData['questions']) && !empty($postData['answers']) && !empty($postData['correct_answers'])) {
            // Récupérer les données du formulaire
            $questions = $postData['questions'];
            $answers = $postData['answers'];
            $correctAnswers = $postData['correct_answers'];

            // Charger le fichier XML s'il existe
            if (file_exists($this->xmlFile)) {
                $xml = simplexml_load_file($this->xmlFile);
            } else {
                // Créer un nouveau fichier XML s'il n'existe pas
                $xml = new SimpleXMLElement('<quiz/>');
            }

            // Trouver le nombre actuel de quiz dans le fichier XML
            $quizCount = $xml->count();

            // Générer l'ID pour le prochain quiz
            $nextQuizId = "quizz_" . ($quizCount + 1);

            // Ajouter le quiz au XML
            $quiz = $xml->addChild('quiz');
            $quiz->addAttribute('id', $nextQuizId);

            // Ajouter chaque question au quiz
            foreach ($questions as $index => $questionText) {
                $question = $quiz->addChild('question');
                $question->addChild('text', $questionText);

                // Vérifier que les réponses et les réponses correctes sont définies pour cette question
                if (isset($answers[$index]) && isset($correctAnswers[$index])) {
                    $answersNode = $question->addChild('answers');
                    foreach ($answers[$index] as $answerIndex => $answerText) {
                        $answer = $answersNode->addChild('answer', $answerText);
                        if ($correctAnswers[$index] == $answerIndex) {
                            $answer->addAttribute('correct', 'true');
                        } else {
                            $answer->addAttribute('correct', 'false');
                        }
                    }
                }
            }

            // Sauvegarder les données dans le fichier XML
            if (file_put_contents($this->xmlFile, $xml->asXML()) !== false) {
                return "QCM enregistré avec succès !";
            } else {
                return "Erreur lors de l'enregistrement du QCM.";
            }
        } else {
            return "Erreur : Les données du formulaire sont manquantes ou vides.";
        }
    }
    

    // Méthode pour vérifier et afficher un quizz
   /* public static function verifierEtAfficherQuizz() {
        // Vérifier si un quizz a été sélectionné sur la page précédente
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['selected_quiz'])) {
            // Récupérer l'ID du quizz sélectionné
            $selectedQuizId = $_GET['selected_quiz'];

            // Charger le fichier XML du quizz
            $xmlFile = "quiz.xml";
            $xml = simplexml_load_file($xmlFile);

            if ($xml !== false) { // Vérifier si le fichier XML a été chargé avec succès
                $selectedQuiz = null;

                // Trouver le quizz correspondant à l'ID sélectionné
                foreach ($xml->quiz as $quiz) {
                    if ((string)$quiz['id'] === $selectedQuizId) {
                        $selectedQuiz = $quiz;
                        break;
                    }
                }

                if ($selectedQuiz !== null) {
                    // Afficher le titre du quizz
                    echo "<h1>Quizz : $selectedQuizId</h1>";

                    // Afficher les questions et les réponses du quizz
                    $questionIndex = 1;
                    echo "<form action='' method='POST'>";
                    foreach ($selectedQuiz->question as $question) {
                        $text = (string)$question->text;
                        $answers = $question->answers->answer;

                        echo "<p>Question $questionIndex: $text</p>";
                        $optionIndex = 1;
                        if ($answers && count($answers) > 0) { // Vérifier s'il y a des réponses pour la question
                            foreach ($answers as $answer) {
                                $value = $optionIndex; // Utiliser l'index de la réponse comme valeur
                                echo "<input type='radio' name='reponse_$questionIndex' value='$value'> $optionIndex) $answer<br>";
                                $optionIndex++;
                            }
                            echo "<hr>";
                            $questionIndex++;
                        } else {
                            echo "<p>Aucune réponse trouvée pour cette question.</p>";
                        }
                    }
                    echo "<input type='hidden' name='selected_quiz' value='$selectedQuizId'>";
                    echo "<input type='submit' value='Valider'>";
                    echo "</form>";

                    // Calculer et afficher le score après la soumission du formulaire
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $score = 0;
                        foreach ($selectedQuiz->question as $question) {
                            $questionIndex = (int)substr((string)$question->attributes()['id'], 1);
                            $answerIndex = $_POST["reponse_$questionIndex"];

                            if ($answerIndex !== null) {
                                $isCorrect = (string)$question->answers->answer[$answerIndex - 1]['correct'] === 'true';
                                if ($isCorrect) {
                                    $score++;
                                }
                            }
                        }
                        echo "<p>Votre score est : $score / $questionIndex</p>";
                    }
                } else {
                    echo "Erreur : Quizz non trouvé.";
                }
            } else {
                echo "Erreur lors de la lecture du fichier XML.";
            }
        } else {
            echo "Erreur : Aucun quizz sélectionné.";
        }
    }*/
}
?>
