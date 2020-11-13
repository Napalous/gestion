<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SiteRepository;
use DateTime;

class FactureController extends AbstractController
{
    /**
     * @Route("/facture", name="facture")
     */
    public function index(SiteRepository $siteRepository): Response
    {
        $site=$siteRepository->findAll();
        $sit=$site[0];      
        $datefacture=new DateTime();  
        return $this->render('facture/index.html.twig', [
            'controller_name' => 'FactureController',
            'sites' => $sit,
            'datefacture'=>$datefacture
        ]);
    }
}
