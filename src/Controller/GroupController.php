<?php

namespace App\Controller;

use App\Model\GroupManager;
use App\Model\CityManager;

class GroupController extends AbstractController
{
    /**
     * affiche et traite le formulaire d'inscription d'un groupe.
     */
    public function add()
    {
        //On initialise le tableau des erreurs.
        $error = [];
        //on initialise le tableau groupe.
        $group = [];
        $cityManager = new CityManager();
        $cities = $cityManager->selectAll();
        // Si la requête est POST, je traite le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //$groupManager = new GroupManager;
            //on vérifie que tous les champs sont présent.
            if (\filter_has_var(INPUT_POST, "name") &&
                \filter_has_var(INPUT_POST, "email") &&
                \filter_has_var(INPUT_POST, "description")) {
                //je valide le champ name
                $size = \strlen($_POST["name"]);
                if ($size < 1 || $size > 255) {
                    $error["name"] = "Le nom du groupe doit faire entre 1 et 255 caractères";
                } else {
                    $group["name"] = $_POST["name"];
                }
                //je valide le champ email
                if (filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL) === false) {
                    $error["email"] = "l'adresse mail n'est pas valide";
                } else {
                    $group["email"] = $_POST["email"];
                }
                //je valide le champ texte
                //y'a t'il un champ qui n'est pas valide???
                if (!empty($error)) {
                    return $this->twig->render(
                        "Group/add.html.twig",
                        ["errors" => $error, "group" => $group, "cities" => $cities]
                    );
                }
                //tous les champs sont valide
            } else {
                // Le cas où il manque des données.
            }
        } else {
            //La requete n'est pas une requete POST, j'affiche le formulaire vide.
            return $this->twig->render('Group/add.html.twig', ["cities" => $cities]);
        }
    }
}
