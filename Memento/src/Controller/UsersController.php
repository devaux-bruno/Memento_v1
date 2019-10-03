<?php


namespace App\Controller;


use App\Entity\Users;
use App\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends AbstractController
{


    /**
     * @Route("/inscription", name="user_add")
     */
    public function add(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new Users();

        $form = $this->createForm(UsersType::Class, $user, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && !$form->isEmpty() && $form->isValid())
        {
            //Permet de rajouter un encodage au mdp
            $encrypted = $encoder->encodePassword($user, $user->getUserPassword());
            $user->setUserPassword($encrypted);

            if($user->getUserPicture() != '' || $user->getUserPicture() != null ){
                //ajout d'une photo
                $file = $form->get('userPicture')->getData();
                //$file = $user->getCustomerPicture();
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('profil_pictures_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Un problème est survenue sur votre photo lors de l\'enregistrement!');

                    return $this->redirectToRoute('home', []);
                }


            }
            else{
                $fileName = '';
            }


            $user->setUserPicture($fileName);
            $user->setUserStatus('member');
            $user->setuserRegistration(new \DateTime()) ;

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte a bien été enregistré!');

            return $this->redirectToRoute('home',[]);

        }

        return $this->render('home/user_add.html.twig',[
            'formAjout' => $form->createView(),
        ]);
    }



    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}