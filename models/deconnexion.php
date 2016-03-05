<?php
	unset($_SESSION['idUtilisateur']);
	unset($_SESSION['prenom']);
	unset($_SESSION['nom']);
	session_destroy();
	header('Location: index.php');
?>
