<?php

namespace App\Controller;

use App\Entity\Vente;
use App\Entity\Article;
use App\Form\VenteType;
use App\Repository\VenteRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vente")
 */
class VenteController extends AbstractController
{
    /**
     * @Route("/", name="vente_index", methods={"GET"})
     */
    public function index(VenteRepository $venteRepository): Response
    {        
        return $this->render('vente/index.html.twig', [
            'ventes' => $venteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vente_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vente = new Vente();
        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);
        $iduser = $this->getUser()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $vente->setVenteAt(new \DateTime());
            $vente->setGerant($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vente);
            $entityManager->flush();

            return $this->redirectToRoute('vente_index');
        }

        return $this->render('vente/new.html.twig', [
            'vente' => $vente,
            'form' => $form->createView(),
        ]);
    }

        /**
     * @Route("/caisse", name="caisse_new", methods={"GET","POST"})
     */
    public function caisse(Request $request): Response
    {
        $vente = new Vente();
        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);
        $iduser = $this->getUser()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $vente->setVenteAt(new \DateTime());
            $vente->setGerant($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vente);
            $entityManager->flush();

            return $this->redirectToRoute('vente_index');
        }

        return $this->render('vente/achat.html.twig', [
            'vente' => $vente,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/caisse/new/{id}&{qte}", name="caissier", methods={"GET","POST"})
     */
    public function caissier(Request $request,$id,$qte): Response
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->findOneBy(
            array('id' => $id)
        );
        //dump($article);
            $vente = new Vente();
            $vente->setVenteAt(new \DateTime());
            $vente->setGerant($this->getUser());
            $vente->setQuantite($qte);
            $vente->setArticle($article);            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vente);
            $entityManager->flush();

            $article->setStock($article->getStock()-$qte);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            // return $this->redirectToRoute('vente_index');
      

        // return $this->render('vente/achat.html.twig', [
        //     'vente' => $vente,
        // ]);
        return new JsonResponse([
            'message' => 'success',
            // 'articles'=>$response
        ]);
    }

    /**
     * @Route("/{id}", name="vente_show", methods={"GET"})
     */
    public function show(Vente $vente): Response
    {
        return $this->render('vente/show.html.twig', [
            'vente' => $vente,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vente_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vente $vente): Response
    {
        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vente_index');
        }

        return $this->render('vente/edit.html.twig', [
            'vente' => $vente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vente_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Vente $vente): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vente->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vente_index');
    }
}
