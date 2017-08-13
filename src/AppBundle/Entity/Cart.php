<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cart
 *
 * @ORM\Entity()
 * @ORM\Table(name="carts")
 */
class Cart
{

	/**
	 * @var integer
	 *
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="carts")
	 * @ORM\JoinColumn(name="user_id", onDelete="CASCADE")
	 */
	protected $user;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $count;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	protected $cost;

	/**
	 * @var CartItem[]
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\CartItem", mappedBy="cart")
	 */
	protected $items;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->count = 0;
		$this->cost = 0;
		$this->items = new \Doctrine\Common\Collections\ArrayCollection();
	}

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
     * Set count
     *
     * @param integer $count
     *
     * @return Cart
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set cost
     *
     * @param string $cost
     *
     * @return Cart
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Cart
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
     * Add item
     *
     * @param \AppBundle\Entity\CartItem $item
     *
     * @return Cart
     */
    public function addItem(\AppBundle\Entity\CartItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\CartItem $item
     */
    public function removeItem(\AppBundle\Entity\CartItem $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return CartItem[]|\Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
