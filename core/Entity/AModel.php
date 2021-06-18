<?php

namespace Core\Entity;

abstract class AModel {

  private $bdd;

  protected function sql($sql, $params = null) {
    if ($params == null) {
      $result = $this->getBdd()->query($sql);    // exécution directe
    }
    else {
      $result = $this->getBdd()->prepare($sql);  // requête préparée
      $result->execute($params);
    }

    return $result->fetchAll();
  }

  /*protected function getLastInsertId()
  {
    $id = $this->getBdd()->lastInsertId();
    return $id;
  }*/

  private function getBdd()
  {
    if ($this->bdd == null) {
      // Création de la connexion
      $this->bdd = new \PDO('mysql:host=' . $_ENV['DATABASE_HOST'] . ';dbname=' . $_ENV['DATABASE_NAME'] . ';charset=utf8',
          $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD'], array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
    }
    return $this->bdd;
  }

}