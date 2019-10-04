<?php


namespace App\Controller;


use App\Entity\Languages;
use App\Form\LanguagesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LanguagesController extends AbstractController
{

    /**
     * @Route("admin/languages", name="lang_index")
     */
    public function indexLang()
    {
        $doctrine = $this->getDoctrine();

        $langRepository = $doctrine->getRepository(Languages::class);
        $resultatedit= $langRepository->findAll();

        return $this->render('admin/index_lang.html.twig',
            ['resultatedit' => $resultatedit ]);
    }


    /**
     * @Route("/admin/addLanguages", name="lang_add")
     */
    public function addLang(Request $request)
    {
        $lang = new Languages();

        $formLang = $this->createForm(LanguagesType::Class, $lang, []);
        $formLang->handleRequest($request);

        if( $formLang->isSubmitted() && !$formLang->isEmpty() && $formLang->isValid())
        {

            if($lang->getLangPicture() != '' || $lang->getLangPicture() != null ) {
                //ajout d'une photo
                $file = $formLang->get('langPicture')->getData();
                //$file = $user->getCustomerPicture();
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('languages_pictures_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Un problème est survenue sur votre photo lors de l\'enregistrement!');

                    return $this->redirectToRoute('home', []);
                }
            }

            $lang->setLangPicture($fileName);
            $lang->setLangCreatedAt(new \DateTime()) ;

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($lang);
            $entityManager->flush();

            $this->addFlash('success', 'Le nouveau language a bien été enregistré!');

            return $this->redirectToRoute('lang_index',[]);


        }
        return $this->render('admin/lang_add.html.twig',[
            'formAjout' => $formLang->createView(),
        ]);
    }

    /**
     * @Route("admin/lang/delete/{langId}", name="lang_delete")
     */
    public function deleteLang(Languages $langId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $lang = $entityManager->getRepository(Languages::class)->find($langId);

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $langpicture = $entityManager->getRepository(Languages::class)->find($langId)->getLangPicture();


        if (!$lang) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de Langue avec '.$langId
            );
        }
        if(!empty($langpicture)) {
            //suppression de l'ancienne photo
            $fichierSupp = $this->getParameter('languages_pictures_directory');
            unlink($fichierSupp . $langpicture);
            $fs = new Filesystem();
            $fs->remove($fichierSupp . $langId->getLangPicture());
        }

        $entityManager->remove($lang);
        $entityManager->flush();

        $this->addFlash('success', 'Le laguage a bien été supprimé!');

        return $this->redirectToRoute('lang_index',[]);
    }

    /**
     * @Route("/admin/lang/edit/{langId}", name="admin_lang_edit")
     */
    public function adminEditLang(Request $request, Languages $langId)
    {


        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $langPicture = $entityManager->getRepository(Languages::class)->find($langId)->getLangPicture();


        $form = $this->createForm(LanguagesType::class, $langId, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {

            if($langId->getLangPicture() != '' || $langId->getLangPicture() != null ){
                if( !empty($customerpicture)){
                    //suppression de l'ancienne photo
                    $fichierSupp = $this->getParameter('languages_pictures_directory');
                    unlink($fichierSupp.$langPicture);
                    $fs = new Filesystem();
                    $fs->remove($fichierSupp.$langId->getLangPicture());

                    //update de la nouvelle photo
                    $file = $form->get('langPicture')->getData();
                    $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('languagesl_pictures_directory'),
                            $fileName
                        );
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Un problème est survenue sur votre photo lors de la modification!');

                        return $this->redirectToRoute('admin_lang_edit', []);
                    }
                }
                else{
                    //ajout d'une photo
                    $file = $form->get('langPicture')->getData();
                    //$file = $user->getCustomerPicture();
                    $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('languages_pictures_directory'),
                            $fileName
                        );
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Un problème est survenue sur votre photo lors de l\'enregistrement!');

                        return $this->redirectToRoute('admin_lang_edit', []);
                    }
                }
            }
            else{
                $fileName='';
            }


            $langId->setLangPicture($fileName);
            $langId->setLangCreatedAt(new \DateTime()) ;
            $entityManager->persist($langId);
            $entityManager->flush();

            $this->addFlash('success', 'Le language a bien été modifié!');

            return $this->redirectToRoute('lang_index',[]);

        }

        return $this->render('admin/lang_edit.html.twig',[
            'formAdminEdit' => $form->createView(),
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