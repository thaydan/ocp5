<?php

abstract class Model {

  // Objet PDO d'accès à la BD
  private $bdd;

  /* public function prepareData ($data) {

    $columns = false;
    $values = false;

    foreach ($data as $key => $value) {
      if($columns && $values){
        $columns .= ', ' . $key;
        $values .= ', ?';
      }
      else{
        $columns .= $key;
        $values .= '?';
      }
    }

    $prepared_data['columns'] = $columns;
    $prepared_data['values'] = $values;

    return $prepared_data;

  } */

  // Exécute une requête SQL éventuellement paramétrée
  protected function executeRequest($sql, $params = null) {
    if ($params == null) {
      $result = $this->getBdd()->query($sql);    // exécution directe
    }
    else {
      $result = $this->getBdd()->prepare($sql);  // requête préparée
      $result->execute($params);
    }
    return $result;
  }

  protected function getLastInsertId(){
    $id = $this->getBdd()->lastInsertId();
    return $id;
  }

  // Renvoie un objet de connexion à la BD en initialisant la connexion au besoin
  private function getBdd() {
    if ($this->bdd == null) {
      // Création de la connexion
      $this->bdd = new PDO('mysql:host=db5002076451.hosting-data.io;dbname=dbs1688218;charset=utf8',
        'dbu817113', 'Pc6Ke2B:Hcz4GTc', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    return $this->bdd;
  }

}