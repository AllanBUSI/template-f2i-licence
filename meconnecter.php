<?php 
session_start();

require_once 'Database.php';

$email = htmlspecialchars($_POST['email']);
var_dump($email);

$mdp = htmlspecialchars($_POST['mdp']);
var_dump($mdp);

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255){
  echo $email." mail invalide". "<br>";
  die();
  
}

if(strlen($mdp) < 2 ||  strlen($mdp) > 20 ) {
  echo "erreur mdp";
  die();
}

$rechercheEmail = Database::Select('user','email = ?', [$email]);

if ($rechercheEmail == false) {
  echo "erreur de vérification";
  die();
}

$user = $rechercheEmail->fetchAll();
if (password_verify($mdp,$user[0]['password'])) {
  echo 'Le mot de passe est valide !';
  $_SESSION['user'] = $user;
  header('Location: espace.php');
} else {
  echo 'Le mot de passe est invalide.';
}