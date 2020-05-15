<?php

/**

 * Created by Ahmas safar

 * 4/05/2020

 */

namespace App\Controller;

use App\Model\AnnonceManager;
use App\ModelMasteryLevelManager;
use App\Model\InstrumentPlayedManager;
use App\Model\GroupManager;
use App\Model\MasteryLevelManager;

/**

 * Class SearchController

 *

 */

class AnnonceController extends AbstractController
{
    public function add()
    {
        $instrument=[];
        $mastery=[];
        $annonce=[];
        $error=[];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $annonceManager = new AnnonceManager();
            $instrumentManager = new InstrumentPlayedManager;
            $instrument = $instrumentManager->selectAll();
            $masteryManager = new MasteryLevelManager;
            $mastery = $masteryManager->selectAll();

            if (isset($_POST['indstrument_id']) && isset($_POST['group_id']) && isset($_POST['mastery_levels_id'])) {
                $annonce['insrument_id']=$_POST['name'];
                $annonce['group_id']=$_POST['name'];
                $annonce['mastery_levels_id']=$_POST['level'];

                $annonceManager->insert($annonce);
            } else {
                $error="vous devez selectionner un choie";
            }
                return $this->twig->render('Annonce/add.html.twig', ["annonce" => $annonce]);
        }
                return $this->twig->render('Annonce/add.html.twig', ["annonce" => $annonce]);
    }
}
