<?php

namespace App\Controller;

use App\Model\GroupManager;
use App\Model\CityManager;
use App\Model\GroupForm;
use App\Model\SearchManager;
use App\Model\MasteryLevelManager;
use App\Model\InstrumentManager;
use App\Model\InstrumentPlayedManager;

class GroupController extends AbstractController
{

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: /");
    }
    public function login()
    {
        session_start();
        $errorMessages=[''];
        $user=[''];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Vérifier les champs reçus
            // email est valide
            // password a au moins X caractères
            //je valide le champ email
            if (filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL) === false || empty($_POST['email'])) {
                $errorMessages["email"] = "Le email est invalide";
                return $this->twig->render('Group/login.html.twig', ["errorMessages"=>$errorMessages]);
            } else {
                $user['email']= $_POST["email"];
            }
            //je valide le champ password
            if (empty($_POST['password'])) {
                $errorMessages['password'] = "Le mot de passe doit faire entre 1 et 255 caractères";
                return $this->twig->render('Group/login.html.twig', ["errorMessages"=>$errorMessages]);
            } else {
                if (\filter_has_var(INPUT_POST, "password") && isset($_POST['password'])) {
                    $user['password'] = $_POST['password'];
                }
            }
            // 2. Chercher dans la BDD (table user) email correspondant à celui fourni
            $groupManager = new GroupManager();
            $group = $groupManager->selectOneByEmail($user['email']);
            if (!$group) {
                // Si on ne récupère pas d'utilisateur -> afficher une erreur
                $errorMessages["email"] = "Le email est incorrect";
                return $this->twig->render('Group/login.html.twig', ["errorMessages"=>$errorMessages]);
            }
            // 4. Stocker dans la session les informations sur l'utilisateur connecté
            $_SESSION['user_id'] = $group['id'];
            $_SESSION['user_email'] = $group['email'];
            $group = [
                'id' => $_SESSION['user_id'],
                'email' => $_SESSION['user_email'],
                 ];
            // 5. Rediriger l'utilisateur vers la page de profil
            $instrumentManager = new InstrumentManager();
            $instruments = $instrumentManager->selectAll();
            $masteryManager= new MasteryLevelManager();
            $masteries=$masteryManager->selectAll();
            header('Location:/group/profil/'.$_SESSION['user_id']);
            return $this->twig->render(
                'Group/profil.html.twig',
                ['group' => $group,
                "masteries"=>$masteries,
                'instruments' => $instruments]
            );
        }
        return $this->twig->render('Group/login.html.twig');
    }
    /**
     * affiche et traite le formulaire d'inscription d'un musician.
     */
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
                \header("location:/");
                return "";
            }
        } else {
            //La requete n'est pas une requete POST, j'affiche le formulaire vide.
            return $this->twig->render('Group/add.html.twig', ["cities" => $cities]);
        }
    }

    public function profil(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validating the Mastery is a positive number
            // Validating the instrument is a positive number
            if (\filter_input(
                INPUT_POST,
                "mastery",
                \FILTER_VALIDATE_INT,
                ["options" => ["min_range" => 0]]
            ) !== false&&
                \filter_input(
                    INPUT_POST,
                    "instrument",
                    \FILTER_VALIDATE_INT,
                    ["options" => ["min_range" => 0]]
                ) !== false
                ) {
                $masteryId=$_POST['mastery'];
                $instrumentId=$_POST['$instrumentId'];
                $searchManager = new SearchManager();
                $searchManager->insert($instrumentId, $id, $masteryId);
                    \header("location:");
                    return" ";
            }
        }
      

        $instrumentManager = new InstrumentManager();
        $instruments = $instrumentManager->selectAll();
        $groupManager = new GroupManager();
        $group = $groupManager->selectOneById($id);
        $masteryManager= new MasteryLevelManager();
        $masteries=$masteryManager->selectAll();
        return $this->twig->render(
            'Group/profil.html.twig',
            ["group"=>$group,
            "masteries" => $masteries,
            'instruments' => $instruments]
        );
    }
}
