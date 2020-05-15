<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\SearchManager;
use App\Model\MasteryLevelManager;
use App\Model\InstrumentManager;
use App\Model\GroupManager;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $searchManager = new SearchManager();
        $search=$searchManager->allannonce();
       
        $i= $search[21]['instrument_id'];
        $g=$search[21]['group_id'];
        $m=$search[21]['mastery_levels_id'];
        $instrumentManager = new InstrumentManager();
        $instrument = $instrumentManager->selectOneById($i);
        $masteryManager= new MasteryLevelManager();
        $masterie=$masteryManager->selectOneById($m);
        $groupManager = new GroupManager();
        $group = $groupManager->selectOneById($g);
        return $this->twig->render(
            'Home/index.html.twig', [
            "instrument"=>$instrument, "masterie"=>$masterie, "group"=>$group]);
    
    }
}
