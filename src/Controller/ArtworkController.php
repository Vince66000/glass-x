<?php

namespace App\Controller;

use App\Entity\Artwork;
use App\Repository\ArtworkRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ArtworkController extends AbstractController {

    /**
     * @var ArtworkRepository
     */
    private $repository;

    public function __construct(ArtworkRepository $repository, ObjectManager $em)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/shop" , name="shop.index")
     * @return Response
     */
    public function index()
    {

        $artworks = $this->repository->findAll();

        return $this->render('shop/index.html.twig', [
            'artworks' =>$artworks
        ]);

    }

    /**
     * @Route("/shop/{slug}-{id}" , name="shop.show" , requirements={"slug": "[a-z0-9\-]*"})
     * @param Artwork $artwork
     * @return Response
     */
    public function show(Artwork $artwork, string $slug) : Response
    {
        if ($artwork->getSlug() !== $slug) {
            return $this->redirectToRoute('shop.show', [
                'id' => $artwork->getId(),
                'slug' => $artwork->getSlug()
            ], 301);
        }
//        $artwork = $this->repository->find($id);

        return $this->render('shop/show.html.twig', [
            'artwork' => $artwork,
            'current_menu' => 'artworks'
        ]);
    }
}