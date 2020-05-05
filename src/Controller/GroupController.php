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
                \filter_has_var(INPUT_POST, "description") &&
                \filter_has_var(INPUT_POST, "city")) {
                //je valide le champ name
                $size = \strlen($_POST["name"]);
                if ($size < 1 || $size > 255) {
                    $error["name"] = "Le nom du groupe doit faire entre 1 et 255 caractères";
                } else {
                    $group["name"] = $_POST["name"];
                }
                
                //je valide le champ texte
                if ($size < 1 || $size > 800) {
                    $error["description"] = "La descritpion de votre groupe est obligatoire";
                } else {
                    $group["description"] = $_POST["description"];
                }
               
                //je valide le champ city
                if (empty($_POST["city"])) {
                    $error["city"] = "Le choix de la ville est obligatoire";
                } else {
                    $group["city"] = $_POST["city"];
                }
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
                header('Location:/');
                return "";
            }
        } else {
            //La requete n'est pas une requete POST, j'affiche le formulaire vide.
            return $this->twig->render('Group/add.html.twig', ["cities" => $cities]);
        }
    }
    public function addConect()
    {
        //On initialise le tableau des erreurs.
        $error = [];
        //on initialise le tableau groupe.
        $group = [];
        // Si la requête est POST, je traite le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (\filter_has_var(INPUT_POST, "email") &&
               \filter_has_var(INPUT_POST, "password")) {
                //je valide le champ email
                if (filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL) === false) {
                    $error["email"] = "l'adresse mail n'est pas valide";
                } else {
                    $group["email"] = $_POST["email"];
                }
                 //je valide le champ password
                 $size = \strlen($_POST["name"]);
                if ($size < 1 || $size > 255) {
                    $error["password"] = "Le mot de passe doit faire entre 1 et 255 caractères";
                } else {
                    $group["password"] = $_POST["password"];
                }
                //y'a til un champ qui n'est pas valide?
                if (!empty($error)) {
                    return $this->twig->render(
                        "Group/add.html.twig",
                        ["errors" => $error, "group" => $group]
                    );
                }
            } else {
                //tous les champs sont valide.
                return $this->twig->render('Group/profil.html.twig');
            }
        } else {
             //La requete n'est pas une requete POST, j'affiche le formulaire vide.
             return $this->twig->render('Group/add.html.twig');
        }
    }
}
