<?php 
require_once 'Database.php';

//  traite une donnée

$nom = htmlspecialchars($_POST['nom']);
$prenom = htmlspecialchars($_POST['prenom']);
$date = htmlspecialchars($_POST['date']);
$email = htmlspecialchars($_POST['email']);
$phone = htmlspecialchars($_POST['phone']);
$mdp1 = htmlspecialchars($_POST['mdp1']);
$mdp2 = htmlspecialchars($_POST['mdp2']);



// if == si 
// empty == vide 
// !devant une function c'est le contraire 
// && == and == et
// != different ==! 
// strlen signifie la longeur d'un string 
// > superieur 
// AND 
// OR == ||

if (strlen($nom) == 0 || strlen($nom) > 255 OR empty($nom)) {
  echo "erreur nom";
}

if (strlen($prenom) == 0 || strlen($prenom) > 255 OR empty($prenom)) {
  echo "erreur prenom";
  die();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($date) > 255){
  echo $email." mail invalide". "<br>";
  die();
  
}

if (strlen($phone) == 0 || strlen($phone) >18 OR empty($phone)) {
  echo "numero invalide";
  die();
}

if(empty($date) || strlen($date) > 20) {
  echo "erreur date";
  die();
}

if(strlen($mdp1) < 2 || $mdp1 != $mdp2 || strlen($mdp1) > 255 ) {
  echo "erreur mdp";
  die();
}

$rechercheEmail = Database::Select('user', 'email = ?', [$email]);

if ($rechercheEmail == false) {
  echo "erreur de vérification";
  die();
}

$emailTest = $rechercheEmail->fetchAll();

if (count($emailTest) > 0) {
  echo "L'utilisateur est déjà inscrit";
  die();
}

$newPassword = password_hash($mdp1, PASSWORD_ARGON2ID);

$insert = Database::Insert('user',[
  $nom,
  $prenom,
  $date,
  $newPassword,
  $email,
  $phone
]);

if ($insert == false) {
  echo "un problème a eu lieu lors de l'insertion";
  die();
}

header('Location:  http://localhost/index.php');