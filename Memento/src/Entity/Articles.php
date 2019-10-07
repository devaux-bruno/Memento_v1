<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @ORM\Column(name="article_mots_cles", type="text", length=65535, nullable=false)
     */
    private $articleMotsCles;

    /**
     * @var string
     *
     * @ORM\Column(name="article_description", type="text", length=65535, nullable=false)
     */
    private $articleDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="article_text", type="text", nullable=false)
     */
    private $articleText;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="article_create_at", type="datetime", nullable=false)
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

    /**
     * @return int
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @param int $articleId
     * @return Articles
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
        return $this;
    }

    /**
     * @return string
     */
    public function getArticleValid()
    {
        return $this->articleValid;
    }

    /**
     * @param string $articleValid
     * @return Articles
     */
    public function setArticleValid($articleValid)
    {
        $this->articleValid = $articleValid;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getArticlePicture()
    {
        return $this->articlePicture;
    }

    /**
     * @param string|null $articlePicture
     * @return Articles
     */
    public function setArticlePicture($articlePicture)
    {
        $this->articlePicture = $articlePicture;
        return $this;
    }

    /**
     * @return string
     */
    public function getArticleDescription()
    {
        return $this->articleDescription;
    }

    /**
     * @param string $articleDescription
     * @return Articles
     */
    public function setArticleDescription($articleDescription)
    {
        $this->articleDescription = $articleDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getArticleText()
    {
        return $this->articleText;
    }

    /**
     * @param string $articleText
     * @return Articles
     */
    public function setArticleText($articleText)
    {
        $this->articleText = $articleText;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getArticleCreateAt()
    {
        return $this->articleCreateAt;
    }

    /**
     * @param DateTime $articleCreateAt
     * @return Articles
     */
    public function setArticleCreateAt($articleCreateAt)
    {
        $this->articleCreateAt = $articleCreateAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getArticleTitle()
    {
        return $this->articleTitle;
    }

    /**
     * @param string $articleTitle
     * @return Articles
     */
    public function setArticleTitle($articleTitle)
    {
        $this->articleTitle = $articleTitle;
        return $this;
    }

    /**
     * @return Users
     */
    public function getArticleUser()
    {
        return $this->articleUser;
    }

    /**
     * @param Users $articleUser
     * @return Articles
     */
    public function setArticleUser(Users $articleUser): Articles
    {
        $this->articleUser = $articleUser;
        return $this;
    }

    /**
     * @return Languages
     */
    public function getArticleLanguage()
    {
        return $this->articleLanguage;
    }

    /**
     * @param Languages $articleLanguage
     * @return Articles
     */
    public function setArticleLanguage($articleLanguage)
    {
        $this->articleLanguage = $articleLanguage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticlesComments()
    {
        return $this->articlesComments;
    }

    /**
     * @param mixed $articlesComments
     * @return Articles
     */
    public function setArticlesComments($articlesComments)
    {
        $this->articlesComments = $articlesComments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticlesLikesystem()
    {
        return $this->articlesLikesystem;
    }

    /**
     * @param mixed $articlesLikesystem
     * @return Articles
     */
    public function setArticlesLikesystem($articlesLikesystem)
    {
        $this->articlesLikesystem = $articlesLikesystem;
        return $this;
    }

    /**
     * @return string
     */
    public function getArticleMotsCles()
    {
        return $this->articleMotsCles;
    }

    /**
     * @param string $articleMotsCles
     * @return Articles
     */
    public function setArticleMotsCles( $articleMotsCles)
    {
        $this->articleMotsCles = $articleMotsCles;
        return $this;
    }




}
