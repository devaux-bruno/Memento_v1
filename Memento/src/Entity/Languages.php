<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Languages
 *
 * @ORM\Table(name="languages")
 * @ORM\Entity
 */
class Languages
{
    /**
     * @var int
     *
     * @ORM\Column(name="lang_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $langId;

    /**
     * @var string
     *
     * @ORM\Column(name="lang_program", type="string", length=60, nullable=false)
     */
    private $langProgram;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="lang_created_at", type="datetime", nullable=false)
     */
    private $langCreatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="lang_picture", type="string", length=255, nullable=false)
     */
    private $langPicture;

    /**
     * @var int
     *
     * @ORM\Column(name="lang_order", type="integer", nullable=false)
     */
    private $langOrder;


    /**
     * @ORM\OneToMany(targetEntity="Articles", mappedBy="langId")
     */
    private $articlesLanguages;

    /**
     * @return int
     */
    public function getLangId()
    {
        return $this->langId;
    }

    /**
     * @param int $langId
     * @return Languages
     */
    public function setLangId($langId)
    {
        $this->langId = $langId;
        return $this;
    }

    /**
     * @return string
     */
    public function getLangProgram()
    {
        return $this->langProgram;
    }

    /**
     * @param string $langProgram
     * @return Languages
     */
    public function setLangProgram($langProgram)
    {
        $this->langProgram = $langProgram;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLangCreatedAt()
    {
        return $this->langCreatedAt;
    }

    /**
     * @param DateTime $langCreatedAt
     * @return Languages
     */
    public function setLangCreatedAt($langCreatedAt)
    {
        $this->langCreatedAt = $langCreatedAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticlesLanguages()
    {
        return $this->articlesLanguages;
    }

    /**
     * @param mixed $articlesLanguages
     * @return Languages
     */
    public function setArticlesLanguages($articlesLanguages)
    {
        $this->articlesLanguages = $articlesLanguages;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLangPicture()
    {
        return $this->langPicture;
    }

    /**
     * @param string|null $langPicture
     * @return Languages
     */
    public function setLangPicture(string $langPicture)
    {
        $this->langPicture = $langPicture;
        return $this;
    }

    /**
     * @return int
     */
    public function getLangOrder(): int
    {
        return $this->langOrder;
    }

    /**
     * @param int $langOrder
     * @return Languages
     */
    public function setLangOrder(int $langOrder): Languages
    {
        $this->langOrder = $langOrder;
        return $this;
    }




}
