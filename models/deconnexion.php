<?php
	unset($_SESSION['idUtilisateur']);
	unset($_SESSION['prenom']);
	unset($_SESSION['nom']);
	unset($_SESSION['acces']);
    unset($_SESSION['role']); 
	session_destroy();
	header('Location: index.php');
?>
