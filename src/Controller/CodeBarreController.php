<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\SearchType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class CodeBarreController extends AbstractController
{
    /**
     * @Route("/code/barre", name="code_barre")
     */
    public function index(): Response
    {
        $tab=[];
        for($i=0;$i<9;$i++)
        {

            $tab[$i]=rand(0000000000001,1200000000000000000);
            // dump(rand(0000000000001,1200000000000000000));
            // die();
            // ."".chr(rand(65,90));
        }
        $code=rand(0000000000001,1200000000000000000);
        $code2=rand(0000000000001,1200000000000000000);
        $code3=rand(0000000000001,1200000000000000000);
        $code4=rand(0000000000001,1200000000000000000);
        $code5=rand(0000000000001,1200000000000000000);
        $code6=rand(0000000000001,1200000000000000000);
        $code7=rand(0000000000001,1200000000000000000);
        $code8=rand(0000000000001,1200000000000000000);
        $code9=rand(0000000000001,1200000000000000000);

        dump($tab);
        // die();
        return $this->render('code_barre/index.html.twig', [
            'codebarres'=>$tab,
            'code'=>$code,
            'code2'=>$code2,
            'code3'=>$code3,
            'code4'=>$code4,
            'code5'=>$code5,
            'code6'=>$code6,
            'code7'=>$code7,
            'code8'=>$code8,
            'code9'=>$code9,
            'controller_name' => 'CodeBarreController',
        ]);
    }

    /**
     * @Route("/recherche", name="search")
     */
    public function recherche(Request $request, ArticleRepository $repo, PaginatorInterface $paginator) {

        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);
        
        $donnees = $repo->findAll();
 
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
 
            $title = $searchForm->getData()->getCodebarre();

            $donnees = $repo->search($title);


            if ($donnees == null) {
                $this->addFlash('erreur', 'Aucun article contenant ce mot clé dans le titre n\'a été trouvé, essayez en un autre.');
           
            }

    }

     // Paginate the results of the query
     $articles = $paginator->paginate(
        // Doctrine Query, not results
        $donnees,
        // Define the page parameter
        $request->query->getInt('page', 1),
        // Items per page
        4
    );

        return $this->render('vente/achat.html.twig',[
            'articles' => $articles,
            'searchForm' => $searchForm->createView()
        ]);
    }

    /**
     * @Route("/scanner", name="scanner")
     */
    public function index2()
    {
        $code = '';
        if (isset($_POST['code']))
        {
            $code = $_POST['code'];
        }
        $line = '';
        $line.= '<tr>';
        $line.= '<td> $produit.libelle</td>';
        $line.= '<td> $produit.prix</td>';
        $line.= '</tr>';
        return $this->render('vente/achat.html.twig', compact('line'));
    }


}
