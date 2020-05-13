<?php
	
/**
 * Created by VsCode.
 * User: Ahmad SAFAR
 * Date: 12/05/20
 * Time: 21:21
 * PHP version 7.1
 */
namespace App\Controller;


use App\Model\MusicianManager;
use App\Model\CityManager;
use App\Model\MusicianForm;
use App\Model\Mastery_levelManager;
use App\Model\InstrumentManager;
use App\Model\Instrument_playedManager;


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
                        $musicianManager = new MusicianManager();
                           //récupérer le id  musician
                        $id =$musicianManager->insert($musician);
                         \header('location:/musician/profil/'.$id);
                         return '';
              
                        }
                } else {
                       //La requete n'est pas une requete POST, j'affiche le formulaire vide.
                        return $this->twig->render('Musician/add.html.twig', ["cities" => $cities]);
            }
       }
    public function profil(int $id)  : string
    {   

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Validating the Mastery is a positive number
         // Validating the instrument is a positive number
        if (\filter_input(INPUT_POST, "mastery", \FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]) !== false&&
            \filter_input(INPUT_POST, "instrument", \FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]) !== false)  {
              $masteryId=$_POST['mastery'];
              $instrumentId=$_POST['instrument'];
             // Validating if the mastery exists in the database
             // Validating if the instrument exists in the database
             if (!empty($masteryId)&&!empty($instrumentId)&& !empty($id)) {
             var_dump($id);
              $Instrument_played= new Instrument_playedManager();
             $instrument_played_Id = $Instrument_played->insert($masteryId,$instrumentId,$id);

             header('Location:/musician/profil/'. $id);
             return"";
             }  
               
          }
       }
         $instrumentManager = new InstrumentManager();
         $instruments = $instrumentManager->selectAll();
         $musicianManager = new MusicianManager();
         $musician=$musicianManager->selectOneById($id);
         $masteryManager= new Mastery_levelManager();
         $masteries=$masteryManager->selectAll();
         return $this->twig->render('Musician/profil.html.twig',
         ["musician"=>$musician,"masteries"=>$masteries,'instruments' => $instruments]);

    }
}