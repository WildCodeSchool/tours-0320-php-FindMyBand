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
                $id =$groupManager->insert($group);
                header("location:/group/profil/". $id);
                return "";
            }
        } else {
            //La requete n'est pas une requete POST, j'affiche le formulaire vide.
            return $this->twig->render('Group/add.html.twig', ["cities" => $cities]);
        }
    }

    public function profil(int $id)
    {
        $groupManager = new GroupManager();
        $group = $groupManager->selectOneById($id);
        $cityManager = new CityManager();
        $cities = $cityManager->selectAll();

        return $this->twig->render('Group/profil.html.twig', ["group"=>$group, "cities" => $cities]);
    }
}

