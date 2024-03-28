<?php
	if(session_status() == PHP_SESSION_NONE){session_start();}
	require_once "../../Model/modele_Utilisateur.php";
	require_once "../../Controller/controleur_Forum.php";
	require_once "../../Controller/controleur_Quiz.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/utils/dmSwitch.css"/>
	<link rel="stylesheet" href="../css/utils/searchBar.css"/>
	<link rel="stylesheet" href="../css/page_accueil.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
	<link href="../../resources/favicons/favicon1.png" rel="icon" type="image/x-icon" />	
	<title>Compte Etudiant</title>
</head>
<body>

	<script src="../js/utils/dmSwitch.js"></script>	
	
	<header>		
		
		<span href="#" id="logo">PROJET DAW</span>
		
		<div class="dropdown">
			<button class="dropbtn" onclick="derouler(event)"></button>
			<div class="dropdown-content" id="myDropdown">
				<span id="spanDropTop">Tableau de bord</span>
				<hr><a href="#"><i class="fa-solid fa-book fa-lg"></i><span class="spanDrop">Mes cours</span></a>
				<hr><a href="#"><i class="fa-solid fa-comment fa-lg"></i><span class="spanDrop">Forum</span></a>
				<hr><a href="#"><i class="fa-solid fa-wrench fa-lg"></i><span class="spanDrop">Param&egrave;tres</span></a>
				<hr><a href="#" onclick="switchThemeLN()" id="switchTheme"><i class="fa-solid fa-moon fa-lg"></i><span class="spanDrop">Th&egrave;me sombre</span></a>
					<!--<form action="../../Controller/routeur.php" method="post">
						<input type="text" name="idUser" value="<?php echo $_SESSION['utilisateur_id'] ?>" hidden>
						<button type="submit" onclick="switchThemeLN()" id="bddTheme" name="action" value="dark" ><i class="fa-solid fa-moon fa-lg"></i><span class="spanDrop">Th&egrave;me sombre</span></button>
					</form>	-->	
				<hr><form action="../../Controller/routeur.php" method="post">
						<button type="submit" id="loginButton" name="action" value="deconnexion"><i class="fa-solid fa-power-off fa-lg"></i><span class="spanDrop">D&eacute;connexion</span></button>
					</form>				
			</div>
		</div> 

		<?php $initUser = ($_SESSION['nom_utilisateur'] == "admin") ? "admin" : $_SESSION['nom_utilisateur'][0] . $_SESSION['prenom_utilisateur'][0]; 
			  $themeUser = $_SESSION['theme_utilisateur'];
		?>
		<script>
			var initialesUser = " <?php echo $initUser; ?> ";
			document.querySelector('.dropbtn').innerHTML = initialesUser + '<i class="fa-solid fa-caret-down fa-lg"></i>';
			loadTheme("<?php echo $themeUser; ?>");
		</script>

	</header>
	
	<nav>
		
	</nav>
	
	<main>
		<br>
		<section id="followedCourses">
		
			<fieldset>
				<?php echo ($_SESSION['type_utilisateur'] == 'Professeur') ? '<legend>Liste des cours</legend>' : '<legend>Cours suivis</legend>'; ?>
				<input type="text" id="searchInput" onkeyup="searchCQF('searchInput', 'folCoursesTable')" placeholder="Rechercher un cours">
				
				<table id="folCoursesTable">
					
					<thead>					
						<tr>
							<th>Cours</th>
							<th>Inscription</th>
							<th>Volume Horaire</th>							
						</tr>				
					</thead>
					
					<tbody>
						
						<!-- INSERTION DYNAMIQUE DES DIFFERENTS COURS -->
						<?php ?>
						
						<tr>
							<td class="courseName">Bases de donn&eacute;es</td>
							<td class="courseDateInsc">06/04/2023</td>	
							<td class="courseTime">55h</td>								
						</tr>
						<tr>
							<td class="courseName">Outils Math&eacute;matiques</td>
							<td class="courseDateInsc">20/01/2024</td>	
							<td class="courseTime">35h</td>								
						</tr>
						<tr>
							<td class="courseName">D&eacute;veloppement web</td>
							<td class="courseDateInsc">09/01/2024</td>
							<td class="courseTime">49h</td>					
						</tr>
						
					</tbody>
				
				</table>
			
			</fieldset>
		
		</section>
		<br>
		<section>
		
			<fieldset>
				<?php echo ($_SESSION['type_utilisateur'] == 'Professeur') ? '<legend>Liste des quiz</legend>' : '<legend>Quiz disponibles</legend>'; ?>

		
			
				<div id="qcm-menu" class="menu">
					<?php
					if(isset($_SESSION['type_utilisateur']) && $_SESSION['type_utilisateur'] == 'Professeur')
					{
						Controleur_Quiz::readAll_Admin();
					}
					else{
						Controleur_Quiz::readAll();
					}
					?>
				</div>
		
			</fieldset>
		
		</section>
		<br>
		<section>
			
			<fieldset>
				<?php echo ($_SESSION['type_utilisateur'] == 'Professeur') ? '<legend>Liste des Forums</legend>' : '<legend>Forums &Eacute;tudiants</legend>'; ?>
			
				 <?php
			
					if(isset($_SESSION['type_utilisateur']) && $_SESSION['type_utilisateur'] == 'Professeur'){
						Controleur_Forum::readAll_Admin();
					}
					else{
						Controleur_Forum::readAll();
					}
				?>
				
			</fieldset>
			
		</section>	
	
	</main>
	
	<script src="../js/utils/searchBar.js"></script>
    <script src="../js/page_principale.js"></script>
	
</body>
</html>