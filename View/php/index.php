<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/page_principale.css">
	<link rel="stylesheet" href="../css/utils/dmSwitch.css"/>
	<link href="../../resources/favicons/favicon1.png" rel="icon" type="image/x-icon" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
	<title>Projet DAW</title>
</head>
<body>

	<header>	
	
		<a href="#" id="logo">PROJET DAW</a>
		
		<div class="dropdown">
			<button class="dropbtn" onclick="derouler()">Menu <i class="fa-solid fa-caret-down fa-lg" id="carret"></i></button>
			<!-- <i class="fa-solid fa-caret-up fa-lg"></i> -->
			<div class="dropdown-content" id="myDropdown">
				<?php // prenom nom de la personne
					echo '<span id="spanDropTop">Tableau de bord</span>';
				?>				
				<hr><a href="#"><i class="fa-solid fa-book fa-lg"></i><span class="spanDrop">Mes cours</span></a>
				<hr><a href="#"><i class="fa-solid fa-comment fa-lg"></i><span class="spanDrop">Forum</span></a>
				<hr><a href="#"><i class="fa-solid fa-wrench fa-lg"></i><span class="spanDrop">Param&egrave;tres</span></a>
				<hr><a href="#" onclick="switchThemeLN()" id="switchTheme"><i class="fa-solid fa-moon fa-lg"></i><span class="spanDrop">Th&egrave;me sombre</span></a>				
				<hr><a href="page_de_connexion.php" id="login-button"><i class="fa-solid fa-power-off fa-lg"></i><span class="spanDrop">Connexion</span></a>
			</div>
		</div> 

	</header>

	<nav>
		
	</nav>

    <main>
		
		<br>
		<section id="followedCourses">
		
			<fieldset>
				<legend>Cours suivis</legend>

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
		<section id="recomCourses">
			
			<fieldset>
				<legend>Cours recommand&eacute;s</legend>
				
				<!-- INSERTION DYNAMIQUE DES DIFFERENTS COURS -->
				<?php ?>
			
			</fieldset>
			
		</section>
		<br>
		
	</main>   
	
	<script src="../js/utils/dmSwitch.js"></script>
    <script src="../js/page_principale.js"></script>
	
</body>
</html>
