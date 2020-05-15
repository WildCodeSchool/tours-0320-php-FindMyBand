<?php
/**
 * Created by VS Code.
 * User: Ahmad SAFAR
 * Date: 15/05/20
 * Time: 11:02
 */

namespace App\Controller;

class ConnexionController extends AbstractController
{

    /**
     * Display Connexion page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Connexion/index.html.twig');
    }
}