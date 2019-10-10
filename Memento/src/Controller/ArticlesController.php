<?php


namespace App\Controller;


use App\Entity\Articles;
use App\Entity\Comments;
use App\Entity\Languages;
use App\Entity\Likesystem;
use App\Form\AdminArticleType;
use App\Form\ArticleType;
use App\Form\CommentsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{

    /**
     * @Route("member/addArticle", name="article_add")
     */
    public function addArticle(Request $request)
    {
        $article = new Articles();

        $user = $this->getUser();

        $form = $this->createForm(ArticleType::Class, $article, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && !$form->isEmpty() && $form->isValid())
        {
            if($article->getArticlePicture() != '' || $article->getArticlePicture() != null ){
                //ajout d'une photo
                $file = $form->get('articlePicture')->getData();
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('article_pictures_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Un problème est survenue sur la photo de l\'article lors de l\'enregistrement!');

                    return $this->redirectToRoute('article_add', []);
                }
            }
            else{
                $fileName = '';
            }

            $article->setArticlePicture($fileName);
            $article->setArticleCreateAt(new \DateTime()) ;
            $article->setArticleUser($user);
            $article->setArticleValid('waiting_validation');


            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Votre Article a bien été enregistré, il sera publié après validation!');

            return $this->redirectToRoute('profil_index',[]);

        }
        return $this->render('member/article_add.html.twig',[
            'formAjoutarticle' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/article", name="article_index")
     */
    public function indexArticle()
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Articles::class);
        $resultatedit= $userRepository->findAll();

        return $this->render('admin/index_article.html.twig', ['resultatedit' => $resultatedit]);
    }

    /**
     * @Route("article/lang/{langId}", name="article_by_languages")
     */
    public function indexLanguages(Languages $langId)
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Articles::class);
        $resultatedit= $userRepository->findBy(['articleLanguage' => $langId],['articleCreateAt' => 'Desc']);

        return $this->render('home/index_languages.html.twig', ['resultatedit' => $resultatedit]);
    }

    /**
     * @Route("article/{articleId}", name="article")
     */
    public function readArticle(Articles $articleId)
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Articles::class);
        $resultatArticle= $userRepository->find($articleId);

        $userComment = new Comments();

        $commentUser = $this->getUser();
        $request = $this->get('request_stack')->getMasterRequest();

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        $likeRepository = $doctrine->getRepository(Likesystem::class);
        $resultatLike = $likeRepository->findIfUserAllReadyVote($commentUser, $articleId);

        $form = $this->createForm(CommentsType::class, $userComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isEmpty() && $form->isValid()) {

            $userComment->setCommentCreatedAt(new \DateTime()) ;
            $userComment->setCommentUser($commentUser);
            $userComment->setCommentArticle($articleId);
            $userComment->setCommentStatus('published');


            $entityManager->persist($userComment);
            $entityManager->flush();

            $this->addFlash('success', 'Le commentaire a bien été ajouté!');

            return $this->redirectToRoute('article',
                ['resultatLike' => $resultatLike,
                    'articleId' => $articleId->getArticleId(),
                    '_fragment' => 'commentaires'
                ]);

        }

        return $this->render('home/article.html.twig', [
            'resultatLike' => $resultatLike,
            'resultatArticle' => $resultatArticle,
            'formAjoutcomment' => $form->createView(),
            ]);
    }

    /**
     * @Route("admin/addArticle", name="admin_article_add")
     */
    public function adminAddArticle(Request $request)
    {
        $article = new Articles();

        $form = $this->createForm(AdminArticleType::Class, $article, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && !$form->isEmpty() && $form->isValid())
        {
            if($article->getArticlePicture() != '' || $article->getArticlePicture() != null ){
                //ajout d'une photo
                $file = $form->get('articlePicture')->getData();
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('article_pictures_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Un problème est survenue sur la photo de l\'article lors de l\'enregistrement!');

                    return $this->redirectToRoute('article_add', []);
                }
            }
            else{
                $fileName = '';
            }

            $article->setArticlePicture($fileName);
            $article->setArticleCreateAt(new \DateTime()) ;
            $article->setArticleValid('public');


            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'l\'article a bien été enregistré et publié!');

            return $this->redirectToRoute('profil_index',[]);

        }
        return $this->render('admin/article_admin_add.html.twig',[
            'formAjoutarticle' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/Article-edit/{articleId}", name="admin_article_edit")
     */
    public function adminArticleEdit(Request $request, Articles $articleId)
    {

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $articlePicture = $entityManager->getRepository(Articles::class)->find($articleId)->getArticlePicture();

        $form = $this->createForm(AdminArticleType::Class, $articleId, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && !$form->isEmpty() && $form->isValid())
        {
            if($articleId->getArticlePicture() != '' || $articleId->getArticlePicture() != null )
            {
                if( !empty($articlePicture))
                {
                    $file = $form->get('articlePicture')->getData();
                    if( !empty($file) )
                    {
                        $this->addFlash('error', 'je suis la!');

                        //suppression de l'ancienne photo
                        $fichierSupp = $this->getParameter('article_pictures_directory');
                        unlink($fichierSupp . $articlePicture);
                        $fs = new Filesystem();
                        $fs->remove($fichierSupp.$articleId->getArticlePicture());

                        //update de la nouvelle photo
                        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                        try {
                            $file->move(
                                $this->getParameter('article_pictures_directory'),
                                $fileName
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Un problème est survenue sur la photo de l\'article lors de la modification!');

                            return $this->redirectToRoute('admin_article_edit', []);
                        }
                    }
                    else{
                        $fileName= $articlePicture;
                    }
                }
                else{
                    $file = $form->get('articlePicture')->getData();
                    if( !empty($file) ) {
                        //ajout d'une photo
                        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                        try {
                            $file->move(
                                $this->getParameter('article_pictures_directory'),
                                $fileName
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Un problème est survenue sur la photo lors de l\'enregistrement!');

                            return $this->redirectToRoute('admin_article_edit', []);
                        }
                    }
                    else{
                        $fileName= $articlePicture;
                    }
                }
            }
            else{
                $fileName= $articlePicture;
            }

            $articleId->setArticlePicture($fileName);
            $articleId->setArticleCreateAt(new \DateTime()) ;


            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($articleId);
            $entityManager->flush();

            $this->addFlash('success', 'l\'article a bien été enregistré!');

            return $this->redirectToRoute('article_index',[]);

        }
        return $this->render('admin/article_admin_add.html.twig',[
            'formAjoutarticle' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/article-delete/{articleId}", name="article_admin_delete")
     */
    public function deleteArticle(Articles $articleId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Articles::class)->find($articleId);

        if (!$article) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de d\'article avec l\'ID n°'.$article.'!'
            );
        }
        $articlePicture = $entityManager->getRepository(Articles::class)->find($articleId)->getArticlePicture();
        if( !empty($articlePicture))
        {
            //suppression de l'ancienne photo
            $fichierSupp = $this->getParameter('article_pictures_directory');
            unlink($fichierSupp . $articlePicture);
            $fs = new Filesystem();
            $fs->remove($fichierSupp.$articleId->getArticlePicture());
        }

        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash('success', 'L\'article a bien été supprimé!');

        return $this->redirectToRoute('article_index',[]);
    }

    /**
     * @Route("member/article-delete/{articleId}", name="member_article_delete")
     */
    public function deleteMemberArticle(Articles $articleId)
    {
        $idUser = $this->getUser()->getUserId();
        $numIdUser = $articleId->getArticleUser()->getUserId();

        if($idUser != $numIdUser ) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer que vos articles');
            return $this->redirectToRoute('home',[]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Articles::class)->find($articleId);

        if (!$article) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de d\'article avec l\'ID n°'.$article.'!'
            );
        }
        $articlePicture = $entityManager->getRepository(Articles::class)->find($articleId)->getArticlePicture();
        if( !empty($articlePicture))
        {
            //suppression de l'ancienne photo
            $fichierSupp = $this->getParameter('article_pictures_directory');
            unlink($fichierSupp . $articlePicture);
            $fs = new Filesystem();
            $fs->remove($fichierSupp.$articleId->getArticlePicture());
        }

        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash('success', 'L\'article a bien été supprimé!');

        return $this->redirectToRoute('profil_index',[]);
    }

    /**
     * @Route("member/Article-edit/{articleId}", name="member_article_edit")
     */
    public function memberArticleEdit(Request $request, Articles $articleId)
    {

        $idUser = $this->getUser()->getUserId();
        $numIdUser = $articleId->getArticleUser()->getUserId();

        if($idUser != $numIdUser ) {
            $this->addFlash('error', 'Vous ne pouvez pas modifier que vos articles');
            return $this->redirectToRoute('home',[]);
        }

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $articlePicture = $entityManager->getRepository(Articles::class)->find($articleId)->getArticlePicture();

        $form = $this->createForm(ArticleType::Class, $articleId, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && !$form->isEmpty() && $form->isValid())
        {
            if($articleId->getArticlePicture() != '' || $articleId->getArticlePicture() != null )
            {
                if( !empty($articlePicture))
                {
                    $file = $form->get('articlePicture')->getData();
                    if( !empty($file) )
                    {
                        //suppression de l'ancienne photo
                        $fichierSupp = $this->getParameter('article_pictures_directory');
                        unlink($fichierSupp . $articlePicture);
                        $fs = new Filesystem();
                        $fs->remove($fichierSupp.$articleId->getArticlePicture());

                        //update de la nouvelle photo
                        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                        try {
                            $file->move(
                                $this->getParameter('article_pictures_directory'),
                                $fileName
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Un problème est survenue sur la photo de l\'article lors de la modification!');

                            return $this->redirectToRoute('admin_article_edit', []);
                        }
                    }
                    else{
                        $fileName= $articlePicture;
                    }
                }
                else{
                    $file = $form->get('articlePicture')->getData();
                    if( !empty($file) ) {
                        //ajout d'une photo
                        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                        try {
                            $file->move(
                                $this->getParameter('article_pictures_directory'),
                                $fileName
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Un problème est survenue sur la photo lors de l\'enregistrement!');

                            return $this->redirectToRoute('admin_article_edit', []);
                        }
                    }
                    else{
                        $fileName= $articlePicture;
                    }
                }
            }
            else{
                $fileName= $articlePicture;
            }

            $articleId->setArticlePicture($fileName);
            $articleId->setArticleCreateAt(new \DateTime()) ;
            $articleId->setArticleValid('waiting_validation');


            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($articleId);
            $entityManager->flush();

            $this->addFlash('success', 'L\'article a bien été modifié!');

            return $this->redirectToRoute('profil_index',[]);

        }
        return $this->render('member/article_edit.html.twig',[
            'formAjoutarticle' => $form->createView(),
        ]);
    }


    /**
     * @Route("/news", name="news_article")
     */
    public function index()
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Articles::class);
        $resultatedit= $userRepository->findAll();

        return $this->render('home/new_articles.html.twig',[
                'resultatedit' => $resultatedit
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