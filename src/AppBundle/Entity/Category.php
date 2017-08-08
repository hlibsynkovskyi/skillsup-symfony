<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Intl\Data\Util\ArrayAccessibleResourceBundle;

/**
 * Class Category
 *
 * @ORM\Entity()
 * @ORM\Table(name="categories")
 */
class Category
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
	 * @var Category
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="subcategories")
	 * @ORM\JoinColumn(name="parent_id", onDelete="CASCADE")
	 */
	protected $parent;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Category", mappedBy="parent")
	 */
	protected $subcategories;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=250)
	 */
	protected $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 */
	protected $description;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=250, nullable=true)
	 */
	protected $photo;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Product", mappedBy="category")
	 */
	protected $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subcategories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Set description
     *
     * @param string $description
     *
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Category
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
     * Set parent
     *
     * @param \AppBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function setParent(\AppBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add subcategory
     *
     * @param \AppBundle\Entity\Category $subcategory
     *
     * @return Category
     */
    public function addSubcategory(\AppBundle\Entity\Category $subcategory)
    {
        $this->subcategories[] = $subcategory;

        return $this;
    }

    /**
     * Remove subcategory
     *
     * @param \AppBundle\Entity\Category $subcategory
     */
    public function removeSubcategory(\AppBundle\Entity\Category $subcategory)
    {
        $this->subcategories->removeElement($subcategory);
    }

    /**
     * Get subcategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Category
     */
    public function addProduct(\AppBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Product $product
     */
    public function removeProduct(\AppBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

	/**
	 * Returns parents in reverse order for breadcrumbs
	 *
	 * @return Category[]
	 */
    public function getParents()
	{
		$parents = [];
		$parent = $this->getParent();

		while ( $parent ) {
			$parents[] = $parent;
			$parent = $parent->getParent();
		}

		return array_reverse($parents);
	}

	public function __toString()
	{
		return $this->name;
	}

}
