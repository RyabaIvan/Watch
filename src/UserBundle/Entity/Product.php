<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\ProductRepository")
 */
class Product
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
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\PhotoProduct", mappedBy="product")
     * @ORM\Column(name="ProductName", type="string", length=255)
     */
    private $productName;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="Description", type="string", length=255)
     *
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ShortDescription", type="string", length=255)
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="IconProduct", type="string", length=255,  nullable=true)
     */
    private $iconProduct;

    /**
     * @return string
     */
    public function getIconProduct()
    {
        return $this->iconProduct;
    }

    /**
     * @param string $iconProduct
     */
    public function setIconProduct($iconProduct)
    {
        $this->iconProduct = $iconProduct;
    }


    /**
     * @var int
     *
     * @ORM\Column(name="Price", type="integer")
     */
    private $price;


    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Category", inversedBy="productList")
     * @ORM\JoinColumn(name="id_category", referencedColumnName="id")
     */
    private $category;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\Photo", mappedBy="product")
     */
    private $photos;






    public function __construct()
    {

        $this->photos = new ArrayCollection();
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
     * Set productName
     *
     * @param string $productName
     *
     * @return Product
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
     * Set shortDescription
     *
     * @param string $shortDescription
     *
     * @return Product
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set price
     *
     * @param integer $price
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
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Add photo
     *
     * @param \UserBundle\Entity\Photo $photo
     *
     * @return Product
     */
    public function addPhoto(\UserBundle\Entity\Photo $photo)
    {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \UserBundle\Entity\Photo $photo
     */
    public function removePhoto(\UserBundle\Entity\Photo $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }
}
