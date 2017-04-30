<?php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @var string
     *
     * @ORM\Column(name="Category", type="string", length=255)
     */
    private $category;


    /**
     * @var string
     *
     * @ORM\Column(name="category_icon", type="string", length=255, nullable=true)
     */
    private $iconCategory;

    /**
     * @return string
     */
    public function getIconCategory()
    {
        return $this->iconCategory;
    }

    /**
     * @param string $iconCategory
     */
    public function setIconCategory($iconCategory)
    {
        $this->iconCategory = $iconCategory;
    }


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\Product", mappedBy="category" , cascade={"all"})
     */
    private $productList;

    public function addProduct(Product $product)
    {
        $product->setCategory($this);
        $this->productList [] = $product;
    }

    /**
     * @return ArrayCollection
     */
    public function getProductList()
    {
        return $this->productList;
    }

    /**
     * @param mixed Product
     */
    public function setProductList(Product $productList)
    {
        $this->productList = $productList;
    }

    public function __construct()
    {
        $this->productList = new ArrayCollection();
        $this->photoCategory = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Category
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
}

