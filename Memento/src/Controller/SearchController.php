<?php


namespace App\Controller;


use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search" , methods={"GET","POST"})
     */
    public function baseSearch(Request $request)
    {
        /*$request = $this->get('request_stack')->getMasterRequest();*/

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isEmpty() && $form->isValid() ) {

            $dataSearch = $form['term']->getData();

           return $this->redirectToRoute('article_search',[
                 'dataSearch' => $dataSearch,
             ]);
        }

        return $this->render('home/searchForm.html.twig', [
            'resultatsearch' => $form->createView(),
        ]);
    }


}