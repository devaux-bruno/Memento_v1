<?php


namespace App\Controller;


use App\Entity\Users;
use App\Form\newPasswordType;
use App\Form\StatusType;
use App\Form\UsersType;
use App\Form\UserEditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
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
     * @Route("admin/user", name="user_index")
     */
    public function index()
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Users::class);
        $resultatedit= $userRepository->findAll();

        return $this->render('admin/index_user.html.twig', ['resultatedit' => $resultatedit]);
    }

    /**
     * @Route("/member/profil", name="profil_index")
     */
    public function indexProfil()
    {

        $doctrine = $this->getDoctrine();
        $userId = $this->getUser()->getUserId();

        $userRepository = $doctrine->getRepository(\App\Entity\Users::class);
        $resultatuser= $userRepository->findAll();

        $articleRepository = $doctrine->getRepository(\App\Entity\Articles::class);
        $resultatarticle = $articleRepository->findby(['articleUser' => $userId]);

        $commentsRepository = $doctrine->getRepository(\App\Entity\Comments::class);
        $resultatComments = $commentsRepository->findby(['commentUser' => $userId]);

        return $this->render('member/profil.html.twig', [
            'resultatuser' => $resultatuser,
            'resultatarticle' => $resultatarticle,
            'resultatComments' => $resultatComments,
        ]);
    }

    /**
     * @Route("/member/userEdit/{userId}", name="user_edit")
     */
    public function edit(Request $request, Users $userId)
    {

        $idUser = $this->getUser()->getUserId();
        $numIdUser = $userId->getUserId();

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $userPicture = $entityManager->getRepository(Users::class)->find($userId)->getUserPicture();

        if($idUser != $numIdUser ) {
            $this->addFlash('error', 'Vous ne pouvez modifier que votre profil');
            return $this->redirectToRoute('home',[]);
        }

        $form = $this->createForm(UserEditType::class, $userId, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {

            if( !empty($userPicture) ){

                $file = $form->get('userPicture')->getData();

                if( !empty($file) ){
                    //suppression de l'ancienne photo
                    $fichierSupp = $this->getParameter('profil_pictures_directory');
                    unlink($fichierSupp.$userPicture);
                    $fs = new Filesystem();
                    $fs->remove($fichierSupp.$userId->getUserPicture());

                    //update de la nouvelle photo
                    $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('profil_pictures_directory'),
                            $fileName
                        );
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Un problème est survenue sur votre photo lors de la modification!');

                        return $this->redirectToRoute('user_edit', []);
                    }
                }
            }
            else{
                $file = $form->get('userPicture')->getData();
                if( !empty($file) ){
                    //ajout d'une photo
                    $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('profil_pictures_directory'),
                            $fileName
                        );
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Un problème est survenue sur votre photo lors de l\'enregistrement!');

                        return $this->redirectToRoute('user_edit', []);
                    }
                }
            }

            $userId->setUserPicture($fileName);
            $userId->setUserRegistration(new \DateTime()) ;
            $entityManager->persist($userId);
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a bien été modifié!');

            return $this->redirectToRoute('profil_index',[]);
        }
        return $this->render('member/user_edit.html.twig',[
            'formUserEdit' => $form->createView(),
        ]);
    }


    /**
     * @Route("/member/passwordEdit/{userId}", name="password_edit")
     */
    public function editPassword(Request $request, Users $userId, UserPasswordEncoderInterface $encoder)
    {

        // require the user to log in during *this* session
        // if they were only logged in via a remember me cookie, they
        // will be redirected to the login page
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $idUser = $this->getUser()->getUserId();
        $numIdUser = $userId->getUserId();

        if($idUser != $numIdUser ) {
            $this->addFlash('error', 'Vous ne pouvez modifier que votre profil');
            return $this->redirectToRoute('home',[]);
        }

        $form = $this->createForm(newPasswordType::class, $userId, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            $dataold = $form->get('userPassword')->getData();
            $datanew = $form->get('newPassword')->getData();
            $checkPassword = $encoder->isPasswordValid($userId, $dataold);

            if($checkPassword === true){

                $doctrine = $this->getDoctrine();
                $entityManager = $doctrine->getManager();

                $newPassword = $encoder->encodePassword($userId, $datanew);
                $userId->setUserPassword($newPassword);

                $entityManager->persist($userId);
                $entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a bien été modifié!');

                return $this->redirectToRoute('profil_index',[]);
            }
            else{
                $this->addFlash('error', 'Désolé, votre ancien mot de passe n\'est pas correct');
                return $this->redirectToRoute('password_edit', ['userId' => $idUser]);
            }
        }

        return $this->render('member/password_edit.html.twig',[
            'formUserEdit' => $form->createView(),
        ]);

    }



    /**
     * @Route("/admin/user-edit/{userId}", name="user_admin_edit")
     */
    public function adminEditProfil(Request $request, Users $userId, UserPasswordEncoderInterface $encoder)
    {

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $userPicture = $entityManager->getRepository(Users::class)->find($userId)->getUserPicture();

        $form = $this->createForm(UserEditType::class, $userId, []);
        $formadmin = $this->createForm(StatusType::class, $userId, []);
        $formadmin->handleRequest($request);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            if($userId->getUserPicture() != '' || $userId->getUserPicture() != null )
            {
                if( !empty($userPicture))
                {
                    $file = $form->get('userPicture')->getData();
                    if( !empty($file) )
                    {

                        //suppression de l'ancienne photo
                        $fichierSupp = $this->getParameter('profil_pictures_directory');
                        unlink($fichierSupp . $userPicture);
                        $fs = new Filesystem();
                        $fs->remove($fichierSupp.$userId->getUserPicture());

                        //update de la nouvelle photo
                        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                        try {
                            $file->move(
                                $this->getParameter('profil_pictures_directory'),
                                $fileName
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Un problème est survenue sur votre photo lors de la modification!');

                            return $this->redirectToRoute('user_admin_edit', []);
                        }
                    }
                }
                else{
                    $file = $form->get('userPicture')->getData();
                    if( !empty($file) ) {
                        //ajout d'une photo
                        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                        try {
                            $file->move(
                                $this->getParameter('profil_pictures_directory'),
                                $fileName
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Un problème est survenue sur votre photo lors de l\'enregistrement!');

                            return $this->redirectToRoute('admin_user_edit', []);
                        }
                    }
                }
            }
            else{
                $fileName='';
            }

            //Permet de rajouter un encodage au mdp
            $encrypted = $encoder->encodePassword($userId, $userId->getUserPassword());
            $userId->setUserPassword($encrypted);

            $userId->setUserPicture($fileName);
            $userId->setUserRegistration(new \DateTime()) ;
            $entityManager->persist($userId);
            $entityManager->flush();

            $this->addFlash('success', 'Le profil a bien été modifié!');
            return $this->redirectToRoute('user_index',[]);
        }
        return $this->render('admin/user_admin_edit.html.twig',[
            'formAdminEdit' => $form->createView(),
            'formAdminStatus' => $formadmin->createView()
        ]);

    }

    /**
     * @Route("admin/user-delete/{userId}", name="user_admin_delete")
     */
    public function delete(Users $userId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(Users::class)->find($userId);

        if (!$user) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de membre avec l\'ID n°'.$userId.'!'
            );
        }
        $userPicture = $entityManager->getRepository(Users::class)->find($userId)->getUserPicture();
        if( !empty($userPicture))
        {
            //suppression de l'ancienne photo
            $fichierSupp = $this->getParameter('profil_pictures_directory');
            unlink($fichierSupp . $userPicture);
            $fs = new Filesystem();
            $fs->remove($fichierSupp.$userId->getUserPicture());
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Le membre a bien été supprimé!');

        return $this->redirectToRoute('user_index',[]);
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