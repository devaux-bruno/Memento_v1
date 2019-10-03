<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="comment_user_id", columns={"comment_user_id"}), @ORM\Index(name="comment_user_article", columns={"comment_article_id"})})
 * @ORM\Entity
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
     * @var \DateTime
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


}
