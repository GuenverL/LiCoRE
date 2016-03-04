<?php
  function estUnUtilisateur($identifiant, $mdp){
    global $bdd;

    $querySelect = $bdd->prepare("Select idUtilisateur, prenom, nom From utilisateur Where identifiant = :identifiant and mdp = :mdp");
    $querySelect->bindParam(':identifiant', $identifiant, PDO::PARAM_STR);
    $querySelect->bindParam(':mdp', $mdp, PDO::PARAM_STR);
    $querySelect->execute();

    if($row = $querySelect->fetch()){
      return array(
          'id' => $row['idUtilisateur'],
          'prenom' => $row['prenom'],
          'nom' => $row['nom']
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