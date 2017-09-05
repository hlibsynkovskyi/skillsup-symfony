<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 08.08.2017
 * Time: 19:21
 */

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cart
 * @ORM\Entity()
 * @ORM\Table(name="orders")
 */
class Order
{

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Cart
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Cart" ,inversedBy="order")
     * @ORM\JoinColumn(name="cart_id", onDelete="CASCADE")
     *
     */
    protected $cart;


    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User" ,inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", onDelete="CASCADE")
     *
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(type="string" , length=255)
     * @Assert\NotBlank()
     *
     */
    protected $firstname;

    /**
     * @var string
     * @ORM\Column(type="string" , length=255)
   * @Assert\NotBlank()
     *
     */
    protected $lastname;

    /**
     * @var string
     * @ORM\Column(type="string" , length=255)
     *  @Assert\NotBlank()
     *
     */
    protected $phone;

    /**
     * @var string
     * @ORM\Column(type="string" , length=255)
     * @Assert\NotBlank()
     * @Assert\Email(
     * message = "неверный майл адресс - '{{ value }}'.",
     * checkMX = true
     *     )
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="text" )
     *
     */
    protected $address;


    /**
     * @var string
     * @ORM\Column(type="string", length=50 )
     * @Assert\NotBlank()
     *
     */
    protected $settlment;

    /**
     * @var string
     * @ORM\Column(type="string", length=50 )
     * @Assert\NotBlank()
     *
     */
    protected $warehouse;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Order
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Order
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Order
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Order
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Order
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set cart
     *
     * @param \AppBundle\Entity\Cart $cart
     *
     * @return Order
     */
    public function setCart(\AppBundle\Entity\Cart $cart = null)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return \AppBundle\Entity\Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Order
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set settlment
     *
     * @param string $settlment
     *
     * @return Order
     */
    public function setSettlment($settlment)
    {
        $this->settlment = $settlment;

        return $this;
    }

    /**
     * Get settlment
     *
     * @return string
     */
    public function getSettlment()
    {
        return $this->settlment;
    }

    /**
     * Set warehouse
     *
     * @param string $warehouse
     *
     * @return Order
     */
    public function setWarehouse($warehouse)
    {
        $this->warehouse = $warehouse;

        return $this;
    }

    /**
     * Get warehouse
     *
     * @return string
     */
    public function getWarehouse()
    {
        return $this->warehouse;
    }
}
