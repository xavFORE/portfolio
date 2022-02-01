<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PorfolioController extends AbstractController
{
    /**
     * @Route("/porfolio", name="porfolio")
     */
    public function index(): Response
    {
        return $this->render('porfolio/base.html.twig', [
            'controller_name' => 'PorfolioController',
        ]);
    }


public function CV(): Response
{
    return $this->render('porfolio/CV.html.twig', [
        'controller_name' => 'PorfolioController',
    ]);
}
public function damierBack(): Response
{
    return $this->render('porfolio/index.html.twig', [
        'controller_name' => 'PorfolioController',
    ]);
}

public function damierFront(): Response
{
    return $this->render('porfolio/index.html.twig', [
        'controller_name' => 'PorfolioController',
    ]);
}

public function contact(): Response
{
    return $this->render('porfolio/index.html.twig', [
        'controller_name' => 'PorfolioController',
    ]);
}








}
