<?php
namespace App\Controller;
use App\Model\MusicianManager;
use App\Model\CityManager;
use App\Model\MusicianForm;

class MusicianController extends AbstractController
{
    /**
     * affiche et traite le formulaire d'inscription d'un musician.
     */
    public function add() :string
    {
          //on initialise l'objet de gestion du formulaire musician
          $musician = new MusicianForm();
          $city =  new  CityManager();
          $cities = $city->selectAll();
        
          // Si la requête est POST, je traite le formulaire
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              if ($musician->handleRequest() === false) {
                // Le cas où il manque des données.
                header('location:/');
                return "";
            } else {
                if ($musician->hasErrors()) {
                    // Il y a des erreurs dans le formulaire
                    // On affiche le formulaire avec erreurs ou valeurs préremplies
                    return $this->twig->render(
                        'Musician/add.html.twig',
                         ["cities" => $cities, "musician" => $musician,]);
                }
                // TODO !!
                $musicianManager = new MusicianManager();
                $musicianManager->insert($musician);
                return $this->twig->render('Musician/profile.html.twig');
              
            }
        } else {
            //La requete n'est pas une requete POST, j'affiche le formulaire vide.
            return $this->twig->render('Musician/add.html.twig', ["cities" => $cities]);
               }
       }
    }