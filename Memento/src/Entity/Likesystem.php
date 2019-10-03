<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime
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


}
