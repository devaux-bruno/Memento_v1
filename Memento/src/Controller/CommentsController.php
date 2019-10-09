<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Comments;
use App\Form\CommentAdminType;
use App\Form\CommentsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController  extends AbstractController
{

    /**
     * @Route("/admin/comments", name="comments_index")
     */
    public function index()
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Comments::class);
        $resultatcomment= $userRepository->findAll();

        return $this->render('admin/index_comment.html.twig', [
            'resultatcomment' => $resultatcomment
        ]);
    }

    /**
     * @Route("/admin/addComments", name="admin_comment_add")
     */
    public function addAdminComment(Request $request)
    {
        $userComment = new Comments();

        $form = $this->createForm(CommentAdminType::class, $userComment, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isEmpty() && $form->isValid()) {

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $userComment->setCommentCreatedAt(new \DateTime()) ;

            $entityManager->persist($userComment);
            $entityManager->flush();

            $this->addFlash('success', 'Le commentaire a bien été ajouté!');

            return $this->redirectToRoute('comments_admin_add', []);

        }
        return $this->render('admin/comments_admin_add.html.twig', [
            'formAjoutcomment' => $form->createView(),
        ]);
    }


    /**
     * @Route("admin/comment-delete/{commentId}", name="admin_comment_delete")
     */
    public function deleteComment(Comments $commentId)
    {
        $idUser = $this->getUser();

        $commentUserId = $commentId->getCommentUser();
        $statusUserComment = $idUser->getUserStatus();

        if($idUser != $commentUserId && $statusUserComment == 'admin') {

            $this->addFlash('error', 'Tu ne peux pas supprimmer les commentaires d\'un autre Admin!');
            return $this->redirectToRoute('comments_index',[]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Comments::class)->find($commentId);


        if (!$comment) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de commentaire n° '.$commentId
            );
        }
        $entityManager->remove($comment);
        $entityManager->flush();

        $this->addFlash('success', 'Le commentaire a bien été supprimé!');

        return $this->redirectToRoute('comments_index',[]);
    }

    /**
     * @Route("member/comment-delete/{commentId}", name="member_comment_delete")
     */
    public function deleteMemberComment(Comments $commentId)
    {
        $idUser = $this->getUser();

        $commentUserId = $commentId->getCommentUser();

        if($idUser != $commentUserId) {

            $this->addFlash('error', 'Tu ne peux pas supprimmer les commentaires de quelqu\'un d\'autre!');
            return $this->redirectToRoute('profil_index',[]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Comments::class)->find($commentId);

        if (!$comment) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de commentaire n° '.$commentId
            );
        }
        $entityManager->remove($comment);
        $entityManager->flush();

        $this->addFlash('success', 'Le commentaire a bien été supprimé!');

        return $this->redirectToRoute('comments_index',[]);
    }

    /**
     * @Route("/admin/editcomment/{commentId}", name="member_comment_edit")
     */
    public function editMemberComment(Request $request, Comments $commentId)
    {
        $idUser = $this->getUser();
        $commentUserId = $commentId->getCommentUser();

        if($idUser != $commentUserId) {
            $this->addFlash('error', 'Tu ne peux pas modifier le commentaires de quelqu\'un d\'autre!');
            return $this->redirectToRoute('profil_index',[]);
        }

        $form = $this->createForm(CommentsType::class, $commentId, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isEmpty() && $form->isValid()) {

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $commentId->setCommentCreatedAt(new \DateTime()) ;

            $entityManager->persist($commentId);
            $entityManager->flush();

            $this->addFlash('success', 'Votre commentaire a bien été modifié!');

            return $this->redirectToRoute('profil_index', []);

        }
        return $this->render('member/comments_edit.html.twig', [
            'formAjoutcomment' => $form->createView(),
        ]);
    }


    /**
     * @Route("/member/comments/read/{commentArticle}", name="comments_read")
     */
    public function readComment(Request $request, Articles $articleId)
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Comments::class);
        $resultatComment= $userRepository->findby(['commentArticle'=> $articleId]);

        return $this->render('home/comment_read.html.twig',
            ['resultatComment' => $resultatComment]);
    }
}