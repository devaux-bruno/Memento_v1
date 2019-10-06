<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="memento_pseudo", columns={"user_pseudo"}), @ORM\UniqueConstraint(name="memento_email", columns={"user_email"})})
 * @ORM\Entity
 * @UniqueEntity(fields="userPseudo", message="Pseudo déjà utilisé")
 * @UniqueEntity(fields="userEmail", message="Email déjà utilisé")
 */
class Users implements UserInterface
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
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $userPassword;

    /**
     * @var DateTime
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
     * @var DateTime
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



    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        if($this->getUserStatus() == 'admin'){
            return ['ROLE_ADMIN'];
        }
        else{
            return ['ROLE_MEMBER'];
        }
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string|null The encoded password if any
     */
    public function getPassword()
    {
        return $this->userPassword;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->userEmail;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return Users
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserPseudo()
    {
        return $this->userPseudo;
    }

    /**
     * @param string $userPseudo
     * @return Users
     */
    public function setUserPseudo($userPseudo)
    {
        $this->userPseudo = $userPseudo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserFirstname()
    {
        return $this->userFirstname;
    }

    /**
     * @param string|null $userFirstname
     * @return Users
     */
    public function setUserFirstname($userFirstname)
    {
        $this->userFirstname = $userFirstname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserLastname()
    {
        return $this->userLastname;
    }

    /**
     * @param string|null $userLastname
     * @return Users
     */
    public function setUserLastname($userLastname)
    {
        $this->userLastname = $userLastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * @param string $userEmail
     * @return Users
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * @param string $userPassword
     * @return Users
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUserRegistration()
    {
        return $this->userRegistration;
    }

    /**
     * @param DateTime $userRegistration
     * @return Users
     */
    public function setUserRegistration($userRegistration)
    {
        $this->userRegistration = $userRegistration;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserJob()
    {
        return $this->userJob;
    }

    /**
     * @param string|null $userJob
     * @return Users
     */
    public function setUserJob($userJob)
    {
        $this->userJob = $userJob;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUserBirthday()
    {
        return $this->userBirthday;
    }

    /**
     * @param DateTime $userBirthday
     * @return Users
     */
    public function setUserBirthday($userBirthday)
    {
        $this->userBirthday = $userBirthday;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserCity()
    {
        return $this->userCity;
    }

    /**
     * @param string|null $userCity
     * @return Users
     */
    public function setUserCity($userCity)
    {
        $this->userCity = $userCity;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserStatus()
    {
        return $this->userStatus;
    }

    /**
     * @param string $userStatus
     * @return Users
     */
    public function setUserStatus($userStatus)
    {
        $this->userStatus = $userStatus;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserPicture()
    {
        return $this->userPicture;
    }

    /**
     * @param string|null $userPicture
     * @return Users
     */
    public function setUserPicture($userPicture)
    {
        $this->userPicture = $userPicture;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserDescription()
    {
        return $this->userDescription;
    }

    /**
     * @param string|null $userDescription
     * @return Users
     */
    public function setUserDescription($userDescription)
    {
        $this->userDescription = $userDescription;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsersArticles()
    {
        return $this->usersArticles;
    }

    /**
     * @param mixed $usersArticles
     * @return Users
     */
    public function setUsersArticles($usersArticles)
    {
        $this->usersArticles = $usersArticles;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsersComments()
    {
        return $this->usersComments;
    }

    /**
     * @param mixed $usersComments
     * @return Users
     */
    public function setUsersComments($usersComments)
    {
        $this->usersComments = $usersComments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsersLikesystem()
    {
        return $this->usersLikesystem;
    }

    /**
     * @param mixed $usersLikesystem
     * @return Users
     */
    public function setUsersLikesystem($usersLikesystem)
    {
        $this->usersLikesystem = $usersLikesystem;
        return $this;
    }


    public function getSignature(): ?string
    {
        return $this->userFirstname.' '.$this->userLastname;
    }

}
