<?php
/**
 * Created by Romain Clair
 * 24/04/2020
 */

namespace App\Controller;

/**
 * Class InstrumentController
 *
 */
class ContactController extends AbstractController
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
        

        return $this->twig->render('Contact/index.html.twig');
    }
}
