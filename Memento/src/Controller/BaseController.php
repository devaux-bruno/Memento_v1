<?php


namespace App\Controller;

use App\Entity\Languages;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{

    public function baseRender()
    {
        $doctrine = $this->getDoctrine();

        $languagesRepository = $doctrine->getRepository(Languages::class);
        $resultatedit= $languagesRepository->findAll();


        return $this->render('home/lang_list.html.twig', [
            'resultatshow' => $resultatedit,
        ]);
    }
}