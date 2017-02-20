<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\PhotoRepository")
 */
class Photo
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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, unique=true)
     */
    private $filename;


    /**
     * @var string
     *
     * @ORM\Column(name="small_file_name", type="string", length=255)
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\PhotoProduct", mappedBy="photonameP")
     */
    private $smallFileName;


    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Product", inversedBy="photos")
     * @ORM\JoinColumn(name="id_product", referencedColumnName="id", onDelete="CASCADE")
     */
    private $product;







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
     * Set title
     *
     * @param string $title
     *
     * @return Photo
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Photo
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set product
     *
     * @param \UserBundle\Entity\Product $product
     *
     * @return Photo
     */
    public function setProduct(\UserBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \UserBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }



    /**
     * @return string
     */
    public function getSmallFileName()
    {
        return $this->smallFileName;
    }
    /**
     * @param string $smallFileName
     */
    public function setSmallFileName($smallFileName)
    {
        $this->smallFileName = $smallFileName;
    }
}
