<?php

namespace Megogo\Bundle\PersistenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
* @ORM\Entity
* @ORM\Table(name="users")
* @UniqueEntity(fields="email", message="Email already taken",groups={"registration"})
*/
class User{
    /**
    * @ORM\Id
    * @ORM\Column(name="id", type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
    * @ORM\Column(name="email", type="string", length=255)
    * @Assert\NotBlank(
    *   groups={"registration"},
    *   message="Email shouldn't be blank"
    * )
    * @Assert\Email(
    *   groups={"registration"},
    *   message="Email must much pattern xxx@xxx.xxx"
    * )
    */
    protected $email;

    /**
     * @ORM\Column(name="shoe_size", type="integer")
     * @Assert\NotBlank(
     *      groups={"registration"},
     *      message="Shoe size shouldn't be blank"
     * )
     * @Assert\Regex(
     *      pattern="/^[0-9]{1,2}$/",
     *      message="Shoe size should contain one or two digit number",
     *      groups={"registration"}
     * )
     * @Assert\Range(
     *      min = 5,
     *      max = 13,
     *      minMessage = "Size must be at list - 5",
     *      maxMessage = "Size cannot be longer than 13",
     *      groups={"registration"}
     * )
     *
     */
    protected $shoeSize;

    /**
     * @ORM\Column(name="first_name", type="string", length=255)
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Your first name must be at least {{ limit }} characters length",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters length",
     *      groups={"registration"})
     * @Assert\NotBlank(
     *      groups={"registration"},
     *      message="Your first name shouldn't be blank"
     * )
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z]*$/",
     *      message="first name can contain only letters",
     *      groups={"registration"}
     * )
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=255)
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Your last name must be at least {{ limit }} characters length",
     *      maxMessage = "Your last name cannot be longer than {{ limit }} characters length",
     *      groups={"registration"})
     * @Assert\NotBlank(
     *      groups={"registration"},
     *      message="Last name shouldn't be blank"
     * )
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z]*$/",
     *      message="last name can contain only letters",
     *      groups={"registration"}
     * )
     */
    protected $lastName;
    /*
     * @ORM\Column(name="birthday_date", type="datetime")
     * @Assert\NotBlank(groups={"registration"})
     */
    protected $birthdayDate;


    /**
     * @ORM\Column(name="ice_cream", type="string", length=255)
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Your ice cream must be at least {{ limit }} characters length",
     *      maxMessage = "Your ice cream cannot be longer than {{ limit }} characters length",
     *      groups={"additional_data"})
     * @Assert\NotBlank(groups={"additional_data"},
     *      message="Your ice cream shouldn't be blank"
     * )
     */
    protected $iceCream;

    /**
     * @ORM\Column(name="super_hero", type="string", length=255)
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Your superhero must be at least {{ limit }} characters length",
     *      maxMessage = "Your superhero cannot be longer than {{ limit }} characters length",
     *      groups={"additional_data"})
     * @Assert\NotBlank(groups={"additional_data"},
     *      message="Your superhero shouldn't be blank"
     * )
     */
    protected $superHero;

    /**
     * @ORM\Column(name="movie_star", type="string", length=255)
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Your movieStar must be at least {{ limit }} characters length",
     *      maxMessage = "Your movieStar cannot be longer than {{ limit }} characters length",
     *      groups={"additional_data"})
     * @Assert\NotBlank(groups={"additional_data"},
     *      message="Your movieStar shouldn't be blank"
     * )
     */
    protected $movieStar;
    /*
     * @ORM\Column(name="world_end", type="datetime")
     * @Assert\NotBlank(groups={"additional_data"})
     */
    protected $worldEnd ;




    /**
     * @ORM\Column(name="super_bowl", type="string", length=255)
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Your superBowl must be at least {{ limit }} characters length",
     *      maxMessage = "Your superBowl cannot be longer than {{ limit }} characters length",
     *      groups={"additional_data"})
     * @Assert\NotBlank(groups={"additional_data"})
     */
    protected $superBowl;

    function __construct()
    {
        $this->birthdayDate = new \DateTime();
        $this->email = '';
        $this->firstName = '';
        $this->iceCream = '';
        $this->lastName = '';
        $this->movieStar = '';
        $this->shoeSize = '';
        $this->superBowl = '';
        $this->superHero = '';
        $this->worldEnd = new \DateTime();
    }


    public function getId()
    {
        return $this->id;
    }

    public function setBirthdayDate($birthdayDate)
    {
        $this->birthdayDate = $birthdayDate;
        return $this;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setShoeSize($shoeSize)
    {
        $this->shoeSize = $shoeSize;
        return $this;
    }

    public function getShoeSize()
    {
        return $this->shoeSize;
    }

    public function getBirthdayDate()
    {
        return $this->birthdayDate;
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }


    public function setIceCream($iceCream)
    {
        $this->iceCream = $iceCream;
        return $this;
    }

    public function getIceCream()
    {
        return $this->iceCream;
    }

    public function setMovieStar($movieStar)
    {
        $this->movieStar = $movieStar;
        return $this;
    }

    public function getMovieStar()
    {
        return $this->movieStar;
    }

    public function setSuperBowl($superBowl)
    {
        $this->superBowl = $superBowl;
        return $this;
    }

    public function getSuperBowl()
    {
        return $this->superBowl;
    }

    public function setSuperHero($superHero)
    {
        $this->superHero = $superHero;
        return $this;
    }

    public function getSuperHero()
    {
        return $this->superHero;
    }

    public function setWorldEnd($worldEnd)
    {
        $this->worldEnd = $worldEnd;
        return $this;
    }

    public function getWorldEnd()
    {
        return $this->worldEnd;
    }
}