<?php

//require_once \Config::$site_version_root . '/View/Functions.php';

class View {

  private $fichier;

  public function __construct($action) {
    // Détermination du nom du fichier vue à partir de l'action
    $this->fichier = $action . ".php";
  }

  // Génère et affiche la vue
  public function render($data) {

    $data['site_root'] = \Config::$site_root;
    $data['site_root_admin'] = \Config::$site_root_admin;

    $this->fichier = '../View/' . $this->fichier;
    // Génération de la partie spécifique de la vue
    $data['template_content'] = $this->generateFile($this->fichier, $data);

    $view = $this->generateFile('../View/Template.php', $data);
    // Renvoi de la vue au navigateur
    echo $view;

  }

  // Génère un fichier vue et renvoie le résultat produit
  private function generateFile($fichier, $data) {
    if (file_exists($fichier)) {
      // Rend les éléments du tableau $data accessibles dans la vue
      extract($data);
      // Démarrage de la temporisation de sortie
      ob_start();
      // Inclut le fichier vue
      // Son résultat est placé dans le tampon de sortie
      require $fichier;
      // Arrêt de la temporisation et renvoi du tampon de sortie
      return ob_get_clean();
    }
    else {
      throw new \Exception("Fichier '$fichier' introuvable");
    }
  }
}