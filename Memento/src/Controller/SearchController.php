<?php


namespace App\Controller;

use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{

    public function baseSearch(Request $request)
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isEmpty()) {

            $dataSearch = $form['term']->getData();

            return $this->redirectToRoute('article_search', [
                'resultatsearch' => $dataSearch,
            ]);

        }

        return $this->render('home/searchForm.html.twig', [
            'resultatsearch' => $form->createView(),
        ]);
    }

}