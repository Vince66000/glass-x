<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ContactController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct( Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route(path="/pages", name="contact")
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(): Response
    {
        return new Response($this->twig->render('pages/contact.html.twig'));
    }




}