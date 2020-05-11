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
                $groupManager = new GroupManager();
                $groupManager->insert($group);
            }
        } else {
            //La requete n'est pas une requete POST, j'affiche le formulaire vide.
            return $this->twig->render('Group/add.html.twig', ["cities" => $cities]);
        }
    }
    
}
