<?php

namespace App\Controller;

use App\Entity\Artwork;
use App\Repository\ArtworkRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * La pagination est mise en place à partir d'ici. pour modifier la page courante => PAGE, pour modifier
     * le nombre d'articles / page => limit.
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {

        $artworks = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1),
            8
            );

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