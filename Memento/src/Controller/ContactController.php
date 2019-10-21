<?php


namespace App\Controller;

use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request,  Swift_Mailer $mailer)
    {

        $form = $this->createForm(\App\Form\ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactData = $form->getData();

            $message = (new Swift_Message('Nouveau message de contact - Memento'))
                ->setFrom($contactData['email'])
                ->setTo('contact@devaux-bruno.com')
                ->setBody(
                    $this->renderView('email/contactmail.html.twig', [
                        'prenom' => $contactData['firstname'],
                        'nom' => $contactData['lastname'],
                        'sujet' => $contactData['subject'],
                        'message' => $contactData['message'],
                    ]),
                    'text/html'
                )
            ;

            $mailer->send($message);

            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute('contact');

            // do something interesting here
        }


        return $this->render('home/contact.html.twig',[
            'contact' => $form->createView(),
        ]);
    }
}