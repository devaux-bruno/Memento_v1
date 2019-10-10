<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Comments
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="comment_user_id", columns={"comment_user_id"}), @ORM\Index(name="comment_user_article", columns={"comment_article_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\CommentsRepository")
 */
class Comments
{
    /**
     * @var int
     *
     * @ORM\Column(name="comment_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $commentId;

    /**
     * @var string
     *
     * @ORM\Column(name="comment_text", type="text", length=0, nullable=false)
     */
    private $commentText;

    /**
     * @var string
     *
     * @ORM\Column(name="comment_status", type="string", length=60, nullable=false)
     */
    private $commentStatus;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="comment_created_at", type="datetime", nullable=false)
     */
    private $commentCreatedAt;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="usersComments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="comment_user_id", referencedColumnName="user_id")
     * })
     */
    private $commentUser;

    /**
     * @var Articles
     *
     * @ORM\ManyToOne(targetEntity="Articles", inversedBy="articlesComments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="comment_article_id", referencedColumnName="article_id")
     * })
     */
    private $commentArticle;

    /**
     * @return int
     */
    public function getCommentId()
    {
        return $this->commentId;
    }

    /**
     * @param int $commentId
     * @return Comments
     */
    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommentText()
    {
        return $this->commentText;
    }

    /**
     * @param string $commentText
     * @return Comments
     */
    public function setCommentText($commentText)
    {
        $this->commentText = $commentText;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommentStatus()
    {
        return $this->commentStatus;
    }

    /**
     * @param string $commentStatus
     * @return Comments
     */
    public function setCommentStatus($commentStatus)
    {
        $this->commentStatus = $commentStatus;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCommentCreatedAt()
    {
        return $this->commentCreatedAt;
    }

    /**
     * @param DateTime $commentCreatedAt
     * @return Comments
     */
    public function setCommentCreatedAt($commentCreatedAt)
    {
        $this->commentCreatedAt = $commentCreatedAt;
        return $this;
    }

    /**
     * @return Users
     */
    public function getCommentUser()
    {
        return $this->commentUser;
    }

    /**
     * @param Users $commentUser
     * @return Comments
     */
    public function setCommentUser($commentUser)
    {
        $this->commentUser = $commentUser;
        return $this;
    }

    /**
     * @return Articles
     */
    public function getCommentArticle()
    {
        return $this->commentArticle;
    }

    /**
     * @param Articles $commentArticle
     * @return Comments
     */
    public function setCommentArticle($commentArticle)
    {
        $this->commentArticle = $commentArticle;
        return $this;
    }




}
