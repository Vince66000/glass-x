<?php

namespace App\Controller\Admin;

use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminArtworkController extends AbstractController
{

    /**
     * @var ArtworkRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ArtworkRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;

        $this->em = $em;
    }

    /**
     * @Route("/admin/artworks", name="admin.artworks.index")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function index()
    {
        $artworks = $this->repository->findAll();
        return $this->render('admin/artworks/index.html.twig', compact('artworks'));
    }

    /**
     * @Route("/admin/artworks/create", name="admin.artworks.new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $artwork = new Artwork();
        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($artwork);
            $this->addFlash('success', 'La toile a bien été ajoutée');
            $this->em->flush();
            return $this->redirectToRoute('admin.artworks.index');
        }

        return $this->render('admin/artworks/new.html.twig', [
            'artwork' => $artwork,
            'form' => $form->createView()
    ]);

    }

    /**
     * @Route("/admin/artworks/{id}", name="admin.artworks.edit", methods="GET|POST")
     * @param Artwork $artwork
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Artwork $artwork, Request $request)
    {
        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'La toile a bien été modifiée');

            return $this->redirectToRoute('admin.artworks.index');
        }

        return $this->render('/admin/artworks/edit.html.twig', [
            'artwork' => $artwork,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/artworks/{id}", name="admin.artworks.delete", methods="DELETE")
     * @param Artwork $artwork
     * @param Request $request
     * @return Response
     */
    public function delete(Artwork $artwork, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $artwork->getId(), $request->get('_token'))) {

            $this->em->remove($artwork);
            $this->em->flush();
            $this->addFlash('success', 'La toile a bien été supprimée');


        }
        return $this->redirectToRoute('admin.artworks.index');
    }



}