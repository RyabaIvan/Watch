<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\NewsRepository")
 */
class News
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
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="newsName", type="string", length=255)
     */
    private $newsName;

    /**
     * @var string
     *
     * @ORM\Column(name="newsDescription", type="text")
     */
    private $newsDescription;

    public function __construct()
    {
        $this->setData(new \DateTime("now"));

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
     * Set data
     *
     * @param \DateTime $data
     *
     * @return News
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set newsName
     *
     * @param string $newsName
     *
     * @return News
     */
    public function setNewsName($newsName)
    {
        $this->newsName = $newsName;

        return $this;
    }

    /**
     * Get newsName
     *
     * @return string
     */
    public function getNewsName()
    {
        return $this->newsName;
    }

    /**
     * Set newsDescription
     *
     * @param string $newsDescription
     *
     * @return News
     */
    public function setNewsDescription($newsDescription)
    {
        $this->newsDescription = $newsDescription;

        return $this;
    }

    /**
     * Get newsDescription
     *
     * @return string
     */
    public function getNewsDescription()
    {
        return $this->newsDescription;
    }
}

