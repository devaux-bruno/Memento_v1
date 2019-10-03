<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="articles", indexes={@ORM\Index(name="article_user_id", columns={"article_user_id"}), @ORM\Index(name="article_language_id", columns={"article_language_id"})})
 * @ORM\Entity
 */
class Articles
{
    /**
     * @var int
     *
     * @ORM\Column(name="article_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $articleId;

    /**
     * @var string
     *
     * @ORM\Column(name="article_valid", type="string", length=60, nullable=false)
     */
    private $articleValid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="article_picture", type="string", length=255, nullable=true)
     */
    private $articlePicture;

    /**
     * @var string
     *
     * @ORM\Column(name="article_description", type="text", length=65535, nullable=false)
     */
    private $articleDescription;

    /**
     * @var int
     *
     * @ORM\Column(name="article_text", type="integer", nullable=false)
     */
    private $articleText;

    /**
     * @var int
     *
     * @ORM\Column(name="article_create_at", type="integer", nullable=false)
     */
    private $articleCreateAt;

    /**
     * @var string
     *
     * @ORM\Column(name="article_title", type="string", length=255, nullable=false)
     */
    private $articleTitle;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="usersArticles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article_user_id", referencedColumnName="user_id")
     * })
     */
    private $articleUser;

    /**
     * @var Languages
     *
     * @ORM\ManyToOne(targetEntity="Languages", inversedBy="articlesLanguages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article_language_id", referencedColumnName="lang_id")
     * })
     */
    private $articleLanguage;

    /**
     * @ORM\OneToMany(targetEntity="Comments", mappedBy="articleId")
     */
    private $articlesComments;

    /**
     * @ORM\OneToMany(targetEntity="Likesystem", mappedBy="articleId")
     */
    private $articlesLikesystem;

}
