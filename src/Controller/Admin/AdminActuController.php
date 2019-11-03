<?php

namespace App\Controller\Admin;

use App\Entity\Actu;
use App\Entity\Artwork;
use App\Form\ActuType;
use App\Form\ArtworkType;
use App\Repository\ActuRepository;
use App\Repository\ArtworkRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminActuController extends AbstractController
{

    /**
     * @var ArtworkRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ActuRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;

        $this->em = $em;
    }

    /**
     * @Route("/admin/actus", name="admin.actu.index")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function index()
    {
        $actus = $this->repository->findAll();
        return $this->render('admin/actus/index.html.twig', compact('actus'));
    }

    /**
     * @Route("/admin/actus/create", name="admin.actus.new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $actu = new Actu();
        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($actu);
            $this->addFlash('success', 'L\'événement a bien été ajouté');
            $this->em->flush();
            return $this->redirectToRoute('admin.actu.index');
        }

        return $this->render('admin/actus/new.html.twig', [
            'actu' => $actu,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/actus/{id}", name="admin.actus.edit", methods="GET|POST")
     * @param Artwork $artwork
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Actu $actu, Request $request)
    {
        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'L\'événement a bien été modifié');

            return $this->redirectToRoute('admin.actu.index');
        }

        return $this->render('admin/actus/edit.html.twig', [
            'actu' => $actu,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/actus/{id}", name="admin.actus.delete", methods="DELETE")
     * @param Artwork $artwork
     * @param Request $request
     * @return Response
     */
    public function delete(Actu $actu, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $actu->getId(), $request->get('_token'))) {

            $this->em->remove($actu);
            $this->em->flush();
            $this->addFlash('success', 'L\'événement a bien été supprimé');


        }
        return $this->redirectToRoute('admin.actu.index');
    }





}
