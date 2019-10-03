<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="memento_pseudo", columns={"user_pseudo"}), @ORM\UniqueConstraint(name="memento_email", columns={"user_email"})})
 * @ORM\Entity
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_pseudo", type="string", length=60, nullable=false)
     */
    private $userPseudo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_firstname", type="string", length=60, nullable=true)
     */
    private $userFirstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_lastname", type="string", length=60, nullable=true)
     */
    private $userLastname;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=150, nullable=false)
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=255, nullable=false)
     */
    private $userPassword;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="user_registration", type="datetime", nullable=false)
     */
    private $userRegistration;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_job", type="string", length=60, nullable=true)
     */
    private $userJob;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="user_birthday", type="date", nullable=false)
     */
    private $userBirthday;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_city", type="string", length=60, nullable=true)
     */
    private $userCity;

    /**
     * @var string
     *
     * @ORM\Column(name="user_status", type="string", length=60, nullable=false)
     */
    private $userStatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_picture", type="string", length=255, nullable=true)
     */
    private $userPicture;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_description", type="text", length=0, nullable=true)
     */
    private $userDescription;


    /**
     * @ORM\OneToMany(targetEntity="Articles", mappedBy="userId")
     */
    private $usersArticles;

    /**
     * @ORM\OneToMany(targetEntity="Comments", mappedBy="userId")
     */
    private $usersComments;

    /**
     * @ORM\OneToMany(targetEntity="Likesystem", mappedBy="userId")
     */
    private $usersLikesystem;

}
