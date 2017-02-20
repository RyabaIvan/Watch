<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhotoProduct
 *
 * @ORM\Table(name="photo_product")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\PhotoProductRepository")
 */
class PhotoProduct
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
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Product", inversedBy="productName")
     * @ORM\JoinColumn(name="product_name", referencedColumnName="id")
     */
    private $product;

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return Photo
     */
    public function getPhotonameP()
    {
        return $this->photonameP;
    }

    /**
     * @param Photo $photonameP
     */
    public function setPhotonameP($photonameP)
    {
        $this->photonameP = $photonameP;
    }

    /**
     * @param Product $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @var Photo
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Photo", inversedBy="smallFileName")
     * @ORM\JoinColumn(name="photo_name", referencedColumnName="id")
     */
    private $photonameP;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

