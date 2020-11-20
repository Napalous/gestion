<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncode;

/**
 * @Route("/devis")
 */
class DevisController extends AbstractController
{
    /**
     * @Route("/", name="devis")
     */
    public function index(): Response
    {
        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
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


        return new JsonResponse([
            'article1' => $article->getId(),
            'article2' => $article->getLibelle(),
            'article3' => $article->getPrixUnitaire(),
            'article4' => $article->getStock(),
            // 'id' => $article->getId(),
            // 'qte' => 1,
            // 'articles'=>$response
        ]);
    }
}
