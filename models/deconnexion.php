<?php
	unset($_SESSION['idUtilisateur']);
	unset($_SESSION['prenom']);
	unset($_SESSION['nom']);
	header('Location: index.php');
?>