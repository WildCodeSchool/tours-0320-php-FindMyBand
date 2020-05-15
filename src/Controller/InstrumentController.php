<?php
/**
 * Created by Romain Clair
 * 24/04/2020
 */

namespace App\Controller;

use App\Model\InstrumentManager;

/**
 * Class InstrumentController
 *
 */
class InstrumentController extends AbstractController
{

    /**
     * Display instruments listing
     *
     * This page and controller will probably disapear but we'll keep it for testing purpose
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $instrumentManager = new InstrumentManager();
        $instruments = $instrumentManager->selectAll();

        return $this->twig->render('Instrument/index.html.twig', ['instruments' => $instruments]);
    }

    /**
     * Display instrument creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $instrumentManager = new InstrumentManager();
            // I check if i have the requested fileds
            if (\filter_has_var(INPUT_POST, "name")) {
                $size = \strlen($_POST["name"]);
                if ($size < 1 || $size > 100) {
                    // The size is invalid
                    $error = "Nom invalide : la taille doit être entre 1 et 100 caractères";
                    return $this->twig->render('Instrument/add.html.twig', ["error" => $error]);
                }
                $instrument["name"] = $_POST["name"];
                $instrumentManager->insert($instrument);
                header('Location:/');
                return "";
            }
            // I don't have the field requeted
            header('Location:/');
            return "";
        }
        return $this->twig->render('Instrument/add.html.twig');
    }
}
