<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime
     *
     * @ORM\Column(name="lang_created_at", type="datetime", nullable=false)
     */
    private $langCreatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Articles", mappedBy="langId")
     */
    private $articlesLanguages;

}
