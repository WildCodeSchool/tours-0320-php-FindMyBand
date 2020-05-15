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
       
        $ins= $search[21]['instrument_id'];
        $gro=$search[21]['group_id'];
        $mas=$search[21]['mastery_levels_id'];
        $instrumentManager = new InstrumentManager();
        $instrument = $instrumentManager->selectOneById($ins);
        $masteryManager= new MasteryLevelManager();
        $masterie=$masteryManager->selectOneById($mas);
        $groupManager = new GroupManager();
        $group = $groupManager->selectOneById($gro);
        return $this->twig->render(
            'Home/index.html.twig',
            [
            "instrument"=>$instrument,
            "masterie"=>$masterie,
            "group"=>$group]
        );
    }
}
