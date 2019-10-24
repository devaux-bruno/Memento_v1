<?php


namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Likesystem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LikeSystemController extends AbstractController
{

    /**
     * @Route("/member/article-vote-yes/{articleId}", name="likesystem_yes")
     */
    public function voteYes(Articles $articleId)
    {
        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $idUser = $this->getUser();

        $userLike = $doctrine->getRepository(Likesystem::class);
        $resultatlike = $userLike->findIfUserAllReadyVote($idUser, $articleId);

        if($resultatlike === null || empty($resultatlike))
        {
            $likeArticle = new Likesystem();

            $likeArticle->setLikeUser($idUser);
            $likeArticle->setLikeCreatedAt(new \DateTime());
            $likeArticle->setLikeArticle($articleId);
            $likeArticle->setLikeNote('yes');

            $entityManager->persist($likeArticle);
            $entityManager->flush();

            $this->addFlash('success', 'Merci d\'avoir noté cet article');

            return $this->redirectToRoute('article',
                ['articleId' => $articleId->getArticleId(),
                    '_fragment' => 'like'
                ]);
        }

        $resultatvote = $userLike->findIfUserVoteNo($idUser, $articleId);
        if($resultatvote)
        {
            $likeArticle = $userLike->findOneBy(['likeUser'=> $idUser , 'likeArticle' => $articleId]);

            $likeArticle->setLikeCreatedAt(new \DateTime());
            $likeArticle->setLikeNote('yes');

            $entityManager->persist($likeArticle);
            $entityManager->flush();

            $this->addFlash('success', 'Votre vote a bien été changé');

            return $this->redirectToRoute('article',
                ['articleId' => $articleId->getArticleId(),
                    '_fragment' => 'like'
                ]);
        }

        $this->addFlash('error', 'Votre ne pouvez que modifier votre vote et non voter plusieurs fois.');

        return $this->redirectToRoute('article',
            ['articleId' => $articleId->getArticleId(),
                '_fragment' => 'like'
            ]);
    }

    /**
     * @Route("/member/article-vote-no/{articleId}", name="likesystem_no")
     */
    public function voteNo(Articles $articleId)
    {
        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $idUser = $this->getUser();

        $userLike = $doctrine->getRepository(Likesystem::class);
        $resultatlike = $userLike->findIfUserAllReadyVote($idUser, $articleId);

        if($resultatlike === null || empty($resultatlike))
        {
            $likeArticle = new Likesystem();

            $likeArticle->setLikeUser($idUser);
            $likeArticle->setLikeCreatedAt(new \DateTime());
            $likeArticle->setLikeArticle($articleId);
            $likeArticle->setLikeNote('yes');

            $entityManager->persist($likeArticle);
            $entityManager->flush();

            $this->addFlash('success', 'Merci d\'avoir noté cet article');

            return $this->redirectToRoute('article',
                ['articleId' => $articleId->getArticleId(),
                    '_fragment' => 'like'
                ]);
        }

        $resultatvote = $userLike->findIfUserVoteYes($idUser, $articleId);
        if($resultatvote)
        {
            $likeArticle = $userLike->findOneBy(['likeUser'=> $idUser , 'likeArticle' => $articleId]);

            $likeArticle->setLikeCreatedAt(new \DateTime());
            $likeArticle->setLikeNote('no');

            $entityManager->persist($likeArticle);
            $entityManager->flush();

            $this->addFlash('success', 'Votre vote a bien été changé');

            return $this->redirectToRoute('article',
                ['articleId' => $articleId->getArticleId(),
                    '_fragment' => 'like'
                ]);
        }
        $this->addFlash('error', 'Votre ne pouvez que modifier votre vote et non voter plusieurs fois.');
        return $this->redirectToRoute('article',
            ['articleId' => $articleId->getArticleId(),
                '_fragment' => 'like'
            ]);
    }

}