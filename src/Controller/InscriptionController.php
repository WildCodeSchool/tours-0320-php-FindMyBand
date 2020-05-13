<?php
/**
 * Created by VS Code.
 * User: Ahmad SAFAR
 * Date: 06/05/20
 * Time: 14:52
 */

namespace App\Controller;

class InscriptionController extends AbstractController
{

    /**
     * Display Inscription page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Inscription/index.html.twig');
    }
}
