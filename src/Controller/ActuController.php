<?php

namespace App\Controller;

use App\Entity\Actu;
use App\Repository\ActuRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ActuController extends AbstractController
{

    /**
     * @var Environment
     */
    private $twig;
    private $repository;

    public function __construct(ActuRepository $repository, ObjectManager $em, Environment $twig)
    {
        $this->em = $em;
        $this->repository = $repository;
        $this->twig = $twig;
    }

    /**
     * @Route("/actu", name="actu" )
     * @return Response
     */
    public function index() :Response
    {
        $actus = $this->repository->findAll();
        return new Response($this->twig->render('actu/index.html.twig', ['actus' => $actus]));

    }

    /**
     * @Route("/actu/{slug}-{id}" , name="actu.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param ActuController $actu
     * @param string $slug
     * @return
     */
    public function show(Actu $actu, string $slug): Response
    {
        if ($actu->getSlug() !== $slug)
        {
            return $this->redirectToRoute('actu.show', [
                'id' => $actu->getId(),
                'slug' => $actu->getSlug()
            ], 301);
        }
//        $actu = $this->repository->find(actugetId());

        return $this->render('actu/show.html.twig', [
            'actu' => $actu,
            'current_menu' => 'actus'

        ]);
    }
}