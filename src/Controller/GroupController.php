<?php

namespace App\Controller;

use App\Model\GroupManager;
use App\Model\CityManager;
use App\Model\GroupForm;

class GroupController extends AbstractController
{
    /**
     * affiche et traite le formulaire d'inscription d'un groupe.
     */
    public function add() : string
    {
        //on initialise l'objet de gestion du formulaire groupe.
        $group = new GroupForm();
        $cityManager = new CityManager();
        $cities = $cityManager->selectAll();
        // Si la requête est POST, je traite le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($group->handleRequest() === false) {
                // Le cas où il manque des données.
                header('location:/');
                return "";
            } else {
                if ($group->hasErrors()) {
                    // Il y a des erreurs dans le formulaire
                    // On affiche le formulaire avec erreurs ou valeurs préremplies
                    return $this->twig->render('Group/add.html.twig', ["cities" => $cities, "group" => $group]);
                }
                // On traite le formulaire

                // TODO !!
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
