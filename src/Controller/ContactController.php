<?php
/**
 * Created by VS Code.
 * User: Ahmad SAFAR
 * Date: 15/05/20
 * Time: 09:55
 */

namespace App\Controller;

class ContactController extends AbstractController
{

    /**
     * Display Contact page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Contact/index.html.twig');
    }
}
