<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 *
 * @ORM\Entity()
 * @ORM\Table(name="products")
 */
class Product
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
	 * @var string
	 *
	 * @ORM\Column(type="string", length=250)
	 */
	protected $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="decimal", precision=10, scale=2)
	 */
	protected $price;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=250, nullable=true)
	 */
	protected $photo;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=40, nullable=true)
	 */
	protected $sku;

	/**
	 * @var Category
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="products")
	 * @ORM\JoinColumn(name="category_id", onDelete="CASCADE")
	 */
	protected $category;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $isNew;

	/**
	 * @var integer
	 *
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $discount;

	public function __construct()
	{
		$this->isNew = true;
		$this->discount = 0;
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
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->color = 'blue';

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Product
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set sku
     *
     * @param string $sku
     *
     * @return Product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set isNew
     *
     * @param boolean $isNew
     *
     * @return Product
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Get isNew
     *
     * @return boolean
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * Set discount
     *
     * @param integer $discount
     *
     * @return Product
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return integer
     */
    public function getDiscount()
    {
        return $this->discount;
    }

	/**
	 * Get discounted price.
	 *
	 * @return float
	 */
    public function getDiscountedPrice()
	{
		if ( !$this->discount ) {
			return $this->price;
		}

		return $this->price - round($this->price * $this->discount / 100, 2);
	}

}
