<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/find/code/{code}", methods={"GET","POST"})
     */
    public function articleByCode($code)
    {
        //$code = $_POST['code'];
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->findOneBy(
            array('codebarre' => $code)
        ); 
        $html = '';
        $html .= "<tr>";
        $html .= '<td>'.$article->getLibelle().'</td>';
        $html .= '<td id="prixarticleId'.$article->getId().'">'.$article->getPrixUnitaire().'</td>';
        $html .= '<td><input type="number" name="qte" min="1" value="1" max="'.$article->getStock().'" class="form-control" id="articleId'.$article->getId().'" placeholder="Quantite" required onchange="myFunction(this.value, '.$article->getId().')"/></td>';
        $html .= '<td id="soustotalarticleId'.$article->getId().'">'.$article->getPrixUnitaire().'</td>';
        $html .= '<td><a type="button" class="btn btn-danger" href="#" onclick=removeRow(this)>X</a></td>';
        $html .= "</tr>";
        // $articles= $this->get('serializer')->serialize($article,'json');
        // $normalizer = new ObjectNormalizer();
        // $encoder = new JsonEncoder();
        // $serializer = new Serializer(array($normalizer), array($encoder));
        // $response = new Response($serializer->serialize($articles, JsonEncoder::FORMAT, [JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT]));
        // $response->headers->set('Content-Type', 'application/json');        
        return new JsonResponse([
            'html' => $html,
            'id' => $article->getId(),
            'qte' => 1,
            // 'articles'=>$response
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
