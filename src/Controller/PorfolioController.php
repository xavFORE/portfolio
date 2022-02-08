<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Form\UploadType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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

    public function CVK(): Response
    {
        return $this->render('porfolio/CVK.html.twig', [
            'controller_name' => 'PorfolioController',
        ]);
    }

    public function CVH(): Response
    {
        return $this->render('porfolio/CVH.html.twig', [
            'controller_name' => 'PorfolioController',
        ]);
    }

    public function damierBack(): Response
    {
        $ligne = 8;
        $colone = 8;

        $html = "<table>\n";
        for ($i = 0; $i < $ligne; $i++) {
            // la ligne est-elle pair ?
            if ($i % 2 == 0) {
                $html .= "<tr>\n";
                for ($j = 0; $j < $colone; $j++) {
                    // la colonne est-elle pair ?
                    if ($j % 2 == 0)
                        $class = "class='noir'";
                    else
                        $class = "class='blanc'";
                    $html .=  "<td $class>\n";
                    $html .=  "</td>\n";
                }
                $html .=  "</tr>\n";
            }
            // sinon
            else {
                $html .=  "<tr>\n";
                for ($j = 0; $j < $colone; $j++) {
                    if ($j % 2 == 0)
                        $class = "class='blanc'";
                    else
                        $class = "class='noir'";
                    $html .= "<td $class>\n";
                    $html .= "</td>\n";
                }
                $html .= "</tr>\n";
            }
        }
        $html .= "</table>\n";

        return $this->render('porfolio/damier.html.twig', [
            'damier' => $html,
        ]);
    }

    public function damierFront(): Response
    {
        return $this->render('porfolio/base.html.twig', [
            'controller_name' => 'PorfolioController',
        ]);
    }

    public function contact(): Response
    {
        return $this->render('porfolio/index.html.twig', [
            'controller_name' => 'PorfolioController',
        ]);
    }

    public function upload(Request $request, SluggerInterface $slugger): Response
    {
        $up = new Upload();
        $formulaire = $this->createForm(UploadType::class, $up);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $file = $formulaire->get('ficName')->getData();

            if ($file) {
                //return new Response( " fichier : $file ");
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $originalExt = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                //return new Response( " fichier : $originalFilename . $originalExt uploadé ");
                $fullOrigineFileName = $originalFilename . "." . $originalExt;

                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $originalExt;


                // Move the file to the directory where brochures are stored


                try {
                    $file->move(
                        $this->getParameter('path_upload'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $up->setFicName($newFilename);
                $up->setFicNameOrigine($fullOrigineFileName);

                $doctrine = $this->getDoctrine();
                $entityManager = $doctrine->getManager();

                $entityManager->persist($up); // On confie notre entit&#xE9; &#xE0; l'entity manager (on persist l'entit&#xE9;)
                $entityManager->flush();


                return new Response(" fichier : $newFilename uploadé ");

                //return $this->redirectToRoute('CVK');

            }
        }

        return $this->render('porfolio/upload.html.twig', [
            'myForm' => $formulaire->createView(),
        ]);
    }


    public function downloadlist(): Response
    {
        $doctrine = $this->getDoctrine();
        //$patro = $doctrine->getRepository(Patronyme::class)->find($id);

        $uploads = $doctrine->getRepository(Upload::class)->findAll();

        return $this->render(
        'porfolio/downloadlist.html.twig', 
        [
            'listUp' => $uploads
        ]);    



        return $this->render('porfolio/upload.html.twig', [
            'myForm' => $formulaire->createView(),
        ]);
    }
    public function download(Upload $id): Response
    {
        return $this->render(
        'porfolio/download.html.twig', 
        [   
            'upload' => $id
        ]);    



        return $this->render('porfolio/upload.html.twig', [
            'myForm' => $formulaire->createView(),
        ]);
    }
}
