<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Likesystem
 *
 * @ORM\Table(name="likesystem", indexes={@ORM\Index(name="like_user_id", columns={"like_user_id"}), @ORM\Index(name="like_article_id", columns={"like_article_id"})})
 * @ORM\Entity
 */
class Likesystem
{
    /**
     * @var int
     *
     * @ORM\Column(name="like_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $likeId;

    /**
     * @var string
     *
     * @ORM\Column(name="like_note", type="string", length=60, nullable=false)
     */
    private $likeNote;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="like_created_at", type="datetime", nullable=false)
     */
    private $likeCreatedAt;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="usersLikesystem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="like_user_id", referencedColumnName="user_id")
     * })
     */
    private $likeUser;

    /**
     * @var Articles
     *
     * @ORM\ManyToOne(targetEntity="Articles", inversedBy="articlesLikesystem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="like_article_id", referencedColumnName="article_id")
     * })
     */
    private $likeArticle;

    /**
     * @return int
     */
    public function getLikeId()
    {
        return $this->likeId;
    }

    /**
     * @param int $likeId
     * @return Likesystem
     */
    public function setLikeId($likeId)
    {
        $this->likeId = $likeId;
        return $this;
    }

    /**
     * @return string
     */
    public function getLikeNote()
    {
        return $this->likeNote;
    }

    /**
     * @param string $likeNote
     * @return Likesystem
     */
    public function setLikeNote($likeNote)
    {
        $this->likeNote = $likeNote;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLikeCreatedAt()
    {
        return $this->likeCreatedAt;
    }

    /**
     * @param DateTime $likeCreatedAt
     * @return Likesystem
     */
    public function setLikeCreatedAt($likeCreatedAt)
    {
        $this->likeCreatedAt = $likeCreatedAt;
        return $this;
    }

    /**
     * @return Users
     */
    public function getLikeUser()
    {
        return $this->likeUser;
    }

    /**
     * @param Users $likeUser
     * @return Likesystem
     */
    public function setLikeUser($likeUser)
    {
        $this->likeUser = $likeUser;
        return $this;
    }

    /**
     * @return Articles
     */
    public function getLikeArticle()
    {
        return $this->likeArticle;
    }

    /**
     * @param Articles $likeArticle
     * @return Likesystem
     */
    public function setLikeArticle($likeArticle)
    {
        $this->likeArticle = $likeArticle;
        return $this;
    }






}
