<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cart Item
 *
 * @ORM\Entity()
 * @ORM\Table(name="cart_items")
 */
class CartItem
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
	 * @var Cart
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cart", inversedBy="items")
	 * @ORM\JoinColumn(name="cart_id", onDelete="CASCADE")
	 */
	protected $cart;

	/**
	 * @var Product
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="cartItems")
	 * @ORM\JoinColumn(name="product_id", onDelete="CASCADE")
	 */
	protected $product;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="integer")
	 */
	protected $count;


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
     * @return CartItem
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
     * Set cart
     *
     * @param \AppBundle\Entity\Cart $cart
     *
     * @return CartItem
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
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return CartItem
     */
    public function setProduct(\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Get item cost
     *
     * @return float
     */
    public function getCost()
    {
        return $this->count * $this->product->getDiscountedPrice();
    }

}
