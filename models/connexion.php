<?php
  function estUnUtilisateur($identifiant, $mdp){
    global $bdd;

    $querySelect = $bdd->prepare("Select idUtilisateur, prenom, nom From utilisateur Where identifiant = :identifiant and mdp = :mdp");
    $querySelect->bindParam(':identifiant', $identifiant, PDO::PARAM_STR);
    $querySelect->bindParam(':mdp', $mdp, PDO::PARAM_STR);
    $querySelect->execute();

    if($querySelect->fetch()){
      return array(
          'id' => $querySelect->fetchColumn(0),
          'prenom' => $querySelect->fetchColumn(1),
          'nom' => $querySelect->fetchColumn(2)
      );
    }

     return array(
          'id' => -1
     );
}
    
if(isset($_POST['btnConnexion'])){
  $identifiant = $_POST['inputIdentifiant'];
  $mdp = $_POST['inputMdp'];
  $utilisateur =  estUnUtilisateur($identifiant, $mdp);
  if($utilisateur['id'] != -1){
    $_SESSION['idUtilisateur'] =  $utilisateur['id'];
    $_SESSION['prenom'] =  $utilisateur['prenom'];
    $_SESSION['nom'] =  $utilisateur['nom'];
    header('Location: index.php');
  }
  else{
    header('Location: index.php?action=connexion');
  }
}
?>