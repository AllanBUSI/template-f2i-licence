<?php

use PhpParser\Node\Stmt\TryCatch;

class Database {
  public static function ConnectDb() {
    $db="f2i";
    $dbhost="localhost";
    $dbport=3306;
    $dbuser="root";
    $dbpasswd="";
    try {
      $pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
      return $pdo;
    } catch (PDOException $e) {
      return false;
    }
  }

  public static function Select($table = null,$ceQueJeCherche = null, $maDonnerQueJeCherche = null) {
    // connexion a la base de données des
    $db = Database::ConnectDb();
    // attraper l'erreur
    try {
      // si la table est null on retourne false
      if ($table == null) {
        return false;
      } 
      // selectionne la table
      $sql = 'SELECT * FROM '.$table;
      // 
      if ($maDonnerQueJeCherche == null && $ceQueJeCherche == null) {
        $sth = $db->prepare($sql);
        $sth->execute([]);
        return $sth;
      } elseif ($maDonnerQueJeCherche != null && $ceQueJeCherche != null) {
        $sql .= ' WHERE '.$ceQueJeCherche;
        $sth = $db->prepare($sql);
        $sth->execute($maDonnerQueJeCherche);
        return $sth;
      } else {
        return false;
      }
    } catch (PDOException $e) {
      return false;
    }
  }

  public static function Insert($table = null, $data = null) {
    $db = Database::ConnectDb(); //
    
    try {

      if ($table == null) {
        return false;
      }

      $sql = "INSERT INTO ".$table ." (firstname,lastname, date,password,email, phone) VALUES (?, ?, ?, ?, ?, ?)"; 

      if ($table != null && $data != null) {
        $sth = $db->prepare($sql);
        $sth->execute($data);
        return $sth; 
      } else {
        return false;
      }

    } catch (PDOException $e) {
        return false; 
    }
  }
}